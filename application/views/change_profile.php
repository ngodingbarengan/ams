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
			<li class="active"><a href="">Change Profil and Password</a></li>
		  </ul>
		</div>
	</div><!-- breadcrumb row end //-->

	<br/>
	
		<!-- Page Features -->
        <div class="row text-center">
			
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
				alert('Anda berhasil mengubah profil');
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
            <fieldset>
			
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
			
			<br/>
        </div><!-- ends col-6 -->


	</div>
</div>
		
        </div>
        <!-- /.row -->

<?php $this->load->view('include/home-footer');?>
