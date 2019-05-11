<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('produk_model','produk');
		$this->load->model('supplier_model','supplier');
		$this->load->model('Customer_model','customer');
		$this->load->model('Customer_order_model','co');
		$this->load->model('Sales_order_model','so');
		$this->load->model('Purchase_order_model','po');
		$this->load->library('session');
		$this->load->library('purchase_order');
		$this->load->library('sales_order');
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
	
	
	//PURCHASE ORDER
	public function app_po()
	{
		$this->load->view('backend/approval_purchase_order_view');
	}
	
	public function ajax_list_po()
	{
		
		//$list = $this->po->app_po_get_datatables_query();
		//print_r($list);
		
		$list = $this->po->app_po_get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $po) {
			$no++;
			$row = array();
			//$row[] = $po->nomor_po;
			$row[] = '<a href="" id="LihatDetailTransaksi"><i class="fa fa-file-text-o fa-fw"></i>'.$po->nomor_po.'</a>';
			$row[] = $po->tanggal;
			$row[] = $po->waktu;
			$row[] = $po->nama_lengkap;
			$row[] = $po->username;
			$row[] = number_format($po->total_kuantitas, 0, '.', '.');
			$row[] = 'Rp. '.number_format($po->total_po, 0, '.', '.');
			$row[] = 'Rp. '.number_format($po->total_ppn, 0, '.', '.');
			$row[] = 'Rp. '.number_format($po->grand_total, 0, '.', '.');
			//$row[] = $po->keterangan;
			if($po->keterangan != ''){
				$row[] = $po->keterangan;
			}else{
				$row[] = '<span class="badge badge-info">Kosong</span>';
			}
			//add html for action
			//aksi masih belum fix dibuat
			$row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Approve" onclick="approve_order('."'".$po->nomor_po."'".')"><i class="glyphicon glyphicon-ok"></i> </a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel_order('."'".$po->nomor_po."'".')"><i class="glyphicon glyphicon-remove"></i> </a>';
			
			$data[] = $row;
			
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->po->app_po_count_all(),
						"recordsFiltered" => $this->po->app_po_count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function detail_po()
	{	

		$nomor_po = $this->input->post('nomor_po');
		$data['master'] = $this->po->get_master_by_id($nomor_po);
		$data['detail'] = $this->po->get_detail_by_id($nomor_po);
		//print_r($data);
		echo json_encode($data);

	}
	
	
	public function approve_po()//$nomor_po
	{	
		$nomor_po = $this->input->post('nomor');
		$data = $this->po->get_detail_by_id($nomor_po);
		
		foreach ($data as $isi)
		{
			//echo $isi->id_produk.'   ';
			//echo '('.$isi->kuantitas.')';
			//$stok = $this->po->app_get_stok_produk($isi->id_produk);
			//echo $stok->stok;
			//echo '</br>';
			
			$stok = $this->po->app_get_stok_produk($isi->id_produk);
			$stok_update = $isi->kuantitas+$stok->stok;
			
			$data = array(
				'stok' => $stok_update
			);
			
			$this->po->tambah_stok(array('id_produk' => $isi->id_produk), $data);
		}
		
		$data_master = array(
				'status' => 'APPROVE'
		);
		
		$this->po->ubah_status(array('nomor_po' => $nomor_po), $data_master);

		echo json_encode(array("status" => TRUE));

	}
	
	
	public function cancel_po()
	{	
		$nomor_po = $this->input->post('nomor');
		
		$data_master = array(
				'status' => 'CANCEL'
		);
		
		$this->po->ubah_status(array('nomor_po' => $nomor_po), $data_master);
		echo json_encode(array("status" => TRUE));
	}
	
	
	//SALES ORDER
	public function app_so()
	{
		$this->load->view('backend/approval_sales_order_view');
	}
	
	public function ajax_list_so()
	{	
		$list = $this->so->app_so_get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $so) {
			$no++;
			$row = array();
			$row[] = '<a href="" id="LihatDetailTransaksi"><i class="fa fa-file-text-o fa-fw"></i>'.$so->nomor_order.'</a>';
			$row[] = $so->tanggal;
			$row[] = $so->waktu;
			$row[] = $so->nama_lengkap;
			$row[] = $so->no_kontak;
			$row[] = $so->alamat.'<br/> Kec. '.$so->nama_kecamatan.', Kota/Kab. '.$so->nama_kota_kab.', Provinsi '.$so->nama_provinsi;
			$row[] = $so->username;
			$row[] = number_format($so->total_kuantitas, 0, '.', '.');
			$row[] = 'Rp. '.number_format($so->total_harga, 0, '.', '.');
			$row[] = 'Rp. '.number_format($so->total_diskon, 0, '.', '.');
			$row[] = 'Rp. '.number_format($so->total_ppn, 0, '.', '.');
			$row[] = 'Rp. '.number_format($so->grand_total, 0, '.', '.');
			//$row[] = $so->keterangan;
			if($so->keterangan != ''){
				$row[] = $so->keterangan;
			}else{
				$row[] = '<span class="badge badge-info">Kosong</span>';
			}
			if($so->bukti_pembayaran == NULL){
				$row[] = '<span class="badge badge-info">Kosong</span>';
			}else{
				$row[] = '<a href="'.base_url('upload/konfirmasi_pembayaran/'.$so->bukti_pembayaran).'" target="_blank">'.$so->bukti_pembayaran.'</a>';
			}
			
			//add html for action
			if($so->bukti_pembayaran != NULL){
				$row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Approve" onclick="approve_order('."'".$so->nomor_order."'".')"><i class="glyphicon glyphicon-ok"></i> </a>
				<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel_order('."'".$so->nomor_order."'".')"><i class="glyphicon glyphicon-remove"></i> </a>';
			}else{
				$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel_order('."'".$so->nomor_order."'".')"><i class="glyphicon glyphicon-remove"></i> </a>';
			}
			
			$data[] = $row;
			
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->so->app_so_count_all(),
						"recordsFiltered" => $this->so->app_so_count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function detail_so()
	{	
			
		//$nomor_so = 'asdfadfdfadf';
		$nomor_so = $this->input->post('nomor_so');
		$data['master'] = $this->so->get_master_by_id($nomor_so);
		$data['detail'] = $this->so->get_detail_by_id($nomor_so);
		//print_r($data);
		echo json_encode($data);

	}
	
	public function approve_so()
	{	
		$nomor_so = $this->input->post('nomor');
		$data = $this->so->get_detail_by_id($nomor_so);
		
		foreach ($data as $isi)
		{
			//echo $isi->id_produk.'   ';
			//echo '('.$isi->kuantitas.')';
			//$stok = $this->so->app_get_stok_produk($isi->id_produk);
			//echo $stok->stok;
			//echo '</br>';
			
			$stok = $this->so->app_get_stok_produk($isi->id_produk);
			$stok_update = $stok->stok-$isi->kuantitas;
			
			//echo $stok_update;
			//echo '</br>';
			
			$data = array(
				'stok' => $stok_update
			);
			
			$this->so->kurangi_stok(array('id_produk' => $isi->id_produk), $data);
	
		}
		
		
		$data_master = array(
				'status' => 'APPROVE'
		);
		
		$this->so->ubah_status(array('nomor_order' => $nomor_so), $data_master);

		echo json_encode(array("status" => TRUE));

	}
	
	public function cancel_so()
	{	
		$nomor_so = $this->input->post('nomor');
		
		$data_master = array(
				'status' => 'CANCEL'
		);
		
		$this->so->ubah_status(array('nomor_order' => $nomor_so), $data_master);
		echo json_encode(array("status" => TRUE));
	}
	
	
	//CUSTOMER ORDER	
	public function app_co()
	{
		$this->load->view('backend/approval_customer_order_view');
	}
	
	public function ajax_list_co()
	{	
		
		//$list = $this->co->app_co_get_datatables_query();
		//print_r($list);
		
		$list = $this->co->app_co_get_datatables();
		//print_r($list);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $co) {
			$no++;
			$row = array();
			$row[] = '<a href="" id="LihatDetailTransaksi"><i class="fa fa-file-text-o fa-fw"></i>'.$co->nomor_order.'</a>';
			$row[] = $co->tanggal;
			$row[] = $co->waktu;
			$row[] = $co->nama_lengkap;
			$row[] = $co->no_kontak;
			$row[] = $co->alamat.'<br/> Kec. '.$co->nama_kecamatan.', Kota/Kab. '.$co->nama_kota_kab.', Provinsi '.$co->nama_provinsi;
			$row[] = $co->username;
			$row[] = number_format($co->total_kuantitas, 0, '.', '.');
			$row[] = 'Rp. '.number_format($co->total_harga, 0, '.', '.');
			$row[] = 'Rp. '.number_format($co->ongkir, 0, '.', '.');
			$row[] = 'Rp. '.number_format($co->grand_total, 0, '.', '.');
			if($co->keterangan != ''){
				$row[] = $co->keterangan;
			}else{
				$row[] = '<span class="badge badge-info">Kosong</span>';
			}
			if($co->bukti_pembayaran == NULL){
				$row[] = '<span class="badge badge-info">Kosong</span>';
			}else{
				$row[] = '<a href="'.base_url('upload/konfirmasi_pembayaran/'.$co->bukti_pembayaran).'" target="_blank">'.$co->bukti_pembayaran.'</a>';
			}
			
			//add html for action
			if($co->bukti_pembayaran != NULL){
				$row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Approve" onclick="approve_order('."'".$co->nomor_order."'".')"><i class="glyphicon glyphicon-ok"></i> </a>
				<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel_order('."'".$co->nomor_order."'".')"><i class="glyphicon glyphicon-remove"></i> </a>';
			}else{
				$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel_order('."'".$co->nomor_order."'".')"><i class="glyphicon glyphicon-remove"></i> </a>';
			}
			
			$data[] = $row;
			
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->co->app_co_count_all(),
						"recordsFiltered" => $this->co->app_co_count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function detail_co()
	{	
			
		//$nomor_so = 'asdfadfdfadf';
		$nomor_co = $this->input->post('nomor_co');
		$data['master'] = $this->co->app_get_master_by_id($nomor_co);
		$data['detail'] = $this->co->app_get_detail_by_id($nomor_co);
		//print_r($data);
		echo json_encode($data);

	}
	
	public function approve_co()
	{	
		$nomor_co = $this->input->post('nomor');
		$data = $this->co->get_detail_by_id($nomor_co);
		
		foreach ($data as $isi)
		{
			//echo $isi->id_produk.'   ';
			//echo '('.$isi->kuantitas.')';
			//$stok = $this->so->app_get_stok_produk($isi->id_produk);
			//echo $stok->stok;
			//echo '</br>';
			
			$stok = $this->co->app_get_stok_produk($isi->id_produk);
			$stok_update = $stok->stok-$isi->kuantitas;
			
			//echo $stok_update;
			//echo '</br>';
			
			$data = array(
				'stok' => $stok_update
			);
			
			$this->co->kurangi_stok(array('id_produk' => $isi->id_produk), $data);
	
		}
		
		
		$data_master = array(
				'status' => 'APPROVE'
		);
		
		$this->co->ubah_status(array('nomor_order' => $nomor_co), $data_master);

		echo json_encode(array("status" => TRUE));

	}
	
	public function cancel_co()
	{	
		$nomor_co = $this->input->post('nomor');
		
		$data_master = array(
				'status' => 'CANCEL'
		);
		
		$this->co->ubah_status(array('nomor_order' => $nomor_co), $data_master);
		echo json_encode(array("status" => TRUE));
	}
	
	
}
