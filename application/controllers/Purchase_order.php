<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('produk_model','produk');
		$this->load->model('supplier_model','supplier');
		$this->load->model('purchase_order_model','po');
		$this->load->library('session');
		$this->load->library('purchase_order');
		$this->load->helper('url');
		
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
		$this->load->view('backend/purchase_order_view');
	}
	
	public function cek_count_all()
	{
		$data = $this->po->count_all();
		print_r($data);
	}
	
	public function form_po()
	{
		$data['option_supplier'] = $this->supplier->get_supplier_list();
		$data['produk'] = $this->produk->get_data_produk();
		$this->load->view('backend/purchase_order_form', $data);
	}
	
	public function ajax_list()
	{
		
		//$list = $this->po->_get_datatables_query();
		//print_r($list);
		
		$list = $this->po->get_datatables($this->session->userdata('id_user'));
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
			$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel_order('."'".$po->nomor_po."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
			
			$data[] = $row;
			
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->po->count_all($this->session->userdata('id_user')),
						"recordsFiltered" => $this->po->count_filtered($this->session->userdata('id_user')),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function cek()
	{
		//$keyword = 'RM 8501';
		$keyword = $this->input->post('keyword');
		
		
		if(!empty($keyword)) {
			
			$data = $this->produk->cari_kode($keyword);
			//if(!empty($data)){
				echo json_encode($data);
				//print_r($data);
			//}
		}
	}

	public function add_po_item()
	{
		/*
		format standar input po data pada Codeigniter, penamaan id, qty, price, dan name merupakan reserve word untuk class po jadi tidak bisa diganti dan harus digunakan
		Untuk penamaan option bertipe array dapat digunakan bila memiliki variabel tambahan data untuk dimasukkan
		$data = array(
			'id' => number value,
			'qty' => number value,
			'price' => number value,
			'name' => 'string',
			'option' => array()
        );
		//awal percobaan data tidak bisa di-insert ke shopping po
		//hal ini disebabkan karekter name yang digunakan memiliki rules sendiri dan nama yang digunakan menggunakan
		//karakter yang terlarang pada rules regex yaitu karakter - 
		//SOLUSI mengubah coding library po pada system agar name mendukung semua karakter
		
		*/
		
		//testing data json
		/*
		$data['id'] = $this->input->post('Id');
		$data['jumlah'] = $this->input->post('Jumlah');
		$data['harga'] = $this->input->post('Harga');
		$data['kode'] = $this->input->post('kd_Produk');
		$data['nama'] = $this->input->post('nama_Produk');
		$data['status'] = TRUE;
			
		echo json_encode($data);
		*/
		
		
		$this->_validate_form_item();
		
		$data = array(
			'id' => $this->input->post('Id'),
			'qty' => $this->input->post('Jumlah'),
			'price' => $this->input->post('Harga'),
			'name' => $this->input->post('nama_Produk'),
			'code' => $this->input->post('kd_Produk')
        );
		
		$this->purchase_order->insert($data);
		
		echo json_encode(array("status" => TRUE));
		
		//print_r($this->purchase_order->contents());
	}
	
	public function update_po_item()
	{
		$rowid =  $this->input->post('id_item');
		$qty = $this->input->post('jumlah_item');
		
		$data = array(
			'rowid' => $rowid,
			'qty' => $qty
        );
		
		$this->purchase_order->update($data);
		//$this->load->view('backend/purchase_order_view');
	}
	
	public function remove_po_item()
	{	
		$rowid =  $this->input->post('id_item');
		
		$data = array(
			'rowid' => $rowid,
			'qty' => 0
        );
		
		$this->purchase_order->update($data);
		
		//$this->load->view('backend/purchase_order_view');
	}
	
	public function add_PO()
	{
	
		//testing data json
		/*
		$data['nomor'] = $this->input->post('nomor_PO');
		$data['tanggal'] = date('Y-m-d', strtotime($this->input->post('tgl_PO')));
		$data['supplier'] = $this->input->post('id_Supplier');
		$data['user'] = $this->input->post('User');
		$data['keterangan'] = $this->input->post('Keterangan');
		$data['total_harga'] = $this->input->post('nilai_total_harga');
		$data['ppn'] = $this->input->post('nilai_ppn');
		$data['grand_total'] = $this->input->post('nilai_grand_total');
		
		$data['status'] = TRUE;
			
		echo json_encode($data);
		*/
		
		$this->_validate_form_PO();
		
		$last_id = $this->po->get_last_number();

		foreach ($last_id as $hasil)
		{
			$nomor = ($hasil->id_po)+1;
		}
		
		date_default_timezone_set('Asia/Jakarta');
		$waktu = date('H:i:s');
		
		//menambahkan data PO ke tabel pembelian master
		$data_master = array(
			'id_po' => $nomor,
			'nomor_po' => $this->input->post('nomor_PO'),
			'tanggal' => date('Y-m-d', strtotime($this->input->post('tgl_PO'))),
			'waktu' => $waktu,
			'id_member' => $this->input->post('id_Supplier'),
			'id_user' => $this->input->post('User'),
			'keterangan' => $this->input->post('Keterangan'),
			'total_kuantitas' => $this->purchase_order->total_items(),
			'total_po' => $this->input->post('nilai_total_harga'),
			'total_ppn' => $this->input->post('nilai_ppn'),
			'grand_total' => $this->input->post('nilai_grand_total'),
			'status' => 'ORDER'
		);

		$insert_master = $this->po->save_po_master($data_master);
		
		//menambahkan data item PO ke tabel pembelian detail
		foreach($this->purchase_order->contents() as $items){
        
            $data_detail = array(
				'id_po' => $nomor,
                'nomor_po' => $this->input->post('nomor_PO'),
				'id_produk' => $items['id'],
                'kd_produk'=> $items['code'],
				'nama_produk'=> $items['name'],
                'kuantitas'=> $items['qty'],
				'harga'=> $items['price'],
				'jumlah_harga'=> $items['subtotal']
            );
		
		$insert_detail = $this->po->save_po_detail($data_detail);
		
        }
    
        $this->purchase_order->destroy();
		
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
	
	public function detail_po()
	{	

		$nomor_po = $this->input->post('nomor_po');
		$data['master'] = $this->po->get_master_by_id($nomor_po);
		$data['detail'] = $this->po->get_detail_by_id($nomor_po);
		//print_r($data);
		echo json_encode($data);

	}
	
	public function get_invoice($nomor)//
	{	
	
		//$nomor = 1;
		$data['master'] = $this->po->get_master_by_id_print($nomor);
		$data['detail'] = $this->po->get_detail_by_id_print($nomor);
		
		//print_r($data);
		$this->load->view('backend/print_purchase', $data);

	}

	private function _validate_form_PO()
	{		
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		if($this->input->post('nomor_PO') == '')
		{
			$data['inputerror'][] = 'nomor_PO';
			$data['error_string'][] = 'Nomor PO Harus diisi';
			$data['status'] = FALSE;
		}
		
		$nomor_po = $this->po->cek_nomor_PO($this->input->post('nomor_PO'));
		
		if(!empty($nomor_po))
		{
			$data['inputerror'][] = 'nomor_PO';
			$data['error_string'][] = 'Nomor PO sudah digunakan';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('id_Supplier') == 0)
		{
			$data['inputerror'][] = 'id_Supplier';
			$data['error_string'][] = 'Pilih Supplier Terlebih Dahulu';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
	private function _validate_form_item()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('kd_Produk') == '')
		{
			$data['inputerror'][] = 'kd_Produk';
			$data['error_string'][] = 'Kode Produk Harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Harga') < 1)
		{
			$data['inputerror'][] = 'Harga';
			$data['error_string'][] = 'Harga tidak boleh kosong';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Jumlah') < 1)
		{
			$data['inputerror'][] = 'Jumlah';
			$data['error_string'][] = 'Jumlah minimal 1';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
}
