<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('satuan_model','satuan');
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
		$this->load->view('backend/satuan_view');
	}

	public function ajax_list()
	{
		$this->load->helper('url');

		$list = $this->satuan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $satuan) {
			$no++;
			$row = array();
			$row[] = $satuan->kd_satuan;
			$row[] = $satuan->nama_satuan;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$satuan->id_satuan."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$satuan->id_satuan."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->satuan->count_all(),
						"recordsFiltered" => $this->satuan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->satuan->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		$data = array(
				'kd_satuan' => $this->input->post('kd_Satuan'),
				'nama_satuan' => $this->input->post('nama_Satuan'),
			);

		$insert = $this->satuan->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'kd_satuan' => $this->input->post('kd_Satuan'),
				'nama_satuan' => $this->input->post('nama_Satuan'),
			);

		$this->satuan->update(array('id_satuan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		//delete file
		$data = $this->satuan->get_by_id($id);
		
		$this->satuan->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('kd_Satuan') == '')
		{
			$data['inputerror'][] = 'kd_Satuan';
			$data['error_string'][] = 'Kode Satuan harus diisi';
			$data['status'] = FALSE;
		}

		if($this->input->post('nama_Satuan') == '')
		{
			$data['inputerror'][] = 'nama_Satuan';
			$data['error_string'][] = 'Nama Satuan Harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
