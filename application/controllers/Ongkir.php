<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ongkir extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ongkir_model','ongkir');
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
		$this->load->view('backend/ongkir_view');
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		
		$list = $this->ongkir->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $ongkir) {
			$no++;
			$row = array();
			$row[] = $ongkir->nama_provinsi;
			$row[] = $ongkir->nama_kota_kab;
			$row[] = $ongkir->nama_kecamatan;
			//$row[] = $ongkir->id_ongkir;
			$row[] = 'Rp. '.number_format($ongkir->ongkir, 0, '.', '.');
			//$row[] = $ongkir->ongkir;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$ongkir->id_ongkir."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->ongkir->count_all(),
						"recordsFiltered" => $this->ongkir->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
	}

	public function ajax_edit($id)
	{
		$data = $this->ongkir->get_by_id($id);
		echo json_encode($data);
	}


	public function ajax_update()
	{
		
		$this->_validate();
		$data = array(
				'ongkir' => $this->input->post('Ongkir')
			);

		$this->ongkir->update(array('id_ongkir' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
		
		/*
		$data['ongkir'] = $this->input->post('Ongkir');
		$data['id'] = $this->input->post('id');
		$data['status'] = TRUE;
		
		echo json_encode($data);
		*/
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('Ongkir') <= 5000)
		{
			$data['inputerror'][] = 'Ongkir';
			$data['error_string'][] = 'Masukkan nilai ongkos kirim';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
	
	
}
