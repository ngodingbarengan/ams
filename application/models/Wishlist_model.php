<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wishlist_model extends CI_Model {

	var $table = 'tbl_favorit';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
		
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_favorit', $id);
		$this->db->delete($this->table);
	}
}
