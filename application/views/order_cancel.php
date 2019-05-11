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
			<li class="active"><a href="">Order Cancelled</a></li>
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
                            <p>Status Transaksi: <span class="badge badge-info">Pesanan dibatalkan</span></p>
							<!--<p>Jenis Pengiriman : JNE - Reguler</p>
                            <p>Nomor Resi : 01101212054017</p>-->
                            <button class="btn btn-md btn-info" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $no; ?>" onclick="daftar_rincian('<?php echo $hasil->nomor_order; ?>', 'detail<?php echo $no; ?>')"><span class="panel-title expand">
                            </span>Klik Rincian</button>
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
				Tidak ada transaksi yang dibatalkan
			<?php } ?>
        </div>
        <!-- /.row -->
	</div>
	
	
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

</script>

<?php $this->load->view('include/home-footer');?>
