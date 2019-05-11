<?php $this->load->view('include/home-header');?>
<?php $this->load->view('include/home-navbar');?>


	<?php 
		$id_member = $this->session->userdata('id_member');
		$email= $this->session->userdata('email');
		$pass = $this->session->userdata('password');
		$nama = $this->session->userdata('nama');
		$kecamatan = $this->session->userdata('kecamatan');
	?>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<style>
	.form-inline .form-group { margin-right:10px; }
	.well-primary {
	color: rgb(255, 255, 255);
	background-color: rgb(66, 139, 202);
	border-color: rgb(53, 126, 189);
	}
	.glyphicon { margin-right:5px; }
	.btn-file {
    position: relative;
    overflow: hidden;
	}
	.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
	}
	</style>
	
	<div class="row">
		<div class="col-lg-12">
		  <ul class="breadcrumb">
			<li><a href="<?php echo site_url('home/index');?>"><span class="glyphicon glyphicon-home"></a></li>
			<li class="active"><a href="">Order Transaction</a></li>
		  </ul>
		</div>
	</div><!-- breadcrumb row end //-->

	<br/>
	
	<div class="container">
		<!-- Page Features -->
        <div class="row col-lg-12">
			
			<?php if(!empty($master)){?>
            <div class="panel-group" id="accordion">
				<?php
					$no = 1;
					foreach($master as $hasil){
						
					$arr = explode('-', $hasil->tanggal);
					$tahun = $arr[0];
					$bulan = $arr[1];
					$tanggal = $arr[2];
					
					switch ($bulan) {
					   case 1: 
							$bulan = 'Januari';
							break;
					   case 2:
							$bulan = 'Februari';
							break;
					   case 3:
							$bulan = 'Maret';
							break;
					   case 4:
							$bulan = 'April';
							break;
					   case 5:
							$bulan = 'Mei';
							break;
						case 6:
							$bulan = 'Juni';
							break;
						case 7:
							$bulan = 'Juli';
							break;
						case 8:
							$bulan = 'Agustus';
							break;
						case 9:
							$bulan = 'September';
							break;
						case 10:
							$bulan = 'Oktober';
							break;
						case 11:
							$bulan = 'November';
							break;
						case 12:
							$bulan = 'Desember';
							break;
					}
				?>
                <div style="margin-bottom:20px;" class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
							<input type="hidden" value="<?php echo $hasil->nomor_order; ?>" id="nomor_order<?php echo $no; ?>"/>
                            <p><h4><strong><?php echo $hasil->nomor_order; ?></strong></h4></p>
                            <p>Tanggal Transaksi: <?php echo $tanggal.' '.$bulan.' '.$tahun; ?>  | Total: Rp <?php echo number_format($hasil->grand_total, 0, '.', '.') ?></p>
                            <p>Status Transaksi: <span class="badge badge-info">
							<?php 
							if($hasil->status == 'ORDER'){
								if($hasil->bukti_pembayaran == NULL){
									echo 'Menunggu Konfirmasi Pembayaran'; 
								}else{
									echo 'Menunggu Konfirmasi Operator';
								}
							}else if($hasil->status == 'APPROVE'){
								echo 'Pesanan telah disetujui dan diteruskan ke pengiriman';
							}else{
								echo 'Pesanan telah dikirim';
							}
							?></span></p>
							<p>Jenis Pengiriman : JNE - Reguler</p>
                            <p>Nomor Resi : 01101212054017</p>
                            <button class="btn btn-md btn-info" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $no; ?>" onclick="daftar_rincian('<?php echo $hasil->nomor_order; ?>', 'detail<?php echo $no; ?>')"><span class="panel-title expand">
                            </span>Klik Rincian</button>
							<?php 
							if($hasil->status == 'ORDER'){
								if($hasil->bukti_pembayaran == NULL){ ?>
									<button class="btn btn-md btn-success" onclick="add_file_upload('<?php echo $hasil->nomor_order; ?>')">Upload Bukti Pembayaran</button>
							<?php }}else if($hasil->status == 'SEND'){ ?>
								<button class="btn btn-md btn-success" onclick="accept_order('<?php echo $hasil->nomor_order; ?>')">Barang telah diterima</button>
							<?php } ?>
                        </h4>
                    </div>
					
					
                    <div id="collapse<?php echo $no; ?>" class="panel-collapse collapse">
                        <div class="panel-body">
							<fieldset style="margin-bottom:15px;">
								<table style="width:98%">
									<tr>
										<td width="80%">
											<p><strong>Alamat Tujuan</strong></p>
											<p><?php echo $hasil->nama_lengkap; ?></p>
											<p><?php echo $hasil->alamat; ?></p>
											<p><?php echo $hasil->nama_kecamatan; ?>, <?php echo $hasil->nama_kota_kab; ?></p>
											<p><?php echo $hasil->nama_provinsi; ?></p>
											<p>Telp: <?php echo $hasil->no_kontak; ?></p>
										</td width="20%">
										<td>
											<p><strong>Jumlah Produk</strong></p>
											<p><?php echo $hasil->total_kuantitas; ?> Item</p>
											<p><strong>Berat Keseluruhan</strong></p>
											<p><?php echo ceil($hasil->total_berat); ?> Kg</p>
											<p><strong>Ongkos Kirim</strong></p>
											<p>Rp. <?php echo number_format($hasil->ongkir, 0, '.', '.') ?></p>
										</td>
									</tr>
								</table>
							</fieldset>
						
                            <fieldset style="margin-bottom:15px;">
								<table id="detail<?php echo $no; ?>" class="table table-hover table-condensed" style="width:96%">
								</table>
							</fieldset>
							
							<fieldset>
								<table style="width:98%">
									<tr>
										<td width="80%">
											<p><strong>Total Pembayaran</strong></p>
										</td width="20%">
										<td>
											<p><strong>Rp. <?php echo number_format($hasil->grand_total, 0, '.', '.') ?></strong></p>
										</td>
									</tr>
								</table>
							</fieldset>
                            
                        </div>
                    </div>
                </div>
				<?php $no++;} ?>
				
				<!--
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <p>INV/20170225/XVII/II/71329123</p>
                            <p>Tanggal Transaksi: 25 Februari 2017  | Total: Rp 14.800</p>
                            <p>03 Maret 2017, 05:34 WIB - Transaksi selesai</p>
                            <p>Nomor Resi : 01101212054017</p>
                            <button class="btn btn-sm btn-info" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="panel-title expand">
                            </span>Klik Rincian</button>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <h3>Panel2</h3>
                            
                        </div>
                    </div>
                </div>
				-->
            </div>
			<?php }else{ ?>
				Belum ada transaksi
			<?php } ?>
        </div>
        <!-- /.row -->
	</div>
	
	
	<!-- Bootstrap modal -->
	<div class="modal fade" id="modal_form" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Form Merek</h3>
				</div>
				<div class="modal-body form">
					<form action="#" id="form" class="form-horizontal">
						<input type="hidden" value="" name="nomor" id="nomor"/> 
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">Pilih Bank</label>
								<div class="col-md-9">
									<?php 
										echo form_dropdown("id_Bank", $option_bank, '' ,'id="id_Bank" class="form-control" name="id_Bank"'); //name(string), option value(array), selected(array), extra(mixed)  --selectednya dikosongkan
									?>
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">No. Rekening</label>
								<div class="col-md-9">
									<input name="no_Rekening" placeholder="Masukkan Nomor Rekening" class="form-control" type="text">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">Bukti Pembayaran</label>
								<div class="col-md-9">
									<input name="bukti_bayar" type="file">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- End Bootstrap modal -->
	
	<script type="text/javascript">
	
	function daftar_rincian(no_order, id_tabel)
	{
		//alert(no_order);
		//alert(id_panel);
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('home/order_detail');?>",
			data: { 
				nomor_order : no_order
			},
			cache: false,
			dataType: "JSON",
			success: function(data){
				//console.log(data.detail);
				
				$('#'+id_tabel+'').empty();
				$('#'+id_tabel+'').append('<thead><tr><th><strong>Daftar Pembelian Produk</strong></th></tr> <tr><th style="width:50%">Product</th> <th style="width:15%">Price</th> <th style="width:15%" class="text-center">Quantity</th> <th style="width:20%" class="text-center">Subtotal</th> </tr> </thead>');
				
				$('#'+id_tabel+'').append('<tbody>');
				
				jQuery.each(data['detail'], function(obj, values) {
				
				//console.log(obj, values);
				//console.log(data['detail'][obj]);
				
				$('#'+id_tabel+'').append('<tr> <td data-th="Product"><div class="row"><div class="col-sm-3 hidden-xs"><img src="<?php echo base_url('upload/foto_produk');?>/'+data['detail'][obj].foto_1+'" alt="" class="img-responsive"></div><div class="col-sm-8"><h4 class="nomargin">'+data['detail'][obj].nama_produk+'</h4><h5 class="media-heading"> Merek : Remedi</h5></div></div></td> <td data-th="Price">'+to_rupiah(data['detail'][obj].harga)+'</td> <td data-th="Quantity" style="text-align:center;">'+data['detail'][obj].kuantitas+'</td> <td data-th="Subtotal" class="text-center">'+to_rupiah(data['detail'][obj].jumlah_harga)+'</td> </tr>');
				
				});		
				
				$('#'+id_tabel+'').append('</tbody>');
			}
		});
	}
	
	
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


function accept_order(nomor)
{
	//alert(nomor);

    $.ajax({
        url : "<?php echo site_url('home/acceptance_confirmation')?>",
        type: "POST",
        data: { 
			nomor_order : nomor
		},
        cache: false,
        dataType: "JSON",
        success: function(data)
        {
			console.log(data);
            alert('Terima kasih konfirmasinya, silahkan berbelanja kembali :)');
			location.reload();

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
}

function save()
{
	$('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
	
    $('#btnSave').text('Menyimpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 

    // ajax adding data to database
    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : "<?php echo site_url('home/add_order_confirmation')?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
				//console.log(data);
                $('#modal_form').modal('hide');
                alert('Berhasil upload bukti pembayaran');
				location.reload();

            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Menyimpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Menyimpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function add_file_upload(nomor)
{
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text(nomor); // Set Title to Bootstrap modal title
	$('#nomor').val(nomor);
}


</script>

<?php $this->load->view('include/home-footer');?>
