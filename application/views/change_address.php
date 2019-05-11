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
			<li class="active"><a href="">Change Address</a></li>
		  </ul>
		</div>
	</div><!-- breadcrumb row end //-->

	<br/>
	
		<!-- Page Features -->
        <div class="row text-center">
			
<script>

$(document).ready(function() {
	$('#id_Provinsi').val(<?php echo $member->id_provinsi;?>);
	$('#id_KotaKab').val(<?php echo $member->id_kota_kab;?>);
	$('#id_Kecamatan').val(<?php echo $member->id_kecamatan;?>);
	
	//Ajax Load data kota/kab from ajax
	$.ajax({
		url 	: "<?php echo site_url('home/list_kota')?>/"+<?php echo $member->id_provinsi;?>,
		type	: "POST",
		dataType: "JSON",
		data	: <?php echo $member->id_provinsi;?>,
		success: function(data)
		{
			$('[name="id_KotaKab"]').empty();
			$('[name="id_KotaKab"]').append('<option value="0">-Pilih Kota-</option>');
			
			$.each(data, function(i, item){
				$('[name="id_KotaKab"]').append('<option value="'+ data[i].id_kota_kab +'">'+ data[i].nama_kota_kab +'</option>');
			});
			
			$('[name="id_KotaKab"]').val(<?php echo $member->id_kota_kab;?>);

			
			$('[name="id_KotaKab"]').on('change', function() {
			//alert( this.value );
			var selectKotaKab = this.value;
			
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
				}
			})
			
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Error get data from ajax');
		}
	});
	
	//Ajax Load data kecamatan from ajax
	$.ajax({
		url 	: "<?php echo site_url('home/list_kecamatan')?>/"+<?php echo $member->id_kota_kab;?>,
		type	: "POST",
		dataType: "JSON",
		data	: <?php echo $member->id_kota_kab;?>,
		success: function(data)
		{	
			$('[name="id_Kecamatan"]').empty();
			$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kecamatan-</option>');
			
			$.each(data, function(i, item){
				$('[name="id_Kecamatan"]').append('<option value="'+ data[i].id_kecamatan +'">'+ data[i].nama_kecamatan +'</option>');
			});
			
			$('[name="id_Kecamatan"]').val(<?php echo $member->id_kecamatan;?>);	
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Error get data from ajax');
		}
	});

});

function selected(){
	var selectProvinsi = $("#id_Provinsi").val();
	    		
	if (selectProvinsi > 0){
					
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

function change_address()
{
	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	
	// ajax adding data to database
    var formData = new FormData($("#form_register")[0]);
	//var formData = $('#form_item').serialize();
	console.log(formData);
    $.ajax({
        url : "<?php echo site_url('home/update_address');?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
				//location.reload();
				console.log(data);
				alert('Anda berhasil mengubah alamat');
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
            <label for="firstname"><span class="req">* </span> Nama Lengkap: </label>
                <input class="form-control" type="text" name="Nama_Lengkap" id="Nama_Lengkap" placeholder="Masukkan nama lengkap anda" value="<?php echo $member->nama_lengkap;?>" required /> 
                <span class="help-block"></span>   
            </div>
			
            <div class="form-group">
            <label for="phonenumber"><span class="req">* </span> Nomor Handphone: </label>
                <input required type="text" name="Phonenumber" id="Phonenumber" class="form-control phone" maxlength="15"  placeholder="Masukkan nomor handphone" value="<?php echo $member->no_kontak;?>"/>
				<span class="help-block"></span>				
            </div>
			
			<div class="form-group">
            <label for="phonenumber"><span class="req">* </span> Alamat: </label>
                <input required type="text" name="Alamat" id="Alamat" class="form-control phone" placeholder="Masukkan alamat" value="<?php echo $member->alamat;?>"/>
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
				<button type="button" id="btnSave" onclick="change_address()" class="btn btn-success">Ubah Data</button>
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
