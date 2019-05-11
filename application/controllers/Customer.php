<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Customer_model','customer');
		$this->load->library('session');
		
		$id = $this->session->userdata('id_user');
		$user = $this->session->userdata('nama_user');
		$pass = $this->session->userdata('password_user');
		$hak_akses = $this->session->userdata('hak_akses_user');
		
		if(empty($id) || empty($pass) || $hak_akses != 'SALES')
		{
			redirect('Login_user');
		}
	}

	public function index()
	{
		$this->load->helper('url');
		
		$data['option_provinsi'] = $this->customer->get_provinsi_list();
		$this->load->view('backend/customer_view',$data);
	}
	

	public function list_kota($selectProvinsi)
	{	
		$data = $this->customer->get_kota_by_id_prov($selectProvinsi);
		echo json_encode($data);
		
		//$hasil['isi'] = $this->customer->get_by_id_prov();
		//print_r($hasil['isi']);
	}
	
	public function list_kecamatan($selectKotaKab)
	{	
		$data = $this->customer->get_kecamatan_by_id_kota_kab($selectKotaKab);
		echo json_encode($data);
		
		//$hasil['isi'] = $this->customer->get_kecamatan_by_id_kota_kab();
		//print_r($hasil['isi']);
	}

	public function ajax_list()
	{
		$this->load->helper('url');
		
		 /*
		//testing isi model
		$hasil['isi'] = $this->customer->_get_datatables_query();
		//print_r($hasil['isi'][1]['nama_kecamatan']);
		print_r($hasil);
		// */
		
		// /*
		$list = $this->customer->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list as $customer) {
			$no++;
			$row = array();
			
			$row[] = $customer->kd_member;
			$row[] = $customer->nama_lengkap;
			$row[] = $customer->no_kontak;
			$row[] = $customer->alamat;
			$row[] = $customer->id_provinsi;
			$row[] = $customer->nama_provinsi;
			$row[] = $customer->id_kota_kab;
			$row[] = $customer->nama_kota_kab;
			$row[] = $customer->id_kecamatan;
			$row[] = $customer->nama_kecamatan;
			
			
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$customer->id_member."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$customer->id_member."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->customer->count_all(),
						"recordsFiltered" => $this->customer->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		// */
	}
	
	public function ajax_edit($id) //
	{
		$data = $this->customer->get_by_id($id); //
		echo json_encode($data);
		//print_r($data);
	}


	public function ajax_add()
	{
		$this->_validate();
		//
		
		$data = array(
				'kd_member' => $this->input->post('kd_Customer'),
				'nama_lengkap' => $this->input->post('nama_Customer'),
				'no_kontak' => $this->input->post('no_Kontak'),
				'alamat' => $this->input->post('alamat_Customer'),
				'id_provinsi' => $this->input->post('id_Provinsi'),
				'id_kota_kab' => $this->input->post('id_KotaKab'),
				'id_kecamatan' => $this->input->post('id_Kecamatan'),
				'tipe' => 'CUST_OFFLINE'
			);
		//
		$insert = $this->customer->save($data);

		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		//
		$data = array(
				'kd_member' => $this->input->post('kd_Customer'),
				'nama_lengkap' => $this->input->post('nama_Customer'),
				'no_kontak' => $this->input->post('no_Kontak'),
				'alamat' => $this->input->post('alamat_Customer'),
				'id_provinsi' => $this->input->post('id_Provinsi'),
				'id_kota_kab' => $this->input->post('id_KotaKab'),
				'id_kecamatan' => $this->input->post('id_Kecamatan')
			);
		//
		$this->customer->update(array('id_member' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		//delete file
		//$data = $this->provinsi->get_by_id($id);
		
		$this->customer->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('kd_Customer') == '')
		{
			$data['inputerror'][] = 'kd_Customer';
			$data['error_string'][] = 'Masukkan kode customer';
			$data['status'] = FALSE;
		}
		if($this->input->post('nama_Customer') == '')
		{
			$data['inputerror'][] = 'nama_Customer';
			$data['error_string'][] = 'Masukkan nama customer';
			$data['status'] = FALSE;
		}
		if($this->input->post('no_Kontak') == '')
		{
			$data['inputerror'][] = 'no_Kontak';
			$data['error_string'][] = 'Masukkan nomor kontak';
			$data['status'] = FALSE;
		}
		if($this->input->post('alamat_Customer') == '')
		{
			$data['inputerror'][] = 'alamat_Customer';
			$data['error_string'][] = 'Masukkan alamat customer';
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