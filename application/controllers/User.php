<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model','user');
		$this->load->library('session');
		
		$id = $this->session->userdata('id_user');
		$user = $this->session->userdata('nama_user');
		$pass = $this->session->userdata('password_user');
		$hak_akses = $this->session->userdata('hak_akses_user');
		
		if(empty($id) || empty($pass) || $hak_akses != 'ADMINISTRATOR')
		{
			redirect('Login_user');
		}
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('backend/user_view');
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->user->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $user) {
			$no++;
			$row = array();
			$row[] = $user->id_user;
			$row[] = $user->username;
			$row[] = $user->email;
			$row[] = $user->hak_akses;
			$row[] = $user->ditambahkan;
			$row[] = $user->login_terakhir;
			$row[] = $user->terakhir_diubah;
			$row[] = $user->oleh;			
			$row[] = '<span class="badge badge-info">'.$user->aktif.'</span>';

			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$user->id_user."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$user->id_user."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->user->count_all(),
						"recordsFiltered" => $this->user->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->user->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		date_default_timezone_set('Asia/Jakarta');
		
		$add_on = date('Y-m-d H:i:s');
		
		//echo $now;
		
		$data = array(
				'email' => $this->input->post('Email'),
				'username' => $this->input->post('Username'),
				'password' => $this->input->post('Password'),
				'hak_akses' => $this->input->post('Hak_Akses'),
				'aktif' => $this->input->post('Aktif'),
				'ditambahkan' => $add_on,
				'oleh' => $this->session->userdata('id_user')
			);
		$insert = $this->user->save($data);

		echo json_encode(array("status" => TRUE));
	}
	

	public function ajax_update()
	{
		$this->_validate();
		
		date_default_timezone_set('Asia/Jakarta');
		
		$update = date('Y-m-d H:i:s');
		
		$data = array(
				'email' => $this->input->post('Email'),
				'username' => $this->input->post('Username'),
				'password' => $this->input->post('Password'),
				'hak_akses' => $this->input->post('Hak_Akses'),
				'aktif' => $this->input->post('Aktif'),
				'terakhir_diubah' => $update,
				'oleh' => $this->session->userdata('id_user'),
			);
		//
		$this->user->update(array('id_user' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		//delete file
		$data = $this->user->get_by_id($id);
		
		$this->user->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('Email') == '')
		{
			$data['inputerror'][] = 'Email';
			$data['error_string'][] = 'Email Harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Password') == '')
		{
			$data['inputerror'][] = 'Password';
			$data['error_string'][] = 'Password harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Hak_Akses') == '')
		{
			$data['inputerror'][] = 'Hak_Akses';
			$data['error_string'][] = 'Pilih hak akses';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Aktif') == '')
		{
			$data['inputerror'][] = 'Aktif';
			$data['error_string'][] = 'Pilih opsi dahulu';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
