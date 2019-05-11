<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_pengiriman extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('jenis_pengiriman_model','pengiriman');
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
		$this->load->view('backend/jenis_pengiriman_view');
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		
		
		$list = $this->pengiriman->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pengiriman) {
			$no++;
			$row = array();
			$row[] = $pengiriman->jenis_pengiriman;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$pengiriman->id_jenis_pengiriman."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$pengiriman->id_jenis_pengiriman."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pengiriman->count_all(),
						"recordsFiltered" => $this->pengiriman->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
	}

	public function ajax_edit($id)
	{
		$data = $this->pengiriman->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		$data = array(
				'jenis_pengiriman' => $this->input->post('jenis_Pengiriman'),
			);

		$insert = $this->pengiriman->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'jenis_pengiriman' => $this->input->post('jenis_Pengiriman'),
			);

		$this->pengiriman->update(array('id_jenis_pengiriman' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->pengiriman->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('jenis_Pengiriman') == '')
		{
			$data['inputerror'][] = 'jenis_Pengiriman';
			$data['error_string'][] = 'Masukkan isian jenis pengiriman';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
	
	
}
