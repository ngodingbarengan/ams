<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Halaman extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('halaman_model','halaman');
		$this->load->library('session');
		$this->load->helper('url');
		
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
		$this->load->view('backend/ubah_halaman_cara_pemesanan_view');
	}
	
	
	public function cara_pemesanan()
	{
		$this->load->view('backend/ubah_halaman_cara_pemesanan_view');
	}
	
	public function get_isi_cara_pemesanan()
	{
		$data['isi'] = $this->halaman->cara_pemesanan();
		$data['status'] = TRUE;
		//print_r($data);
		
		echo json_encode($data);
	}
	
	public function update_cara_pemesanan()
	{
		/*
		$data['isi'] = $this->input->post('Isi_Hal');
		$data['status'] = TRUE;
		echo json_encode($data);
		*/
		
		$data = array(
				'isi_halaman' => $this->input->post('Isi_Hal')
		);

		$this->halaman->update_data_halaman(array('id_halaman' => 1), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function tentang_kami()
	{
		$this->load->view('backend/ubah_halaman_tentang_kami_view');
	}
	
	public function get_isi_tentang_kami()
	{
		$data['isi'] = $this->halaman->tentang_kami();
		$data['status'] = TRUE;
		//print_r($data);
		
		echo json_encode($data);
	}
	
	public function update_tentang_kami()
	{
		/*
		$data['isi'] = $this->input->post('Isi_Hal');
		$data['status'] = TRUE;
		echo json_encode($data);
		*/
		$data = array(
				'isi_halaman' => $this->input->post('Isi_Hal')
		);

		$this->halaman->update_data_halaman(array('id_halaman' => 2), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function kontak()
	{
		$this->load->view('backend/ubah_halaman_kontak_view');
	}
	
	public function get_isi_kontak()
	{
		$data['isi'] = $this->halaman->kontak();
		$data['status'] = TRUE;
		//print_r($data);
		
		echo json_encode($data);
	}
	
	public function update_kontak()
	{
		/*
		$data['isi'] = $this->input->post('Isi_Hal');
		$data['status'] = TRUE;
		echo json_encode($data);
		*/
		
		$data = array(
				'isi_halaman' => $this->input->post('Isi_Hal')
		);

		$this->halaman->update_data_halaman(array('id_halaman' => 3), $data);
		echo json_encode(array("status" => TRUE));
	}
	
	public function syarat_ketentuan()
	{
		$this->load->view('backend/ubah_halaman_syarat_ketentuan_view');
	}
	
	public function get_isi_syarat_ketentuan()
	{
		$data['isi'] = $this->halaman->syarat_ketentuan();
		$data['status'] = TRUE;
		//print_r($data);
		
		echo json_encode($data);
	}
	
	public function update_syarat_ketentuan()
	{
		/*
		$data['isi'] = $this->input->post('Isi_Hal');
		$data['status'] = TRUE;
		echo json_encode($data);
		*/
		
		$data = array(
				'isi_halaman' => $this->input->post('Isi_Hal')
		);

		$this->halaman->update_data_halaman(array('id_halaman' => 4), $data);
		echo json_encode(array("status" => TRUE));
	}
	
}
