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
			<li class="active"><a href="">Send Message</a></li>
		  </ul>
		</div>
	</div><!-- breadcrumb row end //-->

	<br/>
	
		<!-- Page Features -->
        <div class="row text-center">

<div class="container">
	<div class="row row-centered">
        <div class="col-md-8 col-centered">
            <form action="#" id="form_register" role="form">
            <fieldset>
			
			<div class="form-group">
                <label for="email"><span class="req"></span> Subject : </label> 
                    <input class="form-control" required type="text" name="Email" id="Email" placeholder="Masukkan subjek pesan"/>   
                    <span class="help-block"></span>
            </div>
			
            <div class="form-group">
                <label for="username"><span class="req"></span> Message : </label> 
                   <textarea style="width:95%; height:300px" placeholder="  Masukkan pesan"></textarea> 
                    <span class="help-block"></span>
            </div>

            <div class="form-group">
                <!--<input class="btn btn-success" type="submit" name="submit_reg" value="Register">-->
				<button type="button" id="btnSave" onclick="change_profile()" class="btn btn-success">Send</button>
            </div>

            </fieldset>
            </form><!-- ends register form -->
			
			<br/>
        </div><!-- ends col-6 -->


	</div>
</div>
		
        </div>
        <!-- /.row -->

<?php $this->load->view('include/home-footer');?>
