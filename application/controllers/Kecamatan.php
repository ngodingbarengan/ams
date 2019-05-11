<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kecamatan_model','kecamatan');
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
		
		$data['option_provinsi'] = $this->kecamatan->get_provinsi_list();
		$this->load->view('backend/kecamatan_view',$data);
	}
	

	public function select_kota($selectValues)
	{
	//public function select_kota()
	//{	
		$data = $this->kecamatan->get_by_id_prov($selectValues);
		echo json_encode($data);
		
		//$hasil['isi'] = $this->kecamatan->get_by_id_prov();
		//print_r($hasil['isi']);
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		
		/*
		//testing isi model
		$hasil['isi'] = $this->kecamatan->_get_datatables_query();
		print_r($hasil['isi'][1]['nama_kecamatan']);
		*/

		$list = $this->kecamatan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list as $kecamatan) {
			$no++;
			$row = array();
			
			$row[] = $kecamatan->id_provinsi;
			$row[] = $kecamatan->nama_provinsi;
			$row[] = $kecamatan->id_kota_kab;
			$row[] = $kecamatan->nama_kota_kab;
			$row[] = $kecamatan->nama_kecamatan;
			
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$kecamatan->id_kecamatan."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$kecamatan->id_kecamatan."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->kecamatan->count_all(),
						"recordsFiltered" => $this->kecamatan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
	}
	
	public function ajax_edit($id)
	{
		$data = $this->kecamatan->get_by_id($id);
		//print_r($data->id_kecamatan);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
		$data = array(
				'nama_kecamatan' => $this->input->post('nama_Kecamatan'),
				'id_kota_kab' => $this->input->post('id_KotaKab'),
			);

		$insert = $this->kecamatan->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_kecamatan' => $this->input->post('nama_Kecamatan'),
				'id_kota_kab' => $this->input->post('id_KotaKab'),
			);

		$this->kecamatan->update(array('id_kecamatan' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		//delete file
		//$data = $this->provinsi->get_by_id($id);
		
		$this->kecamatan->delete_by_id($id);
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
			$data['error_string'][] = 'Provinsi Harus Dipilih Dahulu';
			$data['status'] = FALSE;
		}
		if($this->input->post('id_KotaKab') == 0)
		{
			$data['inputerror'][] = 'id_KotaKab';
			$data['error_string'][] = 'Kota / Kabupaten Harus Dipilih Dahulu';
			$data['status'] = FALSE;
		}
		if($this->input->post('nama_Kecamatan') == '')
		{
			$data['inputerror'][] = 'nama_Kecamatan';
			$data['error_string'][] = 'Nama Kecamatan Harus Diisi Dahulu';
			$data['status'] = FALSE;
		}
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
}