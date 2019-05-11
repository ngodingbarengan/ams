<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {

	var $table = 'tbl_produk';
	var $column_order = array('b.id_kategori','b.nama_kategori', 'a.kd_produk', 'a.nama_produk', 'c.id_merek','c.nama_merek', 'd.id_satuan','d.nama_satuan', 'a.berat', 'a.harga', 'a.stok', null); //set column field database for datatable orderable //harus berurut dengan data yang ditampilkan, bila tidak berurut maka sorting data akan gagal
	var $column_search = array('b.nama_kategori','a.kd_produk','a.nama_produk','c.nama_merek'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('a.kd_produk' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function _get_datatables_query()
	{
		$this->db->select('a.id_produk, b.id_kategori, b.nama_kategori, a.kd_produk, a.nama_produk, c.id_merek, c.nama_merek, d.id_satuan, d.nama_satuan, a.berat, a.harga, a.stok, a.deskripsi, a.foto_1, a.foto_2, a.foto_3, a.foto_4, a.foto_5, a.aktif');
		$this->db->from('tbl_produk a');
		$this->db->join('tbl_kategori b', 'a.id_kategori = b.id_kategori');
		$this->db->join('tbl_merek c', 'a.id_merek = c.id_merek');
		$this->db->join('tbl_satuan d', 'a.id_satuan = d.id_satuan');
		
		
		//$query = $this->db->get();
		//return $query->result_array();

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

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_produk',$id);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function get_category_name($id)
	{
		$this->db->select('nama_kategori');
		$this->db->from('tbl_kategori');
		$this->db->where('id_kategori',$id);
		$query = $this->db->get();
		return $query->row();
		//return $this->db->get();
	}
	
	public function get_product_by_category($id, $limit, $start = 0)
	{
		
		$this->db->select('a.id_produk, b.id_favorit, b.id_member, a.id_kategori, a.kd_produk, a.nama_produk, a.id_merek, a.id_satuan, a.berat, a.harga, a.stok, a.deskripsi, a.foto_1, a.foto_2, a.foto_3, a.foto_4, a.foto_5, a.aktif');
		$this->db->from('tbl_produk a');
		$this->db->join('tbl_favorit b', 'a.id_produk = b.id_produk', 'left outer');
		$this->db->where('id_kategori',$id);
		$this->db->where('aktif', 'Y');
		$this->db->order_by('a.nama_produk', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();

	}

	
	function count_all_product_by_category($id)
	{	
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id_kategori',$id);
		$this->db->where('aktif', 'Y');

		return $this->db->count_all_results();
	}
	
	
	public function get_by_id_view($id)
	{
		$this->db->select('a.id_produk, b.id_kategori, b.nama_kategori, a.kd_produk, a.nama_produk, c.id_merek, c.nama_merek, d.id_satuan, d.nama_satuan, a.berat, a.harga, a.stok, a.deskripsi, a.foto_1, a.foto_2, a.foto_3, a.foto_4, a.foto_5, a.aktif');
		$this->db->from('tbl_produk a');
		$this->db->join('tbl_kategori b', 'a.id_kategori = b.id_kategori');
		$this->db->join('tbl_merek c', 'a.id_merek = c.id_merek');
		$this->db->join('tbl_satuan d', 'a.id_satuan = d.id_satuan');
		$this->db->where('id_produk',$id);
		$query = $this->db->get();
		
		return $query->row();
	}
	
	public function get_by_id_kategori($produkID, $kategoriID)
	{
		$this->db->select('a.id_produk, b.id_kategori, b.nama_kategori, a.kd_produk, a.nama_produk, c.id_merek, c.nama_merek, d.id_satuan, d.nama_satuan, a.berat, a.harga, a.stok, a.deskripsi, a.foto_1, a.foto_2, a.foto_3, a.foto_4, a.foto_5, a.aktif, e.id_favorit');
		$this->db->from('tbl_produk a');
		$this->db->join('tbl_kategori b', 'a.id_kategori = b.id_kategori');
		$this->db->join('tbl_merek c', 'a.id_merek = c.id_merek');
		$this->db->join('tbl_satuan d', 'a.id_satuan = d.id_satuan');
		$this->db->join('tbl_favorit e', 'a.id_produk = e.id_produk','left outer'); //bisa menggunakan left outer join
		$this->db->where('a.id_kategori',$kategoriID);
		$this->db->where_not_in('a.id_produk', $produkID);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_produk', $id);
		$this->db->delete($this->table);
	}

	public function get_kategori_list()
	{
		$this->db->from('tbl_kategori');
		$this->db->order_by('nama_kategori');
		$query = $this->db->get();
		
		foreach ($query->result() as $row)
        {
            $result[0]= '-Pilih Kategori-';
            $result[$row->id_kategori]= $row->nama_kategori;
        }
        return $result;
		
		//return $query->row(); //return an object
	}
	
	public function get_kategori_view()
	{
		$this->db->from('tbl_kategori');
		$this->db->order_by('nama_kategori');
		$query = $this->db->get();
		
        return $query->result_array();
		
		//return $query->row(); //return an object
	}
	
	public function get_merek_list()
	{
		$this->db->from('tbl_merek');
		$this->db->order_by('nama_merek');
		$query = $this->db->get();
		
		foreach ($query->result() as $row)
        {
            $result[0]= '-Pilih Merek-';
            $result[$row->id_merek]= $row->nama_merek;
        }
        return $result;
		
		//return $query->row(); //return an object
	}
	
	public function get_satuan_list()
	{
		$this->db->from('tbl_satuan');
		$this->db->order_by('nama_satuan');
		$query = $this->db->get();
		
		foreach ($query->result() as $row)
        {
            $result[0]= '-Pilih Satuan-';
            $result[$row->id_satuan]= $row->nama_satuan;
        }
        return $result;
		
		//return $query->row(); //return an object
	}
	
	public function get_kode_produk($kode_produk)
	{	
		$this->db->select('kd_produk');
		$this->db->from('tbl_produk');
		$this->db->where('kd_produk', $kode_produk);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_data_produk()
	{	
		$this->db->select('*');
		$this->db->from('tbl_produk');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_all_product_index($limit, $start = 0)
	{
		
		$this->db->select('a.id_produk, b.id_favorit, b.id_member, a.id_kategori, a.kd_produk, a.nama_produk, a.id_merek, a.id_satuan, a.berat, a.harga, a.stok, a.deskripsi, a.foto_1, a.foto_2, a.foto_3, a.foto_4, a.foto_5, a.aktif');
		$this->db->from('tbl_produk a');
		$this->db->join('tbl_favorit b', 'a.id_produk = b.id_produk', 'left outer');
		$this->db->where('aktif', 'Y');
		$this->db->order_by('a.nama_produk', 'DESC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}
	
	function wishlist($id_member, $limit, $start = 0)
	{	
		$this->db->select('*');
		$this->db->from('tbl_produk');
		$this->db->join('tbl_favorit', 'tbl_produk.id_produk = tbl_favorit.id_produk', 'left outer');
		$this->db->where('id_member', $id_member);
		$this->db->where('aktif', 'Y');
		$this->db->order_by('kd_produk', 'DESC');
        $this->db->limit($limit, $start);
		return $this->db->get();
	}
	
	function search($keyword)
	{	
		$this->db->select('a.id_produk, b.id_favorit, b.id_member, a.id_kategori, a.kd_produk, a.nama_produk, a.id_merek, a.id_satuan, a.berat, a.harga, a.stok, a.deskripsi, a.foto_1, a.foto_2, a.foto_3, a.foto_4, a.foto_5, a.aktif');
		$this->db->from('tbl_produk a');
		$this->db->join('tbl_favorit b', 'a.id_produk = b.id_produk', 'left outer');
		$this->db->like('a.nama_produk', $keyword);
		$this->db->where('aktif', 'Y');
		$this->db->order_by('a.nama_produk', 'DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function count_all_wishlist($id_member)
	{
		$this->db->select('*');
		$this->db->from('tbl_produk');
		$this->db->join('tbl_favorit', 'tbl_produk.id_produk = tbl_favorit.id_produk', 'left outer');
		$this->db->where('aktif', 'Y');
		$this->db->where('id_member', $id_member);
		$this->db->order_by('kd_produk', 'DESC');
		return $this->db->count_all_results();
	}
	
	public function cari_kode($keyword)
	{
		$this->db->select('id_produk,kd_produk, nama_produk, berat, harga, stok');
		$this->db->from('tbl_produk');
		$this->db->like('kd_produk', $keyword);
		$this->db->or_like('nama_produk', $keyword); 
		$this->db->order_by('kd_produk', 'ASC');
		$this->db->limit(10, 0);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function get_jumlah_order_by_id($keyword)
	{
		$this->db->select_sum('kuantitas');
		$this->db->from('tbl_penjualan_detail a');
		$this->db->join('tbl_penjualan_master b', 'a.nomor_order = b.nomor_order');
		$this->db->where('id_produk', $keyword);
		$this->db->where('status', 'ORDER');
		$query = $this->db->get();
		return $query->result();
	}
	
}
