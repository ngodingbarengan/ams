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
	</style>
	
	<div class="row">
		<div class="col-lg-12">
		  <ul class="breadcrumb">
			<li><a href="<?php echo site_url('home/index');?>"><span class="glyphicon glyphicon-home"></a></li>
			<li class="active"><a href="">Order History</a></li>
		  </ul>
		</div>
	</div><!-- breadcrumb row end //-->

	<br/>
	
	<div class="container">
		<!-- Page Features -->
        <div class="row col-lg-12">
			
            <div class="panel-group" id="accordion">
                <div style="margin-bottom:20px;" class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <p><h4><strong>INV/20170225/XVII/II/71329123</strong></h4></p>
                            <p>Tanggal Transaksi: 25 Februari 2017  | Total: Rp 14.800</p>
                            <p>Status Transaksi: <span class="badge badge-info">Transaksi selesai</span></p>
							<p>Jenis Pengiriman : JNE - Reguler</p>
                            <p>Nomor Resi : 01101212054017</p>
                            <button class="btn btn-sm btn-info" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="panel-title expand">
                            </span>Klik Rincian</button>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
							<fieldset style="margin-bottom:15px;">
								<table style="width:98%">
									<tr>
										<td width="80%">
											<p><strong>Alamat Tujuan</strong></p>
											<p>Heriyani</p>
											<p>Kp. Pulo Geulis RT. 003 RW. 004 No. 07 Kel. Babakan Pasar</p>
											<p>Bogor Tengah Kota Bogor, 16126</p>
											<p>Jawa Barat</p>
											<p>Telp: 081219652627</p>
										</td width="20%">
										<td>
											<p><strong>Jumlah Produk</strong></p>
											<p>9 Item</p>
											<p><strong>Berat Keseluruhan</strong></p>
											<p>2 Kg</p>
											<p><strong>Ongkos Kirim</strong></p>
											<p>Rp. 20.000</p>
										</td>
									</tr>
								</table>
							</fieldset>
						
                            <fieldset style="margin-bottom:15px;">
							<table id="cart" class="table table-hover table-condensed" style="width:96%">
											<thead>
											<tr><strong>Daftar Pembelian Produk</strong></tr>
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
							
							<fieldset>
								<table style="width:98%">
									<tr>
										<td width="80%">
											<p><strong>Total Pembayaran</strong></p>
										</td width="20%">
										<td>
											<p><strong>Rp. 20.000</strong></p>
										</td>
									</tr>
								</table>
							</fieldset>
                            
                        </div>
                    </div>
                </div>
				
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
            </div>
		
        </div>
        <!-- /.row -->
	</div>

<?php $this->load->view('include/home-footer');?>
