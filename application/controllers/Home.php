<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		// ... kkkkk
		parent::__construct();
		$this->load->model('produk_model','produk');
		$this->load->model('wishlist_model','wishlist');
		$this->load->model('Customer_model','customer');
		$this->load->model('Customer_order_model','co');
		$this->load->model('User_model','user');
		$this->load->model('Ongkir_model','ongkir');
		$this->load->model('Halaman_model','halaman');
		$this->load->model('Bank_model','bank');
		$this->load->library('my_cart');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('form');

	}
	
	public function get_stok_by_id()
	{
		$id = 30;
		
		/*
		$stok = $this->produk->cari_kode($id);
	
		//print_r($stok);
		
		echo $stok->stok;
		*/
		
		$jumlah_order = $this->produk->get_jumlah_order_by_id($id);
		
		print_r($jumlah_order);
		
		foreach($jumlah_order as $isi){
			echo $isi->kuantitas;
		}
		
	}
	
	public function order_transaction()
	{	
		$id_member = $this->session->userdata('id_member');
		$data['master'] = $this->co->get_transaction_by_id($id_member);
		$data['option_bank'] = $this->bank->get_bank_list();
		//print_r($data);
		$this->load->view('order_transaction', $data);
	}
	
	public function order_history()
	{	
		$id_member = $this->session->userdata('id_member');
		$data['master'] = $this->co->get_history_by_id($id_member);
		$data['option_bank'] = $this->bank->get_bank_list();
		//print_r($data);
		$this->load->view('order_history', $data);
	}
	
	public function order_cancel()
	{	
		$id_member = $this->session->userdata('id_member');
		$data['master'] = $this->co->get_cancel_by_id($id_member);
		$this->load->view('order_cancel', $data);
	}
	
	public function order_detail()
	{
		$data['detail'] = $this->co->get_detail_by_id($this->input->post('nomor_order'));
		$data['status'] = TRUE;
		
		echo json_encode($data);
	}
	
	public function acceptance_confirmation()
	{
		//$data['no_order'] = $this->input->post('nomor_order');
		//$data['status'] = TRUE;
		
		//echo json_encode($data);
		
		$data_master = array(
				'status' => 'FINISH'
				);
		
		//ubah status order menjadi finish
		$this->co->ubah_status(array('nomor_order' => $this->input->post('nomor_order')), $data_master);
		echo json_encode(array("status" => TRUE));
		
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
		
		$insert = $this->co->save_order_confirmation($data);
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
	
	public function index()
	{	
		$id_member = $this->session->userdata('id_member');
		$email= $this->session->userdata('email_member');
		$pass = $this->session->userdata('password_member');
		$nama = $this->session->userdata('nama_member');
		$kecamatan = $this->session->userdata('kecamatan_member');
		
		//configurasi pagination
        $config['base_url'] = site_url('home/index');
        $config['total_rows'] = $this->produk->count_all();
        $config['per_page'] = 12;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config); 
        
		//menentukan offset record dari uri segment
        $start = $this->uri->segment(3, 0);
		
		//ubah data menjadi tampilan per limit
		$rows = $this->produk->get_all_product_index($config['per_page'], $start);
		
        $data = array(
            'produk' => $rows,
            'pagination' => $this->pagination->create_links(),
            'start' => $start
        );
		
        $this->load->view('index', $data);
    }	
	
	public function checkout()
	{
		$get_id_kecamatan = $this->user->get_by_id_member($this->session->userdata('id_member'));
		//print_r($data);
		$kecamatan = $get_id_kecamatan->id_kecamatan;
		
		$get_ongkir = $this->ongkir->get_ongkir_by_id_kecamatan($kecamatan);
		//print_r($get_data_ongkir);
		$ongkir = $get_ongkir->ongkir;
		
		$data['option_provinsi'] = $this->customer->get_provinsi_list();
		$data['member'] = $this->user->get_by_id_member($this->session->userdata('id_member'));
		$data['ongkir'] = $ongkir;
		
		$this->load->view('checkout',$data);
	}
	
	public function get_ongkir($id_kecamatan)
	{
		$get_ongkir = $this->ongkir->get_ongkir_by_id_kecamatan($id_kecamatan);
		$ongkir = $get_ongkir->ongkir;
		
		$data['ongkir'] = $ongkir;
		$data['status'] = TRUE;
		
		echo json_encode($data);
	}
	
	public function add_CO()
	{
		/*
		$this->_validate_update_address();
		
		$data['nama_lengkap'] = $this->input->post('Nama_Lengkap');
		$data['phonenumber'] = $this->input->post('Phonenumber');
		$data['alamat'] = $this->input->post('Alamat');
		$data['provinsi'] = $this->input->post('id_Provinsi');
		$data['kotakab'] = $this->input->post('id_KotaKab');
		$data['kecamatan'] = $this->input->post('id_Kecamatan');
		$data['ongkir'] = $this->input->post('ongkir_value');
		$data['total'] = $this->input->post('total_value');
		$data['status'] = TRUE;
			
		echo json_encode($data);
		*/
		
		
		$last_id = $this->co->get_last_number();
		//print_r($data);
		foreach ($last_id as $hasil)
		{
			//echo $hasil->id_order;
			$nomor = ($hasil->id_order)+1;
		}
		
		date_default_timezone_set('Asia/Jakarta');
		$tanggal = date('Ymd');
		$bulan = date('m');
		$waktu_transaksi = date('H:i:s');
		$tanggal_transaksi = date('Y-m-d');
		
		switch ($bulan) {
			   case 1: 
					$bulan = 'I';
					break;
			   case 2:
					$bulan = 'II';
					break;
			   case 3:
					$bulan = 'III';
					break;
			   case 4:
					$bulan = 'IV';
					break;
			   case 5:
					$bulan = 'V';
					break;
				case 6:
					$bulan = 'VI';
					break;
				case 7:
					$bulan = 'VII';
					break;
				case 8:
					$bulan = 'VIII';
					break;
				case 9:
					$bulan = 'IX';
					break;
				case 10:
					$bulan = 'X';
					break;
				case 11:
					$bulan = 'XI';
					break;
				case 12:
					$bulan = 'XI';
					break;
		}
		
		$nomor_co = 'INV/'.$tanggal.'/'.$bulan.'/'.$nomor;

	
		//menambahkan data CO ke tabel pembelian master
		$data_master = array(
			'id_order' => $nomor,
			'nomor_order' => $nomor_co,
			'jenis_order' => 'CO',
			'tanggal' => $tanggal_transaksi,
			'waktu' => $waktu_transaksi,
			'id_member' => $this->session->userdata('id_member'),
			'nama_lengkap' => $this->input->post('Nama_Lengkap'),
			'no_kontak' => $this->input->post('Phonenumber'),
			'alamat' => $this->input->post('Alamat'),
			'id_provinsi' => $this->input->post('id_Provinsi'),
			'id_kota_kab' => $this->input->post('id_KotaKab'),
			'id_kecamatan' => $this->input->post('id_Kecamatan'),
			'id_user' => $this->session->userdata('id_user'),
			'keterangan' => '',
			'total_kuantitas' => $this->my_cart->total_items(),
			'total_berat' => $this->my_cart->total_weight(),
			'total_harga' => $this->my_cart->total(),
			'total_diskon' => 0,
			'total_ppn' => 0,
			'ongkir' => $this->input->post('ongkir_value'),
			'grand_total' => $this->input->post('total_value'),
			'status' => 'ORDER'
		);

		$insert_master = $this->co->save_co_master($data_master);
		
		//menambahkan data item CO ke tabel pembelian detail
		foreach($this->my_cart->contents() as $items){
        
            $data_detail = array(
                'nomor_order' => $nomor_co,
				'id_produk' => $items['id'],
                'kd_produk' => $items['code'],
				'nama_produk' => $items['name'],
                'kuantitas' => $items['qty'],
				'berat' => $items['weight'],
				'jumlah_berat' => $items['subweight'],
				'harga' => $items['price'],
				'jumlah_harga' => $items['subtotal']
            );
		
		$insert_detail = $this->co->save_co_detail($data_detail);
		
        }
    
        $this->my_cart->destroy();
		
		echo json_encode(array("status" => TRUE));
		
	}
	
	public function register()
	{
		$data['option_provinsi'] = $this->customer->get_provinsi_list();
		$this->load->view('register',$data);
	}
	
	public function terms()
	{
		$data['isi'] = $this->halaman->syarat_ketentuan();
		//print_r($data);
		$this->load->view('terms',$data);
	}
	
	public function save_register()
	{
		/*
		//testing data json
		$this->_validate_register();
		
		$data['email'] = $this->input->post('Email');
		$data['username'] = $this->input->post('Username');
		$data['password_1'] = $this->input->post('Password_1');
		$data['password_2'] = $this->input->post('Password_2');
		$data['nama_lengkap'] = $this->input->post('Nama_Lengkap');
		$data['phonenumber'] = $this->input->post('Phonenumber');
		$data['alamat'] = $this->input->post('Alamat');
		$data['provinsi'] = $this->input->post('id_Provinsi');
		$data['kotakab'] = $this->input->post('id_KotaKab');
		$data['kecamatan'] = $this->input->post('id_Kecamatan');
		
		$data['status'] = TRUE;
			
		echo json_encode($data);
		*/
		
		$this->_validate_register();
		
		//insert into tbl_member
		$get_max = $this->user->id_member_max();
		foreach ($get_max as $nilai)
		{
			$hasil = $nilai->id_member;
		}
		$id_member = $hasil + 1;
		
		$data_member = array(
				'id_member' => $id_member,
				'nama_lengkap' => $this->input->post('Nama_Lengkap'),
				'no_kontak' => $this->input->post('Phonenumber'),
				'alamat' => $this->input->post('Alamat'),
				'id_provinsi' => $this->input->post('id_Provinsi'),
				'id_kota_kab' => $this->input->post('id_KotaKab'),
				'id_kecamatan' => $this->input->post('id_Kecamatan'),
				'tipe' => 'CUST_ONLINE'
			);
		$insert = $this->user->save_member($data_member);
		
		//insert into tbl_user
		date_default_timezone_set('Asia/Jakarta');
		
		$add_on = date('Y-m-d H:i:s');
		
		$data = array(
				'id_member' => $id_member,
				'email' => $this->input->post('Email'),
				'username' => $this->input->post('Username'),
				'password' => $this->input->post('Password_1'),
				'hak_akses' => 'CUSTOMER',
				'aktif' => 'Y',
				'ditambahkan' => $add_on
			);
		$insert = $this->user->save($data);
		
		echo json_encode(array("status" => TRUE));
	}
	
	public function id_member_max()
	{
		$get_max = $this->user->id_member_max();
		foreach ($hasil as $nilai)
		{
			$nilainya = $nilai->id_member;
		}
		$hasil2 = $nilainya + 1;
		echo $hasil2;
		//print_r($nilainya);
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
	
	public function login()
	{
		$this->load->view('login');
	}
	
	
	public function produk_detail()
	{
		$produkID =  $this->uri->segment(3);
		
		$data['produk'] = $this->produk->get_by_id_view($produkID);
		
		foreach ($data as $barang)
		{
			$kategoriID = $barang->id_kategori;	
		}

		$kueri = $this->produk->get_jumlah_order_by_id($produkID);
		foreach ($kueri as $isi){
			if(!empty($isi->kuantitas)){
				$jumlah_order = $isi->kuantitas;
			}else{
				$jumlah_order = 0;
			}
		}
		
		$data['jumlah_order'] = $jumlah_order;
		
		$data['produk_sejenis'] = $this->produk->get_by_id_kategori($produkID, $kategoriID);
		
		$this->load->view('produk_detail', $data);
	}
	
	public function shopping_cart()
	{
		$this->load->view('shopping_cart');
	}
	
	public function select_kategori()
	{
		$data = $this->produk->get_kategori_view();
		
		//print_r($data);
		echo json_encode($data);
	}
	
	public function category()
	{

		$id =  $this->uri->segment(3);
		
		//configurasi pagination
		$config['base_url'] = site_url('home/kategori/'.$id.'');
		$config['total_rows'] = $this->produk->count_all_product_by_category($id);
		$config['per_page'] = 12;
		$config['uri_segment'] = 4;
		$this->pagination->initialize($config); 
			
		//menentukan offset record dari uri segment
		$start = $this->uri->segment(4, 0);
			
		//ubah data menjadi tampilan per limit
		$rows = $this->produk->get_product_by_category($id, $config['per_page'], $start);
		
		//nama kategori
		$nama = $this->produk->get_category_name($id);
		
		$data = array(
			'nama_kategori' => $nama,
			'produk' => $rows,
			'pagination' => $this->pagination->create_links(),
			'start' => $start
		);
			
		$this->load->view('category', $data);
	}
	
	public function search()
	{
		//$keyword =  $this->input->post('keyword_value');
		//$keyword = 'oxygen';
		//echo json_encode($data);
		
		$keyword =  $this->input->post('search_text');
		
		$data['keyword'] = $keyword;
		$data['produk'] = $this->produk->search($keyword);
		//echo json_encode($data);
		//print_r($data['produk']);
		$this->load->view('search', $data);
		
	}
	
	public function change_profile()
	{
		$data['user'] = $this->user->get_by_id($this->session->userdata('id_user'));
		//print_r($data);
		$this->load->view('change_profile', $data);
	}
	
	public function update_profile()
	{
		$this->_validate_update_profile();
		
		/*
		$data['email'] = $this->input->post('Email');
		$data['username'] = $this->input->post('Username');
		$data['password_lama'] = $this->input->post('Password_Lama');
		$data['password_1'] = $this->input->post('Password_1');
		$data['password_2'] = $this->input->post('Password_2');
		$data['status'] = TRUE;
			
		echo json_encode($data);
		*/
		
		///*
		//update tbl_user
		date_default_timezone_set('Asia/Jakarta');
		
		$id_user = $this->session->userdata('id_user');
		$update_on = date('Y-m-d H:i:s');
		
		$data = array(
				'email' => $this->input->post('Email'),
				'username' => $this->input->post('Username'),
				'password' => $this->input->post('Password_1'),
				'terakhir_diubah' => $update_on,
				'oleh' => $id_user
			);
		$update = $this->user->update(array('id_user' => $id_user), $data);
		
		echo json_encode(array("status" => TRUE));
		//*/
	}
	
	public function change_address()
	{
		$data['option_provinsi'] = $this->customer->get_provinsi_list();
		$data['member'] = $this->user->get_by_id_member($this->session->userdata('id_member'));
		$this->load->view('change_address',$data);
	}
	
	public function update_address()
	{
		$this->_validate_update_address();
		
		/*
		$data['nama_lengkap'] = $this->input->post('Nama_Lengkap');
		$data['phonenumber'] = $this->input->post('Phonenumber');
		$data['alamat'] = $this->input->post('Alamat');
		$data['provinsi'] = $this->input->post('id_Provinsi');
		$data['kotakab'] = $this->input->post('id_KotaKab');
		$data['kecamatan'] = $this->input->post('id_Kecamatan');
		$data['status'] = TRUE;
			
		echo json_encode($data);
		*/
		$id_member = $this->session->userdata('id_member');
		
		$data_member = array(
				'nama_lengkap' => $this->input->post('Nama_Lengkap'),
				'no_kontak' => $this->input->post('Phonenumber'),
				'alamat' => $this->input->post('Alamat'),
				'id_provinsi' => $this->input->post('id_Provinsi'),
				'id_kota_kab' => $this->input->post('id_KotaKab'),
				'id_kecamatan' => $this->input->post('id_Kecamatan')
			);
		$update = $this->user->update_member(array('id_member' => $id_member), $data_member);
		
		echo json_encode(array("status" => TRUE));
	}
	
	public function how_to_order()
	{
		$data['isi'] = $this->halaman->cara_pemesanan();
		//print_r($data);
		$this->load->view('how_to_order',$data);
	}
	
	public function about_us()
	{
		$data['isi'] = $this->halaman->tentang_kami();
		//print_r($data);
		$this->load->view('about_us',$data);
	}
	
	public function contact()
	{
		$data['isi'] = $this->halaman->kontak();
		//print_r($data);
		$this->load->view('contact',$data);
	}
	
	public function message()
	{
		$this->load->view('message');
	}
	
	public function add_cart_item()
	{
		/*
		format standar input cart data pada Codeigniter, penamaan id, qty, price, dan name merupakan reserve word untuk class cart jadi tidak bisa diganti dan harus digunakan
		Untuk penamaan option bertipe array dapat digunakan bila memiliki variabel tambahan data untuk dimasukkan
		$data = array(
			'id' => number value,
			'qty' => number value,
			'price' => number value,
			'name' => 'string',
			'option' => array()
        );
		//awal percobaan data tidak bisa di-insert ke shopping cart
		//hal ini disebabkan karekter name yang digunakan memiliki rules sendiri dan nama yang digunakan menggunakan
		//karakter yang terlarang pada rules regex yaitu karakter - 
		//SOLUSI mengubah coding library cart pada system agar name mendukung semua karakter
		
		*/
		
		/*
		$data = array(
			'id' => $this->input->post('id_produk'),
			'qty' => $this->input->post('jumlah'),
			'price' => $this->input->post('harga'),
			'name' => $this->input->post('nama')
        );
 
        // Insert the product to cart
        $this->cart->insert($data);
		*/
		
		/*
		echo $this->input->post('id_produk').'<br/>';
		echo $this->input->post('jumlah').'<br/>';
		echo $this->input->post('harga').'<br/>';
		echo $this->input->post('nama').'<br/>';
		echo $this->input->post('berat').'<br/>';
		*/
		
		//nama produk tidak boleh mengandung titik ( . )
		
		$data = array(
			'id' => $this->input->post('id_produk'),
			'code' => $this->input->post('kd_produk'),
			'qty' => $this->input->post('jumlah'),
			'price' => $this->input->post('harga'),
			'name' => $this->input->post('nama'),
			'photo' => $this->input->post('foto'),
			'weight' => $this->input->post('berat')
        );
		
		$this->my_cart->insert($data);
		
		//$this->load->view('sc');
		
		$this->load->view('shopping_cart');
		//print_r($this->my_cart->contents());
	}
	
	public function update_cart_item()
	{
		$rowid =  $this->input->post('id_item');
		$qty = $this->input->post('jumlah_item');
		
		$data = array(
			'rowid' => $rowid,
			'qty' => $qty
        );
		
		$this->my_cart->update($data);
		
	}
	
	public function remove_cart_item()
	{	
		$rowid =  $this->input->post('id_item');
		
		$data = array(
			'rowid' => $rowid,
			'qty' => 0
        );
		
		$this->my_cart->update($data);
		
		//$this->load->view('shopping_cart');
	}
	
	public function wishlist()
	{	
		$id_member = $this->session->userdata('id_member');
		$email= $this->session->userdata('email_member');
		$pass = $this->session->userdata('password_member');
		$nama = $this->session->userdata('nama_member');
		$kecamatan = $this->session->userdata('kecamatan_member');
		
		if(!empty($id_member)){
		//configurasi pagination
		$config['base_url'] = site_url('home/wishlist');
		$config['total_rows'] = $this->produk->count_all_wishlist($id_member);
		$config['per_page'] = 12;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config); 
			
		//menentukan offset record dari uri segment
		$start = $this->uri->segment(3, 0);
			
		//ubah data menjadi tampilan per limit
		$rows = $this->produk->wishlist($id_member, $config['per_page'], $start)->result();
			
		$data = array(
			'hasil' => $rows,
			'pagination' => $this->pagination->create_links(),
			'start' => $start
		);
			
		$this->load->view('wishlist', $data);
		
		}else{
			$this->login();
		}
	}
	
	public function count_all_wishlist($id_member)
	{	
		//count for total wishlist
		$total_wishlist = $this->produk->count_all_wishlist($id_member);
		echo json_encode($total_wishlist);

	}
	
	public function add_wishlist($id_produk)
	{
		$id_member = $this->session->userdata('id_member');
		
		if(!empty($id_member)){
			$data = array(
				'id_produk' => $id_produk,
				'id_member' => $id_member
			);
			$insert = $this->wishlist->save($data);
			echo json_encode($insert);
		}
	}
	
	public function delete_wishlist($id_kategori)
	{
		$hasil = $this->wishlist->delete_by_id($id_kategori);
		echo json_encode($hasil);
	}
	
	private function _validate_register()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$email = $this->user->cek_email($this->input->post('Email'));
		
		if($this->input->post('Email') == '')
		{
			$data['inputerror'][] = 'Email';
			$data['error_string'][] = 'Email Harus diisi';
			$data['status'] = FALSE;
		}
		
		if(!empty($email))
		{
			$data['inputerror'][] = 'Email';
			$data['error_string'][] = 'Email sudah digunakan';
			$data['status'] = FALSE;
		}
		
		$username = $this->user->cek_username($this->input->post('Username'));
		
		if($this->input->post('Username') == '')
		{
			$data['inputerror'][] = 'Username';
			$data['error_string'][] = 'Username harus diisi';
			$data['status'] = FALSE;
		}
		
		if(!empty($username))
		{
			$data['inputerror'][] = 'Username';
			$data['error_string'][] = 'Username sudah digunakan';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Password_1') == '')
		{
			$data['inputerror'][] = 'Password_1';
			$data['error_string'][] = 'Password harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Password_2') == '')
		{
			$data['inputerror'][] = 'Password_2';
			$data['error_string'][] = 'Konfirmasi password harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Password_1') != $this->input->post('Password_2'))
		{
			$data['inputerror'][] = 'Password_2';
			$data['error_string'][] = 'Konfirmasi password tidak sesuai';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Nama_Lengkap') == '')
		{
			$data['inputerror'][] = 'Nama_Lengkap';
			$data['error_string'][] = 'Nama lengkap harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Phonenumber') == '')
		{
			$data['inputerror'][] = 'Phonenumber';
			$data['error_string'][] = 'Nomor handphone harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Alamat') == '')
		{
			$data['inputerror'][] = 'Alamat';
			$data['error_string'][] = 'Alamat harus diisi';
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
			$data['error_string'][] = 'Pilih kota / kabupaten dahulu';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('id_Kecamatan') == 0)
		{
			$data['inputerror'][] = 'id_Kecamatan';
			$data['error_string'][] = 'Pilih kecamatan dahulu';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
	private function _validate_update_profile()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		$cek_data = $this->user->get_by_id($this->session->userdata('id_user'));
		$email_lama = $cek_data->email;
		$username_lama = $cek_data->username;
		$password_lama = $cek_data->password;
		
		$cek_email = $this->user->cek_email($this->input->post('Email'));
		if(!empty($cek_email))
		{
			$email = $cek_email->email;
			
			if($email != $email_lama)
			{
				$data['inputerror'][] = 'Email';
				$data['error_string'][] = 'Email sudah digunakan';
				$data['status'] = FALSE;
			}
		}
		
		if($this->input->post('Email') == '')
		{
			$data['inputerror'][] = 'Email';
			$data['error_string'][] = 'Email Harus diisi';
			$data['status'] = FALSE;
		}
		
		$cek_username = $this->user->cek_username($this->input->post('Username'));
		if(!empty($cek_username))
		{
			$username = $cek_username->username;
			
			if($username != $username_lama)
			{
				$data['inputerror'][] = 'Username';
				$data['error_string'][] = 'Username sudah digunakan';
				$data['status'] = FALSE;
			}
		}
		
		if($this->input->post('Username') == '')
		{
			$data['inputerror'][] = 'Username';
			$data['error_string'][] = 'Username harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Password_Lama') != $password_lama)
		{
			$data['inputerror'][] = 'Password_Lama';
			$data['error_string'][] = 'Password lama kosong / tidak sesuai';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Password_1') == '')
		{
			$data['inputerror'][] = 'Password_1';
			$data['error_string'][] = 'Password baru harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Password_2') == '')
		{
			$data['inputerror'][] = 'Password_2';
			$data['error_string'][] = 'Konfirmasi password harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Password_1') != $this->input->post('Password_2'))
		{
			$data['inputerror'][] = 'Password_2';
			$data['error_string'][] = 'Konfirmasi password tidak sesuai';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
	private function _validate_update_address()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		if($this->input->post('Nama_Lengkap') == '')
		{
			$data['inputerror'][] = 'Nama_Lengkap';
			$data['error_string'][] = 'Nama lengkap harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Phonenumber') == '')
		{
			$data['inputerror'][] = 'Phonenumber';
			$data['error_string'][] = 'Nomor handphone harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('Alamat') == '')
		{
			$data['inputerror'][] = 'Alamat';
			$data['error_string'][] = 'Alamat harus diisi';
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
			$data['error_string'][] = 'Pilih kota / kabupaten dahulu';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('id_Kecamatan') == 0)
		{
			$data['inputerror'][] = 'id_Kecamatan';
			$data['error_string'][] = 'Pilih kecamatan dahulu';
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
