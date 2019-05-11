<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Halaman_model extends CI_Model {

	var $table = 'tbl_halaman';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function cara_pemesanan()
	{
		$this->db->from($this->table);
		$this->db->where('id_halaman', 1);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function tentang_kami()
	{
		$this->db->from($this->table);
		$this->db->where('id_halaman', 2);
		$query = $this->db->get();

		return $query->row();
	}

	public function kontak()
	{
		$this->db->from($this->table);
		$this->db->where('id_halaman', 3);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function syarat_ketentuan()
	{
		$this->db->from($this->table);
		$this->db->where('id_halaman', 4);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function update_data_halaman($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
}
