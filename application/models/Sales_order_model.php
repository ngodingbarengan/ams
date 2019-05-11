<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_model extends CI_Model {

	
	var $table_master = 'tbl_penjualan_master';
	var $table_detail = 'tbl_penjualan_detail';
	
	var $column_order = array('a.nomor_order', 'a.tanggal', ' a.waktu', 'b.nama_lengkap', 'a.no_kontak', NULL, 'c.username', NULL,'a.total_kuantitas', 'a.total_harga', 'a.total_diskon', 'a.total_ppn', 'a.grand_total', NULL); //set column field database for datatable orderable
	var $column_search = array('a.nomor_order', 'a.tanggal', 'b.nama_lengkap', 'c.username'); //set column field database for datatable searchable
	var $order = array('a.tanggal' => 'desc'); // default order 
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	
	private function _get_datatables_query($user) //private
	{
		$status = array('ORDER', 'APPROVE', 'SEND');
		
		$this->db->select('a.id_order, a.nomor_order, a.tanggal, a.waktu, b.nama_lengkap, a.no_kontak, a.alamat, d.nama_provinsi, e.nama_kota_kab, f.nama_kecamatan, c.username, a.keterangan, a.total_kuantitas, a.total_harga, a.total_diskon, a.total_ppn, a.grand_total, a.status, g.bukti_pembayaran');
		$this->db->from('tbl_penjualan_master a');
		$this->db->join('tbl_member b', 'a.id_member = b.id_member');
		$this->db->join('tbl_user c', 'a.id_user = c.id_user');
		$this->db->join('tbl_provinsi d', 'a.id_provinsi = d.id_provinsi');
		$this->db->join('tbl_kota_kab e', 'a.id_kota_kab = e.id_kota_kab');
		$this->db->join('tbl_kecamatan f', 'a.id_kecamatan = f.id_kecamatan');
		$this->db->join('tbl_konfirmasi g', 'a.nomor_order = g.nomor_order', 'left outer');
		$this->db->where('a.id_user',$user);
		$this->db->where('a.jenis_order','SO');
		$this->db->where_in('status', $status);
		
		//$query = $this->db->get();
		//return $query->result();
		
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	
	
	function get_datatables($user)
	{
		$this->_get_datatables_query($user);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function count_filtered($user)
	{
		$this->_get_datatables_query($user);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($user)
	{
		//$this->db->from($this->table_master);
		$this->_get_datatables_query($user);
		return $this->db->count_all_results();
	}

	public function get_master_by_id($id)
	{
		$this->db->select('a.id_order, a.nomor_order, a.tanggal, b.nama_lengkap, a.no_kontak, a.alamat, d.nama_provinsi, e.nama_kota_kab, f.nama_kecamatan, c.username, a.keterangan, a.total_kuantitas, a.total_harga, a.total_diskon, a.total_ppn, a.grand_total');
		$this->db->from('tbl_penjualan_master a');
		$this->db->join('tbl_member b', 'a.id_member = b.id_member');
		$this->db->join('tbl_user c', 'a.id_user = c.id_user');
		$this->db->join('tbl_provinsi d', 'a.id_provinsi = d.id_provinsi');
		$this->db->join('tbl_kota_kab e', 'a.id_kota_kab = e.id_kota_kab');
		$this->db->join('tbl_kecamatan f', 'a.id_kecamatan = f.id_kecamatan');
		$this->db->where('a.nomor_order',$id);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function get_detail_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_penjualan_detail');
		$this->db->where('nomor_order',$id);
		$query = $this->db->get();

		return $query->result();
	}
	
	//perubahan
	public function save_so_master($data_master)
	{
		$this->db->insert($this->table_master, $data_master);
		return $this->db->insert_id();
	}
	
	public function save_so_detail($data_detail)
	{
		$this->db->insert($this->table_detail, $data_detail);
		return $this->db->insert_id();
	}
	
	/*
	public function delete_by_id($id)
	{
		$this->db->where('id_merek', $id);
		$this->db->delete($this->table);
	}
	*/
	
	function cek_nomor_SO($nomor_so)
	{
		$this->db->select('nomor_order');
		$this->db->from($this->table_master);
		$this->db->where('nomor_order', $nomor_so);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function save_order_confirmation($data)
	{
		$this->db->insert('tbl_konfirmasi', $data);
		return $this->db->insert_id();
	}
	
	function get_last_number()
	{
		$this->db->select_max('id_order');
		$this->db->from($this->table_master);
		$query = $this->db->get();
		return $query->result();
	}
	
	//print function
	public function get_master_by_id_print($id)
	{
		$this->db->select('a.id_order, a.nomor_order, a.tanggal, b.nama_lengkap, a.no_kontak, a.alamat, d.nama_provinsi, e.nama_kota_kab, f.nama_kecamatan, c.username, a.keterangan, a.total_kuantitas, a.total_harga, a.total_diskon, a.total_ppn, a.grand_total');
		$this->db->from('tbl_penjualan_master a');
		$this->db->join('tbl_member b', 'a.id_member = b.id_member');
		$this->db->join('tbl_user c', 'a.id_user = c.id_user');
		$this->db->join('tbl_provinsi d', 'a.id_provinsi = d.id_provinsi');
		$this->db->join('tbl_kota_kab e', 'a.id_kota_kab = e.id_kota_kab');
		$this->db->join('tbl_kecamatan f', 'a.id_kecamatan = f.id_kecamatan');
		$this->db->where('a.id_order',$id);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function get_detail_by_id_print($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_penjualan_detail');
		$this->db->where('id_order',$id);
		$query = $this->db->get();

		return $query->result();
	}
	
	
	//view approval sales order
	private function app_so_get_datatables_query() //private
	{
		
		$this->db->select('a.nomor_order, a.tanggal, a.waktu, b.nama_lengkap, a.no_kontak, a.alamat, d.nama_provinsi, e.nama_kota_kab, f.nama_kecamatan, c.username, a.keterangan, a.total_kuantitas, a.total_harga, a.total_diskon, a.total_ppn, a.grand_total, g.bukti_pembayaran');
		$this->db->from('tbl_penjualan_master a');
		$this->db->join('tbl_member b', 'a.id_member = b.id_member');
		$this->db->join('tbl_user c', 'a.id_user = c.id_user');
		$this->db->join('tbl_provinsi d', 'a.id_provinsi = d.id_provinsi');
		$this->db->join('tbl_kota_kab e', 'a.id_kota_kab = e.id_kota_kab');
		$this->db->join('tbl_kecamatan f', 'a.id_kecamatan = f.id_kecamatan');
		$this->db->join('tbl_konfirmasi g', 'a.nomor_order = g.nomor_order', 'left outer');
		$this->db->where('a.jenis_order','SO');
		$this->db->where('a.status', 'ORDER');
		$this->db->order_by("a.status", "desc"); 
		
		//$query = $this->db->get();
		//return $query->result();
		
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	
	
	function app_so_get_datatables()
	{
		$this->app_so_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function app_so_count_filtered()
	{
		$this->app_so_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function app_so_count_all()
	{
		//$this->db->from($this->table_master);
		$this->app_so_get_datatables_query();
		return $this->db->count_all_results();
	}
	
	public function app_get_stok_produk($id_produk)
	{
		$this->db->select('stok');
		$this->db->from('tbl_produk');
		$this->db->where('id_produk',$id_produk);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function kurangi_stok($where, $data)
	{
		$this->db->update('tbl_produk', $data, $where);
		return $this->db->affected_rows();
	}
	
	public function ubah_status($where, $data)
	{
		$this->db->update('tbl_penjualan_master', $data, $where);
		return $this->db->affected_rows();
	}

}
