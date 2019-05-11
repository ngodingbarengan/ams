<!DOCTYPE html>
<html lang="en">
<head>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="icon" href="<?php echo base_url('assets/images');?>/ams.png">

    <title>PT. Anugrah Mitra Selaras</title>

    <!-- Bootstrap CSS -->    
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
    
    <!--external css-->
    <!-- font icon -->
    <link href="<?php echo base_url('assets/NiceAdmin/css/elegant-icons-style.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/NiceAdmin/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- Custom styles -->
    <link href="<?php echo base_url('assets/NiceAdmin/css/style.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/NiceAdmin/css/style-responsive.css');?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
  </head>

  <body class="login-img3-body"> <!-- <body class="login-img3-body"> -->

    <div class="container">
	
<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
	
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
	
	
	<?php echo form_open('login_user', array('id' => 'FormLogin', 'class' => 'login-form')); ?>
    <!--<form class="login-form" action="#">-->
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i></p>
			<h4 class="text-center">PT. ANUGRAH MITRA SELARAS</h4>
            <div class="input-group">
				<span class="input-group-addon"><i class="icon_profile"></i></span>
				<!-- <input type="text" class="form-control" placeholder="Email" id="username" autofocus> -->
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
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <!-- <input type="password" class="form-control" placeholder="Password" id="password" password> -->
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
			
			<div id='ResponseInput'></div>
		
            <button class="btn btn-primary btn-lg btn-block" type="submit" id="Login">Login</button>
            <button class="btn btn-info btn-lg btn-block" type="reset" id="ResetData">Reset</button>
        </div>
      <!--</form>-->
	<?php echo form_close(); ?>
	

  </body>
</html>
