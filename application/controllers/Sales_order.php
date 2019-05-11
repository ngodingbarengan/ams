<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('produk_model','produk');
		$this->load->model('Customer_model','customer');
		$this->load->model('Sales_order_model','so');
		$this->load->model('Bank_model','bank');
		$this->load->library('session');
		$this->load->library('sales_order');
		$this->load->helper('url');
		
		$id = $this->session->userdata('id_user');
		$user = $this->session->userdata('nama_user');
		$pass = $this->session->userdata('password_user');
		$hak_akses = $this->session->userdata('hak_akses_user');
		
		if(empty($id) || empty($pass) || $hak_akses != 'SALES')
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
		$data['option_bank'] = $this->bank->get_bank_list();
		$this->load->view('backend/sales_order_view', $data);
	}
	
	public function form_so()
	{	
		$data['produk'] = $this->produk->get_data_produk();
		$data['option_customer'] = $this->customer->get_customer_list();
		$this->load->view('backend/sales_order_form', $data);
	}
	
	public function ajax_list()
	{	
		$list = $this->so->get_datatables($this->session->userdata('id_user'));
		//print_r($list);
		
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
			
			if($so->keterangan != ''){
				$row[] = $so->keterangan;
			}else{
				$row[] = '<span class="badge badge-info">Kosong</span>';
			}
			if($so->bukti_pembayaran == NULL){
				$row[] = "<button class='btn btn-md btn-success' onclick='add_file_upload(\"".$so->nomor_order."\")'>Upload</button>";
			}else{
				$row[] = '<a href="'.base_url('upload/konfirmasi_pembayaran/'.$so->bukti_pembayaran).'" target="_blank">'.$so->bukti_pembayaran.'</a>';
			}
			
			//add html for action
			if($so->status == 'ORDER'){
				$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cancel" onclick="cancel_order('."'".$so->nomor_order."'".')">Batalkan Order </a>';
			}else if($so->status == 'APPROVE'){
				$row[] = '<span class="badge badge-info">Menunggu konfirmasi pengiriman</span>';
			}else{
				$row[] = "<button class='btn btn-md btn-success' onclick='add_file_upload(\"".$so->nomor_order."\")'>Order Selesai</button>";
			}
			
			$data[] = $row;
			
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->so->count_all($this->session->userdata('id_user')),
						"recordsFiltered" => $this->so->count_filtered($this->session->userdata('id_user')),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
		
	}
	

	public function add_so_item()
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
			'code' => $this->input->post('kd_Produk'),
			'weight' => $this->input->post('Berat')
        );
		
		$this->sales_order->insert($data);
		
		echo json_encode(array("status" => TRUE));
		
		//print_r($this->sales_order->contents());
	}
	
	public function view_so()
	{
		print_r($this->sales_order->contents());
	}
	
	public function update_so_item()
	{
		$rowid =  $this->input->post('id_item');
		$qty = $this->input->post('jumlah_item');
		
		$data = array(
			'rowid' => $rowid,
			'qty' => $qty
        );
		
		$this->sales_order->update($data);
		$this->load->view('backend/sales_order_form');
	}
	
	public function remove_so_item()
	{	
		$rowid =  $this->input->post('id_item');
		
		$data = array(
			'rowid' => $rowid,
			'qty' => 0
        );
		
		$this->sales_order->update($data);
		
		$this->load->view('backend/sales_order_form');
	}
	
	public function add_SO()
	{
		/*
		$this->_validate_form_SO();
		
		date_default_timezone_set('Asia/Jakarta');
		$waktu = date('H:i:s');
		
		//testing data json
		$data['nomor'] = $this->input->post('nomor_SO');
		$data['tanggal'] = date('Y-m-d', strtotime($this->input->post('tgl_SO')));
		$data['waktu'] = $waktu;
		$data['customer'] = $this->input->post('id_Customer');
		
		//tambahan
		$data_cust = $this->customer->get_by_id($this->input->post('id_Customer'));
		$data['nama_lengkap'] = $data_cust->nama_lengkap;
		$data['no_kontak'] = $data_cust->no_kontak;
		$data['alamat'] = $data_cust->alamat;
		$data['id_provinsi'] = $data_cust->id_provinsi;
		$data['id_kota_kab'] = $data_cust->id_kota_kab;
		$data['id_kecamatan'] = $data_cust->id_kecamatan;
		
		$data['keterangan'] = $this->input->post('Keterangan');
		
		$data['total_kuantitas'] = $this->sales_order->total_items();
		$data['total_harga'] = $this->input->post('nilai_total_harga');
		$data['diskon'] = $this->input->post('nilai_diskon');
		$data['ppn'] = $this->input->post('nilai_ppn');
		$data['grand_total'] = $this->input->post('nilai_grand_total');

		$data['user'] = $this->input->post('User');
		
		$data['status'] = TRUE;
			
		echo json_encode($data);	
		*/
		
	
		$this->_validate_form_SO();
		
		$last_id = $this->so->get_last_number();
		//print_r($data);
		foreach ($last_id as $hasil)
		{
			//echo $hasil->id_order;
			$nomor = ($hasil->id_order)+1;
		}
		
		date_default_timezone_set('Asia/Jakarta');
		$waktu = date('H:i:s');
		
		$data_cust = $this->customer->get_by_id($this->input->post('id_Customer'));
		
		//menambahkan data PO ke tabel pembelian master
		$data_master = array(
			'id_order' => $nomor,
			'nomor_order' => $this->input->post('nomor_SO'),
			'jenis_order' => 'SO',
			'tanggal' => date('Y-m-d', strtotime($this->input->post('tgl_SO'))),
			'waktu' => $waktu,
			'id_member' => $this->input->post('id_Customer'),
			'nama_lengkap' => $data_cust->nama_lengkap,
			'no_kontak' => $data_cust->no_kontak,
			'alamat' => $data_cust->alamat,
			'id_provinsi' => $data_cust->id_provinsi,
			'id_kota_kab' => $data_cust->id_kota_kab,
			'id_kecamatan' => $data_cust->id_kecamatan,
			'id_user' => $this->input->post('User'),
			'keterangan' => $this->input->post('Keterangan'),
			'total_kuantitas' => $this->sales_order->total_items(),
			'total_harga' => $this->input->post('nilai_total_harga'),
			'total_diskon' => $this->input->post('nilai_diskon'),
			'total_ppn' => $this->input->post('nilai_ppn'),
			'grand_total' => $this->input->post('nilai_grand_total'),
			'status' => 'ORDER'
		);

		$insert_master = $this->so->save_so_master($data_master);
		
		//menambahkan data item PO ke tabel pembelian detail
		foreach($this->sales_order->contents() as $items){
        
            $data_detail = array(
				'id_order' => $nomor,
                'nomor_order' => $this->input->post('nomor_SO'),
				'id_produk' => $items['id'],
                'kd_produk' => $items['code'],
				'nama_produk' => $items['name'],
                'kuantitas' => $items['qty'],
				'berat' => $items['weight'],
				'jumlah_berat' => $items['subweight'],
				'harga' => $items['price'],
				'jumlah_harga' => $items['subtotal']
            );
		
		$insert_detail = $this->so->save_so_detail($data_detail);
		
        }
    
        $this->sales_order->destroy();
		
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
	
	public function cek()
	{
		//$keyword = 'RM 8501';
		$keyword = $this->input->post('keyword');		
		
		if(!empty($keyword)) {
			
			$data = $this->produk->cari_kode($keyword);
			echo json_encode($data);
		}
	}
	
	
	public function add_order_confirmation()
	{
		$this->_validate_upload_form();
		/*
		$data['no_order'] = $this->input->post('nomor');
		$data['id_Bank'] = $this->input->post('id_Bank');
		$data['no_rekening'] = $this->input->post('no_Rekening');
		$data['status'] = TRUE;
		
		if(!empty($_FILES['bukti_bayar']['name']))
		{
			$upload = $this->upload_order_confirmation();
			$data['bukti_pembayaran'] = $upload;
		}
		
		echo json_encode($data);
		*/
		
		$data = array(
				'nomor_order' => $this->input->post('nomor'),
				'no_rekening' => $this->input->post('no_Rekening'),
				'id_bank' => $this->input->post('id_Bank')
				);
		
		if(!empty($_FILES['bukti_bayar']['name']))
		{
			$upload = $this->upload_order_confirmation();
			$data['bukti_pembayaran'] = $upload;
		}
		
		$insert = $this->so->save_order_confirmation($data);
		echo json_encode(array("status" => TRUE));
		
	}
	
	private function upload_order_confirmation()
	{
		$config['upload_path']          = 'upload/konfirmasi_pembayaran/';
        $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg';
        $config['max_size']             = 1000; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('bukti_bayar')) //upload and validate
        {
            $data['inputerror'][] = 'bukti_bayar';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
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
	
	public function get_invoice($nomor)
	{	
	
		//$nomor_so = $this->uri->segment();
		$data['master'] = $this->so->get_master_by_id_print($nomor);
		$data['detail'] = $this->so->get_detail_by_id_print($nomor);
		
		//echo $nomor;
		//print_r($data);
		$this->load->view('backend/print_invoice', $data);

	}
	
	private function _validate_form_SO()
	{		
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		if($this->input->post('nomor_SO') == '')
		{
			$data['inputerror'][] = 'nomor_SO';
			$data['error_string'][] = 'Nomor SO Harus diisi';
			$data['status'] = FALSE;
		}
		
		$nomor_so = $this->so->cek_nomor_SO($this->input->post('nomor_SO'));
		
		if(!empty($nomor_so))
		{
			$data['inputerror'][] = 'nomor_SO';
			$data['error_string'][] = 'Nomor SO sudah digunakan';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('id_Customer') == 0)
		{
			$data['inputerror'][] = 'id_Customer';
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
	
	private function _validate_upload_form()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		if($this->input->post('id_Bank') == 0)
		{
			$data['inputerror'][] = 'id_Bank';
			$data['error_string'][] = 'Pilih bank dahulu';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('no_Rekening') == '')
		{
			$data['inputerror'][] = 'no_Rekening';
			$data['error_string'][] = 'Nomor rekening harus diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
