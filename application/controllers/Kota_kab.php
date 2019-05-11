<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kota_kab extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kota_kab_model','kota_kab');
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
		
		$data['option_provinsi'] = $this->kota_kab->get_provinsi_list();
		$this->load->view('backend/kota_kab_view',$data);
	}
	
	/*
	public function select_kota($selectValues)
	{
		
		$data = $this->kota_kab->get_by_id_prov($selectValues);
		echo json_encode($data);
	}*/

	public function ajax_list()
	{
		$this->load->helper('url');
		
		$list = $this->kota_kab->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list as $kota_kab) {
			$no++;
			$row = array();
			//$row[] = $kota_kab->id_kota_kab;
			$row[] = $kota_kab->id_provinsi;
			$row[] = $kota_kab->nama_provinsi;
			$row[] = $kota_kab->nama_kota_kab;
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$kota_kab->id_kota_kab."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$kota_kab->id_kota_kab."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->kota_kab->count_all(),
						"recordsFiltered" => $this->kota_kab->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
	}
	
	public function ajax_edit($id)
	{
		$data = $this->kota_kab->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		$data = array(
				'nama_kota_kab' => $this->input->post('nama_Kota_kab'),
				'id_provinsi' => $this->input->post('id_Provinsi'),
			);

		$insert = $this->kota_kab->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_kota_kab' => $this->input->post('nama_Kota_kab'),
				'id_provinsi' => $this->input->post('id_Provinsi'),
			);

		$this->kota_kab->update(array('id_kota_kab' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		//delete file
		//$data = $this->provinsi->get_by_id($id);
		
		$this->kota_kab->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('id_Provinsi') == 0)
		{
			$data['inputerror'][] = 'id_Provinsi';
			$data['error_string'][] = 'Pilih Provinsi Lebih Dahulu';
			$data['status'] = FALSE;
		}
		if($this->input->post('nama_Kota_kab') == '')
		{
			$data['inputerror'][] = 'nama_Kota_kab';
			$data['error_string'][] = 'Nama Kota / Kabupaten Harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
}