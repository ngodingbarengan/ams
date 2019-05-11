<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provinsi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('provinsi_model','provinsi');
		$this->load->library('session');
		
		$id = $this->session->userdata('id_user');
		$user = $this->session->userdata('nama_user');
		$pass = $this->session->userdata('password_user');
		$hak_akses = $this->session->userdata('hak_akses_user');
		
		if(empty($user) || empty($pass) || $hak_akses != 'GUDANG')
		{
			redirect('Login_user');
		}
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('backend/provinsi_view');
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		
		
		$list = $this->provinsi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $provinsi) {
			$no++;
			$row = array();
			$row[] = $provinsi->nama_provinsi;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$provinsi->id_provinsi."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$provinsi->id_provinsi."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->provinsi->count_all(),
						"recordsFiltered" => $this->provinsi->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
	}

	public function ajax_edit($id)
	{
		$data = $this->provinsi->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		$data = array(
				'nama_provinsi' => $this->input->post('nama_Provinsi'),
			);

		$insert = $this->provinsi->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_provinsi' => $this->input->post('nama_Provinsi'),
			);

		$this->provinsi->update(array('id_provinsi' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		//delete file
		//$data = $this->provinsi->get_by_id($id);
		
		$this->provinsi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_Provinsi') == '')
		{
			$data['inputerror'][] = 'nama_Provinsi';
			$data['error_string'][] = 'Nama Provinsi Harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
	
	
}
