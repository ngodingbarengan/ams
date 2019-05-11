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
            <fieldset><legend class="text-center">Ubah Alamat</legend>
			
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
                <!--<input class="btn btn-success" type="submit" name="submit_reg" value="Register">-->
				<button type="button" id="btnSave" onclick="save_register()" class="btn btn-success">Ubah Data</button>
            </div>
                      
            </fieldset>
            </form><!-- ends register form -->

        </div><!-- ends col-6 -->


	</div>
</div>


    <!-- jQuery -->
    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js');?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
	
	
	<!-- jQuery Server-->
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->
	
	
</body>

</html>


