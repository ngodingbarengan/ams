<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kirim_order extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('produk_model','produk');
		$this->load->model('Customer_model','customer');
		$this->load->model('Kirim_order_model','kirim');
		$this->load->model('Jenis_pengiriman_model','jenis_pengiriman');
		$this->load->library('session');
		$this->load->library('sales_order');
		$this->load->helper('url');
		
		$id = $this->session->userdata('id_user');
		$user = $this->session->userdata('nama_user');
		$pass = $this->session->userdata('password_user');
		$hak_akses = $this->session->userdata('hak_akses_user');
		
		if(empty($id) || empty($pass) || $hak_akses != 'GUDANG')
		{
			redirect('Login_user');
		}
	}
	
	public function kueri()
	{
		$data = $this->so->_get_datatables_query();
		print_r($data);
	}
	
	public function index()
	{
		$data['option_jenis_pengiriman'] = $this->jenis_pengiriman->get_jenis_pengiriman_list();
		//print_r($data);
		$this->load->view('backend/kirim_order_view', $data);
	}
	
	public function ajax_list()
	{	
		$list = $this->kirim->get_datatables();
		//print_r($list);
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $order) {
			$no++;
			$row = array();
			$row[] = '<a href="" id="LihatDetailTransaksi"><i class="fa fa-file-text-o fa-fw"></i>'.$order->nomor_order.'</a>';
			$row[] = $order->tanggal;
			$row[] = $order->waktu;
			$row[] = $order->nama_lengkap;
			$row[] = $order->no_kontak;
			$row[] = $order->alamat.'<br/> Kec. '.$order->nama_kecamatan.', Kota/Kab. '.$order->nama_kota_kab.', Provinsi '.$order->nama_provinsi;
			$row[] = $order->username;
			$row[] = number_format($order->total_kuantitas, 0, '.', '.');
			$row[] = 'Rp. '.number_format($order->total_harga, 0, '.', '.');
			$row[] = 'Rp. '.number_format($order->total_diskon, 0, '.', '.');
			$row[] = 'Rp. '.number_format($order->total_ppn, 0, '.', '.');
			$row[] = 'Rp. '.number_format($order->grand_total, 0, '.', '.');

			if($order->keterangan != ''){
				$row[] = $order->keterangan;
			}else{
				$row[] = '<span class="badge badge-info">Kosong</span>';
			}
			if($order->no_resi == NULL){
				$row[] = "<button class='btn btn-md btn-success' onclick='add_file_upload(\"".$order->nomor_order."\", ".$order->ongkir.")'>Upload</button>";
			}else{
				$row[] = '<strong>'.$order->jenis_pengiriman.'</strong><br/>'.$order->no_resi;
			}
			
			$data[] = $row;
			
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->kirim->count_all(),
						"recordsFiltered" => $this->kirim->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	
		
	}
	
	public function add_order_confirmation()
	{
		$this->_validate_upload_form();
		
		/*
		$data['no_order'] = $this->input->post('nomor');
		$data['id_jenis_pengiriman'] = $this->input->post('id_Jenis_Pengiriman');
		$data['ongkir'] = $this->input->post('Ongkir');
		$data['no_resi'] = $this->input->post('no_Resi');
		$data['status'] = TRUE;
		
		echo json_encode($data);
		*/
		
		$data_master = array(
				'ongkir' => $this->input->post('Ongkir'),
				'status' => 'SEND'
				);
		
		//ubah status menjadi terkirim dan ubah ongkos kirim
		$this->kirim->ubah_status(array('nomor_order' => $this->input->post('nomor')), $data_master);
		
		$data = array(
				'no_resi' => $this->input->post('no_Resi'),
				'id_jenis_pengiriman' => $this->input->post('id_Jenis_Pengiriman')
				);
		
		//tbl konfirmasi harus terisi terlebih dahulu baru bisa di update
		$this->kirim->save_order_confirmation(array('nomor_order' => $this->input->post('nomor')), $data);
		echo json_encode(array("status" => TRUE));

	}
	
	public function detail_so()
	{	
			
		//$nomor_so = 'asdfadfdfadf';
		$nomor_so = $this->input->post('nomor_so');
		$data['master'] = $this->kirim->get_master_by_id($nomor_so);
		$data['detail'] = $this->kirim->get_detail_by_id($nomor_so);
		//print_r($data);
		echo json_encode($data);

	}
	
	public function get_invoice($nomor)
	{	
		$data['master'] = $this->kirim->get_master_by_id_print($nomor);
		$data['detail'] = $this->kirim->get_detail_by_id_print($nomor);
		
		//echo $nomor;
		//print_r($data);
		$this->load->view('backend/print_invoice', $data);

	}
	
	private function _validate_upload_form()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		if($this->input->post('id_Jenis_Pengiriman') == 0)
		{
			$data['inputerror'][] = 'id_Jenis_Pengiriman';
			$data['error_string'][] = 'Pilih jenis pengiriman dahulu';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Ongkir') == 0)
		{
			$data['inputerror'][] = 'Ongkir';
			$data['error_string'][] = 'Masukkan jumlah ongkos kirim';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('no_Resi') == '')
		{
			$data['inputerror'][] = 'no_Resi';
			$data['error_string'][] = 'Nomor resi harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
