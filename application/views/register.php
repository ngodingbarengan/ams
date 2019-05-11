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
			<li class="active"><a href="">Register</a></li>
		  </ul>
		</div>
	</div><!-- breadcrumb row end //-->

	<br/>
	
		<!-- Page Features -->
        <div class="row text-center">
			
<script>

function selected(){
	var selectProvinsi = $("#id_Provinsi").val();
	    		
	if (selectProvinsi > 0){
					
	//console.log($("#id_Provinsi").val());
					
	$.ajax({
		type: "POST",
		url : "<?php echo site_url('home/list_kota')?>/" + selectProvinsi,
		data: selectProvinsi,
		dataType: "JSON",
		success: function(data)
		{	
			//alert('berhasil');						
			//console.log(data);
		
			$('[name="id_KotaKab"]').empty();
			$('[name="id_KotaKab"]').append('<option value="0">-Pilih Kota-</option>');
			$('[name="id_Kecamatan"]').empty();
			$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kecamatan-</option>');
			
			$.each(data, function(i, item){
				$('[name="id_KotaKab"]').append('<option value="'+ data[i].id_kota_kab +'">'+ data[i].nama_kota_kab +'</option>');
			});
			
			$('[name="id_KotaKab"]').on('change', function() {
			//alert( this.value );
			var selectKotaKab = this.value;
			//alert( selectKotaKab );
			
			if (selectKotaKab > 0){
				$.ajax({
					type: "POST",
					url : "<?php echo site_url('home/list_kecamatan')?>/" +selectKotaKab,
					//data: selectKotaKab,
					dataType: "JSON",
					success: function(data)
					{	
						//alert('berhasil');						
						//console.log(data); berhasil
						
						//$('[name="id_Kecamatan"]')
						
						$('[name="id_Kecamatan"]').empty();
						$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kecamatan-</option>');
						$.each(data, function(i, item){
							$('[name="id_Kecamatan"]').append('<option value="'+ data[i].id_kecamatan +'">'+ data[i].nama_kecamatan +'</option>');
												
						}); //*/
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert('Error get data from ajax');
					}
				});
				}else{
					$('[name="id_Kecamatan"]').empty();
					$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kota/Kabupaten Lebih Dahulu-</option>');
				} //*/
			})	
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Error get data from ajax');
		}
	});
	}else{
		$('[name="id_KotaKab"]').empty();
		$('[name="id_KotaKab"]').append('<option value="0">-Pilih Kota-</option>');
		$('[name="id_Kecamatan"]').empty();
		$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kecamatan-</option>');
	}
	
}


function save_register()
{
	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	
	// ajax adding data to database
    var formData = new FormData($("#form_register")[0]);
	//var formData = $('#form_item').serialize();
	console.log(formData);
    $.ajax({
        url : "<?php echo site_url('home/save_register');?>",
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
				alert('Anda berhasil melakukan registrasi');
				window.location.replace("<?php echo site_url('home/login');?>");
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
            <fieldset><legend class="text-center">Gunakanlah informasi yang valid untuk pendaftaran. <span class="req"><small> Harus diisi *</small></span></legend>
			
			<div class="form-group">
                <label for="email"><span class="req">* </span> Email: </label> 
                    <input class="form-control" required type="text" name="Email" id="Email" placeholder="Masukkan email"/>   
                    <span class="help-block"></span>
            </div>
			
            <div class="form-group">
                <label for="username"><span class="req">* </span> Username: </label> 
                    <input class="form-control" type="text" name="Username" id="Username" placeholder="Masukkan username minimal 6 karakter" required />  
                    <span class="help-block"></span>
            </div>

            <div class="form-group">
            <label for="password"><span class="req">* </span> Password: </label>
                <input required name="Password_1" type="password" class="form-control inputpass" minlength="4" maxlength="16"  placeholder="Masukkan password" id="Password_1" />
				<span class="help-block"></span>
			</div>
			
			<div class="form-group">
            <label for="password"><span class="req">* </span> Konfirmasi Password: </label>
                <input required name="Password_2" type="password" class="form-control inputpass" minlength="4" maxlength="16" placeholder="Masukkan kembali password"  id="Password_2"/>
                <span class="help-block"></span>
            </div>
			
			<legend class="text-center">Data digunakan untuk alamat pengiriman pesanan. <span class="req"><small> Harus diisi *</small></span></legend>
			
			<div class="form-group"> 	 
            <label for="firstname"><span class="req">* </span> Nama Lengkap: </label>
                <input class="form-control" type="text" name="Nama_Lengkap" id="Nama_Lengkap" placeholder="Masukkan nama lengkap anda" required /> 
                <span class="help-block"></span>   
            </div>
			
            <div class="form-group">
            <label for="phonenumber"><span class="req">* </span> Nomor Handphone: </label>
                <input required type="text" name="Phonenumber" id="Phonenumber" class="form-control phone" maxlength="15"  placeholder="Masukkan nomor handphone"/>
				<span class="help-block"></span>				
            </div>
			
			<div class="form-group">
            <label for="phonenumber"><span class="req">* </span> Alamat: </label>
                <input required type="text" name="Alamat" id="Alamat" class="form-control phone" placeholder="Masukkan alamat"/>
				<span class="help-block"></span>
            </div>
			
			<div class="form-group">
            <label for="provinsi"><span class="req">* </span>Pilih Provinsi</label>
				<?php 
					echo form_dropdown("id_Provinsi", $option_provinsi, '' ,'id="id_Provinsi" class="form-control" onchange="selected()"'); //name(string), option value(array), selected(array), extra(mixed)  --selectednya dikosongkan
				?>
				<span class="help-block"></span>
            </div>
			
			<div class="form-group">
            <label for="kota/kab"><span class="req">* </span>Pilih Kota/Kabupaten</label>
				<?php 
					echo form_dropdown("id_KotaKab", array(0 => '-Pilih Kota-'),'','id="id_KotaKab" class="form-control"');
				?>
				<span class="help-block"></span>
            </div>
			
			<div class="form-group">
            <label for="kecamatan"><span class="req">* </span>Pilih Kecamatan</label>
				<?php 
					echo form_dropdown("id_Kecamatan", array(0 => '-Pilih Kecamatan-'),'','id="id_Kecamatan" class="form-control"');
				?>
				<span class="help-block"></span>
            </div>

            <div class="form-group">
            
                <?php //$date_entered = date('m/d/Y H:i:s'); ?>
                <input type="hidden" value="<?php //echo $date_entered; ?>" name="dateregistered">
                <input type="hidden" value="0" name="activate" />
                <hr>

                <input type="checkbox" required name="terms" onchange="this.setCustomValidity(validity.valueMissing ? 'Please indicate that you accept the Terms and Conditions' : '');" id="field_terms">   <label for="terms">Saya setuju dengan semua <a href="<?php echo site_url('home/terms');?>" title="You may read our terms and conditions by clicking on this link">syarat dan ketentuan</a> registrasi.</label><span class="req">* </span>
            </div>

            <div class="form-group">
                <!--<input class="btn btn-success" type="submit" name="submit_reg" value="Register">-->
				<button type="button" id="btnSave" onclick="save_register()" class="btn btn-success">Registrasi</button>
            </div>
				<!--
                    <h5>You will receive an email to complete the registration and validation process. </h5>
                    <h5>Be sure to check your spam folders. </h5>
				-->

            </fieldset>
            </form><!-- ends register form -->
			
			<br/>
        </div><!-- ends col-6 -->


	</div>
</div>
		
        </div>
        <!-- /.row -->

<?php $this->load->view('include/home-footer');?>
