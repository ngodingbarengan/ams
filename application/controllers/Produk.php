<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('produk_model','produk');
		$this->load->library('session');
		
		$id = $this->session->userdata('id_user');
		$user = $this->session->userdata('nama_user');
		$pass = $this->session->userdata('password_user');
		$hak_akses = $this->session->userdata('hak_akses_user');
		
		if(empty($id) || empty($user) || empty($hak_akses))
		{
			redirect('Login_user');
		}
	}

	public function index()
	{		
		$this->load->helper('url');
		
		$data=array(
            'option_kategori'=>$this->produk->get_kategori_list(),
            'option_merek'=>$this->produk->get_merek_list(),
            'option_satuan'=>$this->produk->get_satuan_list(),
        );
		$this->load->view('backend/produk_view', $data);
	}

	public function ajax_list()
	{
		
		//testing isi model
		//$hasil['isi'] = $this->produk->_get_datatables_query();
		//print_r($hasil['isi'][0]['kd_produk']);
		//print_r($hasil);
		
		$hak_akses = $this->session->userdata('hak_akses_user');
		$this->load->helper('url');

		$list = $this->produk->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $produk) {
			$no++;
			$row = array();
			$row[] = $produk->id_kategori;
			$row[] = $produk->nama_kategori;
			$row[] = $produk->kd_produk;
			$row[] = $produk->nama_produk;
			$row[] = $produk->id_merek;
			$row[] = $produk->nama_merek;
			$row[] = $produk->id_satuan;
			$row[] = $produk->nama_satuan;
					//number_format(number,decimals,decimalpoint,separator)
			$row[] = number_format($produk->berat, 3, ',', '.');
			$row[] = number_format($produk->harga, 0, '.', '.');
			$row[] = $produk->stok;
			$row[] = $produk->deskripsi;
			
			if($produk->foto_1)
				$row[] = '<a href="'.base_url('upload/foto_produk/'.$produk->foto_1).'" target="_blank"><img src="'.base_url('upload/foto_produk/'.$produk->foto_1).'" class="img-responsive"></a>';
			else
				$row[] = '<span class="badge badge-info">Tidak ada foto</span>';
			
			if($produk->foto_2)
				$row[] = '<a href="'.base_url('upload/foto_produk/'.$produk->foto_2).'" target="_blank"><img src="'.base_url('upload/foto_produk/'.$produk->foto_2).'" class="img-responsive"></a>';
			else
				$row[] = '<span class="badge badge-info">Tidak ada foto</span>';
			
			if($produk->foto_3)
				$row[] = '<a href="'.base_url('upload/foto_produk/'.$produk->foto_3).'" target="_blank"><img src="'.base_url('upload/foto_produk/'.$produk->foto_3).'" class="img-responsive"></a>';
			else
				$row[] = '<span class="badge badge-info">Tidak ada foto</span>';
			
			if($produk->foto_4)
				$row[] = '<a href="'.base_url('upload/foto_produk/'.$produk->foto_4).'" target="_blank"><img src="'.base_url('upload/foto_produk/'.$produk->foto_4).'" class="img-responsive"></a>';
			else
				$row[] = '<span class="badge badge-info">Tidak ada foto</span>';
			
			if($produk->foto_5)
				$row[] = '<a href="'.base_url('upload/foto_produk/'.$produk->foto_5).'" target="_blank"><img src="'.base_url('upload/foto_produk/'.$produk->foto_5).'" class="img-responsive"></a>';
			else
				$row[] = '<span class="badge badge-info">Tidak ada foto</span>';
			
			//menampilkan aktif atau tidaknya produk
			$row[] = '<span class="badge badge-info">'.$produk->aktif.'</span>';
			
			//add html for action if role ADMINISTRATOR
			if($hak_akses == 'ADMINISTRATOR'){
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Rincian" onclick="view_data('."'".$produk->id_produk."'".')"><i class="glyphicon glyphicon-info-sign"></i> </a>
			<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Ubah" onclick="edit_data('."'".$produk->id_produk."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data('."'".$produk->id_produk."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
			}else{
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Rincian" onclick="view_data('."'".$produk->id_produk."'".')"><i class="glyphicon glyphicon-info-sign"></i> </a>';
			}
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->produk->count_all(),
						"recordsFiltered" => $this->produk->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function ajax_view($id)
	{
		$data = $this->produk->get_by_id_view($id);
		echo json_encode($data);
		
		//$id = 3;
		//print_r($id);
	}

	public function ajax_edit($id)
	{
		$data = $this->produk->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{

		$this->_validate();
		
		
		$data = array(
				'id_kategori' => $this->input->post('id_Kategori'),
				'kd_produk' => $this->input->post('kd_Produk'),
				'nama_produk' => $this->input->post('nama_Produk'),
				'id_merek' => $this->input->post('id_Merek'),
				'id_satuan' => $this->input->post('id_Satuan'),
				'berat' => $this->input->post('berat_Produk'),
				'harga' => $this->input->post('harga_Produk'),
				'stok' => $this->input->post('stok_Produk'),
				'deskripsi' => $this->input->post('deskripsi_Produk'),
				'aktif' => $this->input->post('aktif_Produk'),
			);

		if(!empty($_FILES['foto1']['name']))
		{
			$upload = $this->_do_upload_1();
			$data['foto_1'] = $upload;
		}
		
		if(!empty($_FILES['foto2']['name']))
		{
			$upload = $this->_do_upload_2();
			$data['foto_2'] = $upload;
		}
		
		if(!empty($_FILES['foto3']['name']))
		{
			$upload = $this->_do_upload_3();
			$data['foto_3'] = $upload;
		}
		
		if(!empty($_FILES['foto4']['name']))
		{
			$upload = $this->_do_upload_4();
			$data['foto_4'] = $upload;
		}
		
		if(!empty($_FILES['foto5']['name']))
		{
			$upload = $this->_do_upload_5();
			$data['foto_5'] = $upload;
		}
		
		$insert = $this->produk->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'id_kategori' => $this->input->post('id_Kategori'),
				'kd_produk' => $this->input->post('kd_Produk'),
				'nama_produk' => $this->input->post('nama_Produk'),
				'id_merek' => $this->input->post('id_Merek'),
				'id_satuan' => $this->input->post('id_Satuan'),
				'berat' => $this->input->post('berat_Produk'),
				'harga' => $this->input->post('harga_Produk'),
				'stok' => $this->input->post('stok_Produk'),
				'deskripsi' => $this->input->post('deskripsi_Produk'),
				'aktif' => $this->input->post('aktif_Produk'),
			);
		
		
		//case ubah foto 1
		if($this->input->post('hapus_foto_1') && empty($_FILES['foto1']['name'])) // if remove photo checked
		{
			if(file_exists('upload/foto_produk/'.$this->input->post('hapus_foto_1')) && $this->input->post('hapus_foto_1'))
				unlink('upload/foto_produk/'.$this->input->post('hapus_foto_1'));
			$data['foto_1'] = '';
		}
		else if(empty($this->input->post('hapus_foto_1')) && !empty($_FILES['foto1']['name']))
		{
			$upload = $this->_do_upload_1();
			$data['foto_1'] = $upload;
		}
		else if(!empty($this->input->post('hapus_foto_1')) && !empty($_FILES['foto1']['name']))
		{
			//delete file existing
			$produk = $this->produk->get_by_id($this->input->post('id'));
			if(file_exists('upload/foto_produk/'.$produk->foto_1) && $produk->foto_1)
				unlink('upload/foto_produk/'.$produk->foto_1);
			$upload = $this->_do_upload_1();
			$data['foto_1'] = $upload;
		}
		else
		{
			$produk = $this->produk->get_by_id($this->input->post('id'));
			$data['foto_1'] = $produk->foto_1;
		}
		
		//case ubah foto 2
		if($this->input->post('hapus_foto_2') && empty($_FILES['foto2']['name'])) // if remove photo checked
		{
			if(file_exists('upload/foto_produk/'.$this->input->post('hapus_foto_2')) && $this->input->post('hapus_foto_2'))
				unlink('upload/foto_produk/'.$this->input->post('hapus_foto_2'));
			$data['foto_2'] = '';
		}
		else if(empty($this->input->post('hapus_foto_2')) && !empty($_FILES['foto2']['name']))
		{
			$upload = $this->_do_upload_2();
			$data['foto_2'] = $upload;
		}
		else if(!empty($this->input->post('hapus_foto_2')) && !empty($_FILES['foto2']['name']))
		{
			//delete file existing
			$produk = $this->produk->get_by_id($this->input->post('id'));
			if(file_exists('upload/foto_produk/'.$produk->foto_2) && $produk->foto_2)
				unlink('upload/foto_produk/'.$produk->foto_2);
			$upload = $this->_do_upload_2();
			$data['foto_2'] = $upload;
		}
		else
		{
			$produk = $this->produk->get_by_id($this->input->post('id'));
			$data['foto_2'] = $produk->foto_2;
		}
		
		
		//case ubah foto 3
		if($this->input->post('hapus_foto_3') && empty($_FILES['foto3']['name'])) // if remove photo checked
		{
			if(file_exists('upload/foto_produk/'.$this->input->post('hapus_foto_3')) && $this->input->post('hapus_foto_3'))
				unlink('upload/foto_produk/'.$this->input->post('hapus_foto_3'));
			$data['foto_3'] = '';
		}
		else if(empty($this->input->post('hapus_foto_3')) && !empty($_FILES['foto3']['name']))
		{
			$upload = $this->_do_upload_3();
			$data['foto_3'] = $upload;
		}
		else if(!empty($this->input->post('hapus_foto_3')) && !empty($_FILES['foto3']['name']))
		{
			//delete file existing
			$produk = $this->produk->get_by_id($this->input->post('id'));
			if(file_exists('upload/foto_produk/'.$produk->foto_3) && $produk->foto_3)
				unlink('upload/foto_produk/'.$produk->foto_3);
			$upload = $this->_do_upload_3();
			$data['foto_3'] = $upload;
		}
		else
		{
			$produk = $this->produk->get_by_id($this->input->post('id'));
			$data['foto_3'] = $produk->foto_3;
		}
		
		//case ubah foto 4
		if($this->input->post('hapus_foto_4') && empty($_FILES['foto4']['name'])) // if remove photo checked
		{
			if(file_exists('upload/foto_produk/'.$this->input->post('hapus_foto_4')) && $this->input->post('hapus_foto_4'))
				unlink('upload/foto_produk/'.$this->input->post('hapus_foto_4'));
			$data['foto_4'] = '';
		}
		else if(empty($this->input->post('hapus_foto_4')) && !empty($_FILES['foto4']['name']))
		{
			$upload = $this->_do_upload_4();
			$data['foto_4'] = $upload;
		}
		else if(!empty($this->input->post('hapus_foto_4')) && !empty($_FILES['foto4']['name']))
		{
			//delete file existing
			$produk = $this->produk->get_by_id($this->input->post('id'));
			if(file_exists('upload/foto_produk/'.$produk->foto_4) && $produk->foto_4)
				unlink('upload/foto_produk/'.$produk->foto_4);
			$upload = $this->_do_upload_4();
			$data['foto_4'] = $upload;
		}
		else
		{
			$produk = $this->produk->get_by_id($this->input->post('id'));
			$data['foto_4'] = $produk->foto_4;
		}
		
		//case ubah foto 5
		if($this->input->post('hapus_foto_5') && empty($_FILES['foto5']['name'])) // if remove photo checked
		{
			if(file_exists('upload/foto_produk/'.$this->input->post('hapus_foto_5')) && $this->input->post('hapus_foto_5'))
				unlink('upload/foto_produk/'.$this->input->post('hapus_foto_5'));
			$data['foto_5'] = '';
		}
		else if(empty($this->input->post('hapus_foto_5')) && !empty($_FILES['foto5']['name']))
		{
			$upload = $this->_do_upload_5();
			$data['foto_5'] = $upload;
		}
		else if(!empty($this->input->post('hapus_foto_5')) && !empty($_FILES['foto5']['name']))
		{
			//delete file existing
			$produk = $this->produk->get_by_id($this->input->post('id'));
			if(file_exists('upload/foto_produk/'.$produk->foto_5) && $produk->foto_5)
				unlink('upload/foto_produk/'.$produk->foto_5);
			$upload = $this->_do_upload_5();
			$data['foto_5'] = $upload;
		}
		else
		{
			$produk = $this->produk->get_by_id($this->input->post('id'));
			$data['foto_5'] = $produk->foto_5;
		}
		

		$this->produk->update(array('id_produk' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		//delete foto
		$produk = $this->produk->get_by_id($id);
		if(file_exists('upload/foto_produk/'.$produk->foto_1) && $produk->foto_1)
			unlink('upload/foto_produk/'.$produk->foto_1);
		if(file_exists('upload/foto_produk/'.$produk->foto_2) && $produk->foto_2)
			unlink('upload/foto_produk/'.$produk->foto_2);
		if(file_exists('upload/foto_produk/'.$produk->foto_3) && $produk->foto_3)
			unlink('upload/foto_produk/'.$produk->foto_3);
		if(file_exists('upload/foto_produk/'.$produk->foto_4) && $produk->foto_4)
			unlink('upload/foto_produk/'.$produk->foto_4);
		if(file_exists('upload/foto_produk/'.$produk->foto_5) && $produk->foto_5)
			unlink('upload/foto_produk/'.$produk->foto_5);
		
		$this->produk->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload_1()
	{
		$config['upload_path']          = 'upload/foto_produk/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 300; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('foto1')) //upload and validate
        {
            $data['inputerror'][] = 'foto1';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}
	
	private function _do_upload_2()
	{
		$config['upload_path']          = 'upload/foto_produk/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 300; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('foto2')) //upload and validate
        {
            $data['inputerror'][] = 'foto2';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}
	
	private function _do_upload_3()
	{
		$config['upload_path']          = 'upload/foto_produk/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 300; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('foto3')) //upload and validate
        {
            $data['inputerror'][] = 'foto3';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}
	
	private function _do_upload_4()
	{
		$config['upload_path']          = 'upload/foto_produk/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('foto4')) //upload and validate
        {
            $data['inputerror'][] = 'foto4';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}
	
	private function _do_upload_5()
	{
		$config['upload_path']          = 'upload/foto_produk/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 300; //set max size allowed in Kilobyte
        $config['max_width']            = 1000; // set max width image allowed
        $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('foto5')) //upload and validate
        {
            $data['inputerror'][] = 'foto5';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}
	
	/*
	public function test()
	{
		//$hasil['isi'] = $this->produk->_get_datatables_query();
		$data ['isi']= $this->produk->get_kode_produk('K001');
		print_r($data);
	}*/
	
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		
		if($this->input->post('id_Kategori') == 0)
		{
			$data['inputerror'][] = 'id_Kategori';
			$data['error_string'][] = 'Pilih kategori dahulu';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('kd_Produk') == '')
		{
			
			$data['inputerror'][] = 'kd_Produk';
			$data['error_string'][] = 'Masukkan kode Produk';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('nama_Produk') == '')
		{
			$data['inputerror'][] = 'nama_Produk';
			$data['error_string'][] = 'Masukkan nama produk';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('id_Merek') == 0)
		{
			$data['inputerror'][] = 'id_Merek';
			$data['error_string'][] = 'Pilih merek dahulu';
			$data['status'] = FALSE;
		}

		if($this->input->post('id_Satuan') == 0)
		{
			$data['inputerror'][] = 'id_Satuan';
			$data['error_string'][] = 'Pilih satuan dahulu';
			$data['status'] = FALSE;
		}

		if($this->input->post('berat_Produk') == '')
		{
			$data['inputerror'][] = 'berat_Produk';
			$data['error_string'][] = 'Masukkan berat dahulu';
			$data['status'] = FALSE;
		}

		if($this->input->post('harga_Produk') == '')
		{
			$data['inputerror'][] = 'harga_Produk';
			$data['error_string'][] = 'Masukkan harga dahulu';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('aktif_Produk') == ''	)
		{
			$data['inputerror'][] = 'aktif_Produk';
			$data['error_string'][] = 'Pilih opsi dahulu';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
	/*
	private function _validate_add(){

			//cek kode produk yang sudah digunakan
			$data = $this->produk->get_kode_produk($this->input->post('kd_Produk'));
			if(!empty($data))
			{
				$data['inputerror'][] = 'kd_Produk';
				$data['error_string'][] = 'Kode produk sudah digunakan';
				$data['status'] = FALSE;
			}
	}	*/

}
