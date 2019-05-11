<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merek extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('merek_model','merek');
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
		$this->load->view('backend/merek_view');
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		
		
		$list = $this->merek->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $merek) {
			$no++;
			$row = array();
			$row[] = $merek->nama_merek;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$merek->id_merek."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$merek->id_merek."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->merek->count_all(),
						"recordsFiltered" => $this->merek->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
	}

	public function ajax_edit($id)
	{
		$data = $this->merek->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		$data = array(
				'nama_merek' => $this->input->post('nama_Merek'),
			);

		$insert = $this->merek->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_merek' => $this->input->post('nama_Merek'),
			);

		$this->merek->update(array('id_merek' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->merek->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_Merek') == '')
		{
			$data['inputerror'][] = 'nama_Merek';
			$data['error_string'][] = 'Nama Merek Harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
	
	
}
