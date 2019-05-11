<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ongkir_model extends CI_Model {

	var $table = 'tbl_ongkir';
	var $column_order = array('a.nama_provinsi', 'b.nama_kota_kab', 'c.nama_kecamatan', 'd.id_ongkir', 'd.ongkir', null); //set column field database for datatable orderable
	var $column_search = array('a.nama_provinsi', 'b.nama_kota_kab', 'c.nama_kecamatan'); //set column field database for datatable searchable
	var $order = array('a.nama_provinsi' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	//public function cek_query()
	{
		
		$this->db->select('a.nama_provinsi, b.nama_kota_kab, c.nama_kecamatan, d.id_ongkir, d.ongkir');
		$this->db->from('tbl_provinsi a');
		$this->db->join('tbl_kota_kab b', 'a.id_provinsi = b.id_provinsi');
		$this->db->join('tbl_kecamatan c', 'b.id_kota_kab = c.id_kota_kab');
		$this->db->join('tbl_ongkir d', 'c.id_kecamatan = d.id_kecamatan');
		
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
		$this->db->select('a.id_ongkir, a.id_kecamatan, a.ongkir, b.nama_kecamatan');
		$this->db->from('tbl_ongkir a');
		$this->db->join('tbl_kecamatan b', 'a.id_kecamatan = b.id_kecamatan');
		$this->db->where('id_ongkir',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	public function get_ongkir_by_id_kecamatan($id)
	{
		$this->db->select('a.id_ongkir, a.id_kecamatan, a.ongkir, b.nama_kecamatan');
		$this->db->from('tbl_ongkir a');
		$this->db->join('tbl_kecamatan b', 'a.id_kecamatan = b.id_kecamatan');
		$this->db->where('id_ongkir',$id);
		$query = $this->db->get();

		return $query->row();
	}
	
}
