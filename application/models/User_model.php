<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	var $table = 'tbl_user';
	var $table_member = 'tbl_member';
	var $column_order = array('id_user', 'username', 'email', 'hak_akses', 'ditambahkan', 'login_terakhir', 'terakhir_diubah', 'oleh', null, null); //set column field database for datatable orderable
	var $column_search = array('id_user','email'); //set column field database for datatable searchable
	var $order = array('id_user' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

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
		$this->db->where('id_user',$id);
		$query = $this->db->get();

		return $query->row();
	}
	
	public function get_by_id_member($id)
	{
		$this->db->from($this->table_member);
		$this->db->where('id_member',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function save_member($data_member)
	{
		$this->db->insert($this->table_member, $data_member);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	public function update_member($where, $data_member)
	{
		$this->db->update($this->table_member, $data_member, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_user', $id);
		$this->db->delete($this->table);
	}
	
	function validasi_login_member($email, $password) //$email, $password
	{		
		$this->db->select('a.id_user, a.id_member, a.email, b.nama_lengkap, a.password, b.id_kecamatan, a.hak_akses');
		$this->db->from('tbl_user a');
		$this->db->join('tbl_member b', 'a.id_member = b.id_member');
		$this->db->where('a.email', $email);
		$this->db->where('a.password', $password);//sha1($password)
		$this->db->or_where('a.username', $email);
		$this->db->where('a.password', $password);//sha1($password)
		$this->db->where('hak_akses', 'CUSTOMER');
		$this->db->where('a.aktif', 'Y');
		$this->db->limit(1);
		return $this->db->get();
	}
	
	
	function validasi_login_user($email, $password) //$email, $password
	{
		return $this->db
			->select('id_user, username, email, password, hak_akses')
			->where('email', $email)
			->where('password', $password)//sha1($password) if you want to hash password text
			->where('aktif', 'Y')
			->where_not_in('hak_akses', 'CUSTOMER')
			->limit(1)
			->get('tbl_user');
	}
	
	function cek_email($email)
	{
		$this->db->select('email');
		$this->db->from('tbl_user');
		$this->db->where('email', $email);
		$this->db->limit(1);
		$query = $this->db->get();
		//return $query->result();
		return $query->row();
	}
	
	function cek_username($username)
	{
		$this->db->select('username');
		$this->db->from('tbl_user');
		$this->db->where('username', $username);
		$this->db->limit(1);
		$query = $this->db->get();
		//return $query->result();
		return $query->row();
	}
	
	function id_member_max()
	{
		$this->db->select_max('id_member');
		$this->db->from($this->table_member);
		$query = $this->db->get();
		return $query->result();
	}
}
