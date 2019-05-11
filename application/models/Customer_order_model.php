<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_order_model extends CI_Model {

	
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
	
	public function get_transaction_by_id($id)
	{
		$status = array('ORDER', 'APPROVE', 'SEND');
		
		$this->db->select('a.nomor_order, a.tanggal, a.nama_lengkap, a.no_kontak, a.alamat, d.nama_provinsi, e.nama_kota_kab, f.nama_kecamatan, c.username, a.keterangan, a.total_kuantitas, a.total_berat, a.total_harga, a.total_diskon, a.total_ppn, a.grand_total, a.ongkir, a.status, g.bukti_pembayaran');
		$this->db->from('tbl_penjualan_master a');
		$this->db->join('tbl_member b', 'a.id_member = b.id_member');
		$this->db->join('tbl_user c', 'a.id_user = c.id_user');
		$this->db->join('tbl_provinsi d', 'a.id_provinsi = d.id_provinsi');
		$this->db->join('tbl_kota_kab e', 'a.id_kota_kab = e.id_kota_kab');
		$this->db->join('tbl_kecamatan f', 'a.id_kecamatan = f.id_kecamatan');
		$this->db->join('tbl_konfirmasi g', 'a.nomor_order = g.nomor_order', 'left outer');
		$this->db->where('a.id_member',$id);
		$this->db->where('a.jenis_order','CO');
		$this->db->where_in('status', $status);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_history_by_id($id)
	{
		$status = array('CANCEL', 'FINISH');
		
		$this->db->select('a.nomor_order, a.tanggal, a.nama_lengkap, a.no_kontak, a.alamat, d.nama_provinsi, e.nama_kota_kab, f.nama_kecamatan, c.username, a.keterangan, a.total_kuantitas, a.total_berat, a.total_harga, a.total_diskon, a.total_ppn, a.grand_total, a.ongkir, a.status, g.no_resi, g.bukti_pembayaran, h.jenis_pengiriman');
		$this->db->from('tbl_penjualan_master a');
		$this->db->join('tbl_member b', 'a.id_member = b.id_member');
		$this->db->join('tbl_user c', 'a.id_user = c.id_user');
		$this->db->join('tbl_provinsi d', 'a.id_provinsi = d.id_provinsi');
		$this->db->join('tbl_kota_kab e', 'a.id_kota_kab = e.id_kota_kab');
		$this->db->join('tbl_kecamatan f', 'a.id_kecamatan = f.id_kecamatan');
		$this->db->join('tbl_konfirmasi g', 'a.nomor_order = g.nomor_order', 'left outer');
		$this->db->join('tbl_jenis_pengiriman h', 'g.id_jenis_pengiriman = h.id_jenis_pengiriman');
		$this->db->where('a.id_member',$id);
		$this->db->where('a.jenis_order','CO');
		$this->db->where_in('status', $status);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function get_cancel_by_id($id)
	{
		$this->db->select('a.nomor_order, a.tanggal, a.nama_lengkap, a.no_kontak, a.alamat, d.nama_provinsi, e.nama_kota_kab, f.nama_kecamatan, c.username, a.keterangan, a.total_kuantitas, a.total_berat, a.total_harga, a.total_diskon, a.total_ppn, a.grand_total, a.ongkir, g.bukti_pembayaran');
		$this->db->from('tbl_penjualan_master a');
		$this->db->join('tbl_member b', 'a.id_member = b.id_member');
		$this->db->join('tbl_user c', 'a.id_user = c.id_user');
		$this->db->join('tbl_provinsi d', 'a.id_provinsi = d.id_provinsi');
		$this->db->join('tbl_kota_kab e', 'a.id_kota_kab = e.id_kota_kab');
		$this->db->join('tbl_kecamatan f', 'a.id_kecamatan = f.id_kecamatan');
		$this->db->join('tbl_konfirmasi g', 'a.nomor_order = g.nomor_order', 'left outer');
		$this->db->where('a.id_member',$id);
		$this->db->where('a.jenis_order','CO');
		$this->db->where('status','CANCEL');
		$query = $this->db->get();

		return $query->result();
	}
	
	public function get_detail_by_id($id)
	{
		$this->db->select('a.id_produk, a.kd_produk, a.nama_produk, a.kuantitas, a.berat, a.jumlah_berat, a.harga, a.jumlah_harga, b.foto_1');
		$this->db->from('tbl_penjualan_detail a');
		$this->db->join('tbl_produk b', 'a.id_produk = b.id_produk');
		$this->db->where('nomor_order',$id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function save_co_master($data_master)
	{
		$this->db->insert($this->table_master, $data_master);
		return $this->db->insert_id();
	}
	
	public function save_co_detail($data_detail)
	{
		$this->db->insert($this->table_detail, $data_detail);
		return $this->db->insert_id();
	}
	
	public function save_order_confirmation($data)
	{
		$this->db->insert('tbl_konfirmasi', $data);
		return $this->db->insert_id();
	}
	
	function cek_nomor_CO($nomor_co)
	{
		$this->db->select('nomor_order');
		$this->db->from($this->table_master);
		$this->db->where('nomor_order', $nomor_co);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_last_number()
	{
		$this->db->select_max('id_order');
		$this->db->from($this->table_master);
		$query = $this->db->get();
		return $query->result();
	}
	
	//view approval customer order
	private function app_co_get_datatables_query() //private
	{
		
		$this->db->select('a.nomor_order, a.tanggal, a.waktu, a.nama_lengkap, a.no_kontak, a.alamat, d.nama_provinsi, e.nama_kota_kab, f.nama_kecamatan, c.username, a.keterangan, a.total_kuantitas, a.total_harga, a.total_diskon, a.total_ppn, a.grand_total, a.ongkir, g.bukti_pembayaran');
		$this->db->from('tbl_penjualan_master a');
		$this->db->join('tbl_member b', 'a.id_member = b.id_member');
		$this->db->join('tbl_user c', 'a.id_user = c.id_user');
		$this->db->join('tbl_provinsi d', 'a.id_provinsi = d.id_provinsi');
		$this->db->join('tbl_kota_kab e', 'a.id_kota_kab = e.id_kota_kab');
		$this->db->join('tbl_kecamatan f', 'a.id_kecamatan = f.id_kecamatan');
		$this->db->join('tbl_konfirmasi g', 'a.nomor_order = g.nomor_order', 'left outer');
		$this->db->where('a.jenis_order','CO');
		$this->db->where('a.status', 'ORDER');
		
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
	
	
	function app_co_get_datatables()
	{
		$this->app_co_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	function app_co_count_filtered()
	{
		$this->app_co_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function app_co_count_all()
	{
		//$this->db->from($this->table_master);
		$this->app_co_get_datatables_query();
		return $this->db->count_all_results();
	}
	
	public function app_get_master_by_id($id)
	{
		$this->db->select('a.nomor_order, a.tanggal, a.nama_lengkap, a.no_kontak, a.alamat, d.nama_provinsi, e.nama_kota_kab, f.nama_kecamatan, c.username, a.keterangan, a.total_kuantitas, a.total_harga, a.total_diskon, a.total_ppn, a.grand_total, a.ongkir');
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
	
	public function app_get_detail_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_penjualan_detail');
		$this->db->where('nomor_order',$id);
		$query = $this->db->get();

		return $query->result();
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
