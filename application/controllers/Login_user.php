<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_user extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('user_model', 'user');
	}
	
	public function index()
	{
		
		if($this->input->is_ajax_request())
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email','Email','trim|required|min_length[3]|max_length[40]');
			$this->form_validation->set_rules('password','Password','trim|required|min_length[3]|max_length[40]');
			$this->form_validation->set_message('required','%s harus diisi !');
			
			if($this->form_validation->run() == TRUE)
			{	
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				
				$validasi_login = $this->user->validasi_login_user($email, $password);
				
				if($validasi_login->num_rows() > 0)
				{
					$data_user = $validasi_login->row();
	
					$session = array(
						'id_user' => $data_user->id_user,
						'email_user' => $data_user->email,
						'nama_user' => $data_user->username,
						'password_user' => $data_user->password,
						'hak_akses_user' => $data_user->hak_akses 
					);
					$this->session->set_userdata($session);	
					
					//last_login
					date_default_timezone_set('Asia/Jakarta');
					$update = date('Y-m-d H:i:s');
					
					$data = array(
							'login_terakhir' => $update
						);
					$this->user->update(array('id_user' => $data_user->id_user), $data);
					
					if($data_user->hak_akses == 'ADMINISTRATOR')
					{
						$URL_home = site_url('approval/app_co');
					}
					if($data_user->hak_akses == 'SALES')
					{
						$URL_home = site_url('sales_order/index');
					}
					if($data_user->hak_akses == 'GUDANG')
					{
						$URL_home = site_url('purchase_order/index');
					}
				
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
			$this->load->view('backend/login_view');
		}
	}
	
	public function logout()
	{	
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('nama_user');
		$this->session->unset_userdata('email_user');
		$this->session->unset_userdata('password_user');
		$this->session->unset_userdata('hak_akses_user');

		redirect('login_user');
	}
	
}
