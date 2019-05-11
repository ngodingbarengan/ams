<?php $this->load->view('include/home-header');?>
<?php $this->load->view('include/home-navbar');?>


	<div class="row">
		<div class="col-lg-12">
		  <ul class="breadcrumb">
			<li><a href="<?php echo site_url('home/index');?>"><span class="glyphicon glyphicon-home"></a></li>
			<li class="active"><a href="">Login</a></li>
		  </ul>
		</div>
	</div><!-- breadcrumb row end //-->

	<br/>
	
		<!-- Page Features -->
        <div class="row text-center">

<script>
	$(function(){
	
		//------------------------Proses Login Ajax-------------------------//
		$('#FormLogin').submit(function(e){
			e.preventDefault();
			$.ajax({
				url: $(this).attr('action'),
				type: "POST",
				cache: false,
				data: $(this).serialize(),
				dataType:'json',
				success: function(json){
					
					//response dari json_encode di controller
					if(json.status == 1){ window.location.href = json.url_home; }
					if(json.status == 3){ $('#ResponseInput').html(json.pesan); }
					if(json.status == 2){
						$('#ResponseInput').html(json.pesan);
						$('#InputPassword').val('');
					}
				}
			});
		});

		//-----------------------Ketika Tombol Reset Diklik-----------------//
		$('#ResetData').click(function(){
			$('#ResponseInput').html('');
		});
	});
	</script>
		
<div class="container">
    <div class="row row-centered">
        <div class="col-md-5 col-centered">
            <div class="panel panel-default">
                <div class="panel-heading text-center"> 
					<strong>LOGIN MEMBER</strong>
                </div>
                <div class="panel-body">
					<?php echo form_open('login_member', array('id' => 'FormLogin', 'class' => 'form-horizontal')); ?>
                    <!--<form class="form-horizontal" role="form"> -->
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Username / Email</label>
                            <div class="col-sm-8">
                                <!--<input type="email" class="form-control" id="inputEmail3" placeholder="Email" required="">-->
								<?php 
									echo form_input(array(
										'class' => 'form-control', 
										'name' => 'email', 
										'id' => 'email',
										'placeholder' => 'Email',
										'autofocus' => 'ON' 
										)); 
								?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                <!--<input type="password" class="form-control" id="inputPassword3" placeholder="Password" required="">-->
								<?php 
									echo form_input(array(
										'class' => 'form-control', 
										'name' => 'password', 
										'id' => 'password',
										'placeholder' => 'Password',
										'type' => 'password'
										)); 
								?>
                            </div>
                        </div>
                        <div class="form-group last">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-success btn-sm">Sign in</button>
                                <button type="reset"  id="ResetData" class="btn btn-default btn-sm">Reset</button>
                            </div>
                        </div>
					<!--</form>-->
					<?php echo form_close(); ?>
					
					<div id='ResponseInput'></div>

                </div>
                <div class="panel-footer text-center">Belum registrasi? <a href="<?php echo site_url('home/register'); ?>" class="">Daftar disini</a>
                </div>
            </div>
        </div>
    </div>
</div>
		
        </div>
        <!-- /.row -->

<?php $this->load->view('include/home-footer');?>
