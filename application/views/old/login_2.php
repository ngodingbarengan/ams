<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PT. Anugrah Mitra Selaras</title>

    <!-- Bootstrap Core CSS -->
    <link type="text/css" media="all" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">

    <!-- Custom CSS -->
	<link type="text/css" media="all" href="<?php echo base_url('assets/home/css/heroic-features.css');?>" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

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

		<!-- Footer -->
		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="row text-center">
						<p class="text-muted">Powered by PT. Anugrah Mitra Selaras &copy; 2017</p>
					</div>
				</div>
			</div>
		</footer>

    <!-- jQuery -->
    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js');?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
	
	
	<!-- jQuery Server-->
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->
	
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
	
</body>

</html>


