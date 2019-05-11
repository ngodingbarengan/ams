<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('merek_model','merek');
		$this->load->library('session');
		
		$id = $this->session->userdata('id_user');
		$user = $this->session->userdata('nama_user');
		$user = $this->session->userdata('email_user');
		$pass = $this->session->userdata('password_user');
		$hak_akses = $this->session->userdata('hak_akses_user');
		
		if(empty($user) && empty($pass) && empty($hak_akses))
		{
			redirect('Login_user');
		}
	}

	public function lap_penjualan()
	{
		$this->load->helper('url');
		$this->load->view('backend/laporan_penjualan_view');
	}
	
	public function lap_pembelian()
	{
		$this->load->helper('url');
		$this->load->view('backend/laporan_pembelian_view');
	}
	
	public function lap_sales()
	{
		$this->load->helper('url');
		$this->load->view('backend/laporan_sales_view');
	}
	
	public function tanggal()
	{
		$tanggal = date('d'); //date('Y-m-d H:i:s');
		$bulan = date('m');
		if($bulan == 07)
		{
			$bulan = 'VII';
		}else if($bulan == 07)
		{
			
		}
		
		
		
		$tahun = date('Y');
		date_default_timezone_set('Asia/Jakarta');
		$jam = date('H:i:s');
		echo $tanggal.'<br/>';
		echo $bulan.'<br/>';
		echo $tahun.'<br/>';
		echo $jam;
	}
	
}
