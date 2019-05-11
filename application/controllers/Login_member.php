<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_member extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('my_cart');
		$this->load->model('user_model', 'user');
	}
	
	public function index()
	{
		
		if($this->input->is_ajax_request())
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email','Username / Email','trim|required|min_length[3]|max_length[40]');
			$this->form_validation->set_rules('password','Password','trim|required|min_length[3]|max_length[40]');
			$this->form_validation->set_message('required','%s harus diisi !');
			
			if($this->form_validation->run() == TRUE)
			{	
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				
				$validasi_login = $this->user->validasi_login_member($email, $password);
				
				if($validasi_login->num_rows() > 0)
				{
					$data_user = $validasi_login->row();
	
					$session = array(
						'id_user' => $data_user->id_user,
						'id_member' => $data_user->id_member,
						'email_member' => $data_user->email,
						'nama_member' => $data_user->nama_lengkap,
						'password_member' => $data_user->password,
						'kecamatan_member' => $data_user->id_kecamatan 
					);
					$this->session->set_userdata($session);	
					
					//last_login
					date_default_timezone_set('Asia/Jakarta');
					$update = date('Y-m-d H:i:s');
					
					$data = array(
							'login_terakhir' => $update
						);
					$this->user->update(array('id_user' => $data_user->id_user), $data);
					
					$URL_home = site_url('home/index');
				
					$json['status']		= 1;
					$json['url_home'] 	= $URL_home;
					echo json_encode($json);
					
				}
				else
				{
					$pesan = "Login gagal, cek kembali kombinasi email & password !";
					$json['status'] = 2;
					$json['pesan'] 	= "<div class='alert alert-danger error_validasi'>".$pesan."</div>";
					echo json_encode($json);
				}
			}
			else{
				$data['status'] = 3;
				$data['pesan'] 	= "<div class='alert alert-warning error_validasi'>".validation_errors() ."</div>"; //menampilkan error pada library form_validation CI
				echo json_encode($data);
				
			}
		}
		else{
			// $this->load->view('login');
			$this->load->view('tes_login');
		}
	}
	
	public function logout()
	{	
		//hapus semua data member
		$this->session->unset_userdata('id_member');
		$this->session->unset_userdata('nama_member');
		$this->session->unset_userdata('email_member');
		$this->session->unset_userdata('password_member');
		$this->session->unset_userdata('kecamatan_member');
		
		//hapus semua isi cart
		$this->my_cart->destroy();

		redirect('login_member');
	}
	
	
	public function cek()
	{

		echo CI_VERSION; // echoes something like 1.7.1
		/*
		$email = 'Customer1';
		
		$password = 'ya1234';
		

		$validasi_login = $this->user->validasi_login_member($email, $password)->result();
		
		print_r($validasi_login);
		echo $validasi_login->username;
		
		foreach ($validasi_login as $row)
		{
			echo $row->nama_lengkap;
			echo $row->email;
		}
		
		
		$row = $this->user->validasi_login_member($email, $password)->row();
		
			echo $row->nama_lengkap;
			echo $row->email;
		*/
	}

}
