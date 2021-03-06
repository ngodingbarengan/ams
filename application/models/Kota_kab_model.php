<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kota_kab_model extends CI_Model {
	
	//var $table = 'select b.id_kota_kab, b.nama_kota_kab, a.id_provinsi, a.nama_provinsi from tbl_provinsi a INNER JOIN tbl_kota_kab b where a.id_provinsi = b.id_provinsi';
	
	var $column = array('b.id_kota_kab', 'b.nama_kota_kab', 'a.id_provinsi', 'a.nama_provinsi'); //set column field to show 
	var	$column_order = array('b.nama_kota_kab', null,'a.nama_provinsi', null); //set column field database for datatable orderable it's depend on your column total
	var	$column_search = array('b.nama_kota_kab','a.nama_provinsi'); //set column field database for datatable searchable
	var	$order = array('a.nama_provinsi' => 'asc'); // default order
	
	var $table = 'tbl_provinsi';
	var $table_kota = 'tbl_kota_kab';
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{ 
		
		$this->db->select('a.id_provinsi, a.nama_provinsi, b.id_kota_kab , b.nama_kota_kab');
		$this->db->from('tbl_provinsi a');
		$this->db->join('tbl_kota_kab b', 'b.id_provinsi = a.id_provinsi');
		
		
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
			$column[$i] = $item; //set column array variable to order processing
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
		$query = $this->db->limit($_POST['length'], $_POST['start']);
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
		$this->db->from($this->table_kota);
		$this->db->where('id_kota_kab',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table_kota, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table_kota, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_kota_kab', $id);
		$this->db->delete($this->table_kota);
	}
	
	//coba list provinsi "option select"
	public function get_provinsi_list()
	{
		$this->db->from($this->table);
		$query = $this->db->get();
		
		foreach ($query->result() as $row)
        {
            $result[0]= '-Pilih Provinsi-';
            $result[$row->id_provinsi]= $row->nama_provinsi;
        }
        return $result;
		
		//return $query->row(); //return an object
	}
	
	public function get_by_id_prov($selectValues)
	{
		$this->db->from($this->table_kota);
		$this->db->where('id_provinsi',$selectValues);
		$query = $this->db->get();

		return $query->result_array();
	}
	
}
