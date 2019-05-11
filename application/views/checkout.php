<?php $this->load->view('include/home-header');?>
<?php $this->load->view('include/home-navbar');?>


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

$(document.body).on('change','#id_Kecamatan',function(){
    //alert('Change Happened');
	//alert(this.value);
	
	if (this.value > 0){
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('home/get_ongkir')?>/" +this.value,
			dataType: "JSON",
			success: function(data)
			{	
				//alert('berhasil');						
				console.log(data);
				
				$biaya_kirim = parseInt(<?php echo ceil($this->my_cart->total_weight());?>)*parseInt(data.ongkir);
				$total = parseInt(<?php echo $this->my_cart->total();?>)+$biaya_kirim;
				
				$('#ongkir').empty();
				$('#ongkir').append('<h4><strong>'+to_rupiah($biaya_kirim)+'</strong></h4>');
				$('#ongkir_value').val($biaya_kirim);
				$('#total').empty();
				$('#total').append('<h3><strong>'+to_rupiah($total)+'</strong></h3>');
				$('#total_value').val($total);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error get data from ajax');
			}
		});
		}else{
			$('#ongkir').empty();
			$('#ongkir').append('<h4><strong>'+to_rupiah(0)+'</strong></h4>');
			$('#total').empty();
			$('#total').append('<h3><strong>'+to_rupiah(<?php echo $this->my_cart->total();?>)+'</strong></h3>');
		}
	
});

function to_rupiah(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('');
}


function save_CO()
{
	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	
	// ajax adding data to database
    var formData = new FormData($("#form_CO")[0]);
	//var formData = $('#form_item').serialize();
	console.log(formData);
    $.ajax({
        url : "<?php echo site_url('home/add_CO');?>",
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
				alert('Berhasil melakukan pembelian');
				window.location.replace("<?php echo site_url('home/order_history');?>");
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

	<div class="row">
		<div class="col-lg-12">
		  <ul class="breadcrumb">
			<li><a href="<?php echo site_url('home/index');?>"><span class="glyphicon glyphicon-home"></a></li>
			<li class="active"><a href="">Checkout</a></li>
		  </ul>
		</div>
		</div><!-- breadcrumb row end //-->
	
	<div  class="col-lg-12">
	
	<div class="row" style="padding-bottom:10px;">
	<fieldset>
	<table id="cart" class="table table-hover table-condensed" style="width:95%">
    				<thead>
						<tr><h3> Order List</h3></tr>
					<?php if(!empty($this->my_cart->contents())) { ?>
						<tr>
							<th style="width:50%">Product</th>
							<th style="width:15%">Price</th>
							<th style="width:15%" class="text-center">Quantity</th>
							<th style="width:20%" class="text-center">Subtotal</th>
						</tr>
					</thead>
					<tbody>
					<?php 
 
					$i = 1;
				 
					foreach ($this->my_cart->contents() as $items): ?>
					
					<?php echo form_hidden('id', $items['rowid']); ?>
						<tr>
							<td data-th="Product">
								<div class="row">
									<div class="col-sm-3 hidden-xs"><img src="<?php echo base_url('upload/foto_produk/'.$items['photo']); ?>" alt="" class="img-responsive"></div>
									<div class="col-sm-8">
										<h4 class="nomargin"><?php echo $items['name']; ?></h4>
										<h5 class="media-heading"> Merek : Remedi</h5>
										<h6 class="nomargin"><strong>Stok (4 tersedia)</strong></h6>
									</div>
								</div>
							</td>
							<td data-th="Price"><?php echo number_format($items['price'], 0, ',', '.'); ?></td>
							<td data-th="Quantity" style="text-align:center;"><?php echo $items['qty']; ?>
							</td>
							<td data-th="Subtotal" class="text-center">Rp. <?php echo number_format($items['subtotal'], 0, ',', '.'); ?></td>
						</tr>
						
						<?php $i++; ?>
					<?php endforeach; 
					} ?>
					</tbody>
				</table>
	</fieldset>
	<br/>
	</div>
	
	<div class="row" style="padding-bottom:10px;">
            <form action="#" id="form_CO" role="form">
			<input type="hidden" id="ongkir_value" name="ongkir_value" value="<?php echo ceil($this->my_cart->total_weight())*$ongkir; ?>"/>
			<input type="hidden" id="total_value" name="total_value" value="<?php echo $this->my_cart->total()+(ceil($this->my_cart->total_weight())*$ongkir); ?>"/>
            <fieldset>
			
			<div class="form-group"> 	 
				<legend style="width:95%;"><h3>Alamat Pengiriman</h3></legend>
			</div>
			
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
                      
            </fieldset>
            </form><!-- ends register form -->
		<br/>
	</div>
	
	
	<div class="row" style="padding-bottom:10px;">
		<fieldset>
            <form action="#" id="form_register" role="form">
			<table class="table table-condensed" style="width:95%">
					<thead>
						<tr><h3> Rincian Pembelian</h3></tr>
					</thead>
				<tbody>
						<tr>
							<td class="hidden-xs text-left"><h4><strong>Subtotal</strong></h4></td>
							<td class="hidden-xs text-right"><h4><strong>Rp. <?php echo number_format($this->my_cart->total(), 0, ',', '.'); ?></strong></h4></td>
						</tr>
						<tr>
							<td class="hidden-xs text-left"><h4><strong>Biaya Kirim (<?php echo ceil($this->my_cart->total_weight()); ?> Kg)</h4></strong></td>
							<td class="hidden-xs text-right" id="ongkir"><h4><strong>Rp. <?php echo number_format(ceil($this->my_cart->total_weight())*$ongkir, 0, '.', '.'); ?></strong></h4></td>
						</tr>
						<tr>
							<td class="hidden-xs text-left"><h3><strong>Total (sudah termasuk pajak)</strong></h3></td>
							<td class="hidden-xs text-right" id="total"><h3><strong>Rp. <?php echo number_format($this->my_cart->total()+(ceil($this->my_cart->total_weight())*$ongkir), 0, '.', '.'); ?></strong></h3></td>
						</tr>
						<tr>
							<td class="hidden-xs text-left" style="padding-top:15px;">
								<button type="button" class="btn btn-info" onclick="location.href='<?php echo site_url('home/shopping_cart');?>'">
									<span class="glyphicon glyphicon-chevron-left"></span> Change Order List
								</button>
							</td>
							<td class="hidden-xs text-right" style="padding-top:15px;">
							<button type="button" class="btn btn-success" onclick="save_CO()">Send Order
								<span class="glyphicon glyphicon-send"></span>
							</button>
							</td>
						</tr>
					</tbody>
				</table>
            </form><!-- ends register form -->
		</fieldset>
	</div>
</div>
	
<?php $this->load->view('include/home-footer');?>
