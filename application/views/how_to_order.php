<?php $this->load->view('include/home-header');?>
<?php $this->load->view('include/home-navbar');?>


	<?php 
		$id_member = $this->session->userdata('id_member');
		$email= $this->session->userdata('email');
		$pass = $this->session->userdata('password');
		$nama = $this->session->userdata('nama');
		$kecamatan = $this->session->userdata('kecamatan');
	?>


	<div class="row">
		<div class="col-lg-12">
		  <ul class="breadcrumb">
			<li><a href="<?php echo site_url('home/index');?>"><span class="glyphicon glyphicon-home"></a></li>
			<li class="active"><a href="">Cara Pemesanan</a></li>
		  </ul>
		</div>
	</div><!-- breadcrumb row end //-->

	<br/>
	
	<div class="container">
		<!-- Page Features -->
        <div class="row col-lg-12">
			
		<?php 
			echo $isi->isi_halaman; 
		?>

        </div>
        <!-- /.row -->
	</div>

<?php $this->load->view('include/home-footer');?>
