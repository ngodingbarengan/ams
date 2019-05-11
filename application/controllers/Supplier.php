<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Supplier_model','supplier');
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
		
		$data['option_provinsi'] = $this->supplier->get_provinsi_list();
		$this->load->view('backend/supplier_view',$data);
	}
	

	public function list_kota($selectProvinsi)
	{	
		$data = $this->supplier->get_kota_by_id_prov($selectProvinsi);
		echo json_encode($data);
		
		//$hasil['isi'] = $this->supplier->get_by_id_prov();
		//print_r($hasil['isi']);
	}
	
	public function list_kecamatan($selectKotaKab)
	{	
		$data = $this->supplier->get_kecamatan_by_id_kota_kab($selectKotaKab);
		echo json_encode($data);
		
		//$hasil['isi'] = $this->supplier->get_kecamatan_by_id_kota_kab();
		//print_r($hasil['isi']);
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		
		 /*
		//testing isi model
		$hasil['isi'] = $this->supplier->_get_datatables_query();
		//print_r($hasil['isi'][1]['nama_kecamatan']);
		print_r($hasil);
		// */
		
		// /*
		$list = $this->supplier->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list as $supplier) {
			$no++;
			$row = array();
			
			$row[] = $supplier->kd_member;
			$row[] = $supplier->nama_lengkap;
			$row[] = $supplier->no_kontak;
			$row[] = $supplier->alamat;
			$row[] = $supplier->id_provinsi;
			$row[] = $supplier->nama_provinsi;
			$row[] = $supplier->id_kota_kab;
			$row[] = $supplier->nama_kota_kab;
			$row[] = $supplier->id_kecamatan;
			$row[] = $supplier->nama_kecamatan;
			
			
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$supplier->id_member."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$supplier->id_member."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->supplier->count_all(),
						"recordsFiltered" => $this->supplier->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		// */
	}
	
	public function ajax_edit($id) //
	{
		$data = $this->supplier->get_by_id($id); //
		echo json_encode($data);
		//print_r($data);
	}


	public function ajax_add()
	{
		$this->_validate();
		//
		
		$data = array(
				'kd_member' => $this->input->post('kd_Supplier'),
				'nama_lengkap' => $this->input->post('nama_Supplier'),
				'no_kontak' => $this->input->post('no_Kontak'),
				'alamat' => $this->input->post('alamat_Supplier'),
				'id_provinsi' => $this->input->post('id_Provinsi'),
				'id_kota_kab' => $this->input->post('id_KotaKab'),
				'id_kecamatan' => $this->input->post('id_Kecamatan'),
				'tipe' => 'SUPP_OFFLINE'
			);
		//
		$insert = $this->supplier->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		//
		$data = array(
				'kd_member' => $this->input->post('kd_Supplier'),
				'nama_lengkap' => $this->input->post('nama_Supplier'),
				'no_kontak' => $this->input->post('no_Kontak'),
				'alamat' => $this->input->post('alamat_Supplier'),
				'id_provinsi' => $this->input->post('id_Provinsi'),
				'id_kota_kab' => $this->input->post('id_KotaKab'),
				'id_kecamatan' => $this->input->post('id_Kecamatan'),
			);
		//
		$this->supplier->update(array('id_member' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		//delete file
		//$data = $this->provinsi->get_by_id($id);
		
		$this->supplier->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('kd_Supplier') == '')
		{
			$data['inputerror'][] = 'kd_Supplier';
			$data['error_string'][] = 'Masukkan kode supplier';
			$data['status'] = FALSE;
		}
		if($this->input->post('nama_Supplier') == '')
		{
			$data['inputerror'][] = 'nama_Supplier';
			$data['error_string'][] = 'Masukkan nama supplier';
			$data['status'] = FALSE;
		}
		if($this->input->post('no_Kontak') == '')
		{
			$data['inputerror'][] = 'no_Kontak';
			$data['error_string'][] = 'Masukkan nomor kontak';
			$data['status'] = FALSE;
		}
		if($this->input->post('alamat_Supplier') == '')
		{
			$data['inputerror'][] = 'alamat_Supplier';
			$data['error_string'][] = 'Masukkan alamat supplier';
			$data['status'] = FALSE;
		}
		if($this->input->post('id_Provinsi') == 0)
		{
			$data['inputerror'][] = 'id_Provinsi';
			$data['error_string'][] = 'Pilih provinsi dahulu';
			$data['status'] = FALSE;
		}
		if($this->input->post('id_KotaKab') == 0)
		{
			$data['inputerror'][] = 'id_KotaKab';
			$data['error_string'][] = 'Pilih Kota / Kabupaten dahulu';
			$data['status'] = FALSE;
		}
		if($this->input->post('id_Kecamatan') == 0)
		{
			$data['inputerror'][] = 'id_Kecamatan';
			$data['error_string'][] = 'Plih Kecamatan dahulu';
			$data['status'] = FALSE;
		}
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
}