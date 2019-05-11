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
	
	<!-- jQuery -->
    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js');?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<script>

function ubah_password()
{
	if ($('#checkbox').is(':checked')){
		$('#ubah_password').empty();

		$('.form-group').removeClass('has-error'); // clear error class
		$('.help-block').empty(); // clear error string
		
		$('#ubah_password').append('<div class="form-group"><label for="password"><span class="req">* </span> Password Lama: </label><input required name="Password_Lama" type="password" class="form-control inputpass" minlength="4" maxlength="16"  placeholder="Masukkan password lama" id="Password_Lama" /><span class="help-block"></span></div>');
		
		$('#ubah_password').append('<div class="form-group"><label for="password"><span class="req">* </span> Password Baru: </label><input required name="Password_1" type="password" class="form-control inputpass" minlength="4" maxlength="16"  placeholder="Masukkan password baru" id="Password_1" /><span class="help-block"></span></div>');
		
		$('#ubah_password').append('<div class="form-group"><label for="password"><span class="req">* </span> Konfirmasi Password Baru: </label><input required name="Password_2" type="password" class="form-control inputpass" minlength="4" maxlength="16"  placeholder="Masukkan kembali password baru" id="Password_2" /><span class="help-block"></span></div>');
		
	}else{
		$('#ubah_password').empty();
		
		$('#ubah_password').append('<input type="hidden" type="text" name="Password_Lama" id="Password_Lama" value="<?php echo $user->password; ?>"/>');
		$('#ubah_password').append('<input type="hidden" type="text" name="Password_1" id="Password_1" value="<?php echo $user->password; ?>"/>');
		$('#ubah_password').append('<input type="hidden" type="text" name="Password_2" id="Password_2" value="<?php echo $user->password; ?>"/>');
	}
}

function change_profile()
{
	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	
	// ajax adding data to database
    var formData = new FormData($("#form_register")[0]);
	//var formData = $('#form_item').serialize();
	console.log(formData);
    $.ajax({
        url : "<?php echo site_url('home/update_profile');?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                //$('#modal_form').modal('hide');
				//location.reload();
				console.log(data);
				//alert('Anda berhasil mengubah profil');
				//window.location.replace("<?php echo site_url('home/login');?>");
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            //alert('Error adding / update data');
			console.log( "Request failed: " +textStatus+ " " +errorThrown );
            $('#btnSave').text('Menyimpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}
</script>

<div class="container">
	<div class="row row-centered">
        <div class="col-md-8 col-centered">
            <form action="#" id="form_register" role="form">
            <fieldset><legend class="text-center">Ubah Profil dan Password</legend>
			
			<div class="form-group">
                <label for="email"><span class="req">* </span> Email: </label> 
                    <input class="form-control" required type="text" name="Email" id="Email" value="<?php echo $user->email; ?>" placeholder="Masukkan email"/>   
                    <span class="help-block"></span>
            </div>
			
            <div class="form-group">
                <label for="username"><span class="req">* </span> Username: </label> 
                    <input class="form-control" type="text" name="Username" id="Username" value="<?php echo $user	->username; ?>" placeholder="Masukkan username minimal 6 karakter" required />  
                    <span class="help-block"></span>
            </div>
			
			
			<div class="form-group">
				<label class="control-label"><input type="checkbox" id="checkbox" onchange="ubah_password()"> Ubah Password</label>
			</div>
			<!-- onchange="ubah_password()"-->
			
			
			<div id="ubah_password">
				<input type="hidden" type="text" name="Password_Lama" id="Password_Lama" value="<?php echo $user->password;?>"/>
				<input type="hidden" type="text" name="Password_1" id="Password_1" value="<?php echo $user->password;?>"/>
				<input type="hidden" type="text" name="Password_2" id="Password_2" value="<?php echo $user->password;?>"/>
			</div>

            <div class="form-group">
                <!--<input class="btn btn-success" type="submit" name="submit_reg" value="Register">-->
				<button type="button" id="btnSave" onclick="change_profile()" class="btn btn-success">Ubah Profil</button>
            </div>

            </fieldset>
            </form><!-- ends register form -->

        </div><!-- ends col-6 -->


	</div>
</div>
	
	
	<!-- jQuery Server-->
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->
	
	
</body>

</html>


