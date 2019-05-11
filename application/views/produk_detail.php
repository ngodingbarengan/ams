<?php $this->load->view('include/home-header');?>
<?php $this->load->view('include/home-navbar');?>

	<?php 
		$id_member = $this->session->userdata('id_member');
		$email= $this->session->userdata('email_member');
		$pass = $this->session->userdata('password_member');
		$nama = $this->session->userdata('nama_member');
		$kecamatan = $this->session->userdata('kecamatan_member');
	?>

	  <div class="row">
		<div class="col-lg-12">
		  <ul class="breadcrumb">
			<li><a href="<?php echo site_url('home/index');?>"><span class="glyphicon glyphicon-home"></a></li>
			<li><a href="<?php echo site_url("home/category/".$produk->id_kategori."");?>"><?php echo $produk->nama_kategori; ?></a></li>
			<li class="active"><a href=""><?php echo $produk->nama_produk; ?></a></li>
		  </ul>
		</div>
	  </div><!-- breadcrumb row end //-->
	
	<div class="row">
		<div class="col-md-8">
			<!-- <img class="img-responsive" src="images/sample_image_1.jpg" alt=""> -->
			
			<div id="my_thumb_slider">
				<div class="slides">
					<?php if(!empty($produk->foto_1)){ ?>
						<div class="slide">
						<img src="<?php echo base_url('upload/foto_produk').'/'.$produk->foto_1; ?>" alt="" style="height:500px; width:auto;"/>
						</div>
					<?php }?>
					<?php if(!empty($produk->foto_2)){ ?>
						<div class="slide">
						<img src="<?php echo base_url('upload/foto_produk').'/'.$produk->foto_2; ?>" alt="" style="height:500px; width:auto;"/>
						</div>
					<?php }?>
					<?php if(!empty($produk->foto_3)){ ?>
						<div class="slide">
						<img src="<?php echo base_url('upload/foto_produk').'/'.$produk->foto_3; ?>" alt="" style="height:500px; width:auto;"/>
						</div>
					<?php }?>
					<?php if(!empty($produk->foto_4)){ ?>
						<div class="slide">
						<img src="<?php echo base_url('upload/foto_produk').'/'.$produk->foto_4; ?>" alt="" style="height:500px; width:auto;"/>
						</div>
					<?php }?>
					<?php if(!empty($produk->foto_5)){ ?>
						<div class="slide">
						<img src="<?php echo base_url('upload/foto_produk').'/'.$produk->foto_5; ?>" alt="" style="height:500px; width:auto;"/>
						</div>
					<?php }?>
				</div>
				
				<div class="controls">
					<?php if(!empty($produk->foto_1)){ ?>
						<span class="control">
							<img src="<?php echo base_url('upload/foto_produk').'/'.$produk->foto_1; ?>" alt="" class="img-thumbnail"/>
							<span></span>
						</span>
					<?php }?>
					<?php if(!empty($produk->foto_2)){ ?>
						<span class="control">
							<img src="<?php echo base_url('upload/foto_produk').'/'.$produk->foto_2; ?>" alt="" class="img-thumbnail"/>
							<span>   </span>
						</span>
					<?php }?>
					<?php if(!empty($produk->foto_3)){ ?>
						<span class="control">
							<img src="<?php echo base_url('upload/foto_produk').'/'.$produk->foto_3; ?>" alt="" class="img-thumbnail"/>
							<span>   </span>
						</span>
					<?php }?>
					<?php if(!empty($produk->foto_4)){ ?>
						<span class="control">
							<img src="<?php echo base_url('upload/foto_produk').'/'.$produk->foto_4; ?>" alt="" class="img-thumbnail"/>
							<span>   </span>
						</span>
					<?php }?>
					<?php if(!empty($produk->foto_5)){ ?>
						<span class="control">
							<img src="<?php echo base_url('upload/foto_produk').'/'.$produk->foto_5; ?>" alt="" class="img-thumbnail"/>
							<span>   </span>
						</span>
					<?php }?>
				</div>
			</div>
								
				<!--<h4><a href="#">Product Name</a></h4>-->
				<br/>
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#home">Deskripsi Produk</a></li>
					<!--
					<li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
					<li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
					<li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
					-->
				</ul>

				<div class="tab-content">
					<div id="home" class="tab-pane fade in active">
					  <h3><?php echo $produk->nama_produk; ?></h3>
					  <?php if($produk->deskripsi == "") { ?>
						<p>Tidak ada deskripsi produk</p>
					  
					  <?php }else{ ?>
					  <p><?php echo $produk->deskripsi; ?></p>
					  <?php } ?>
					</div>
					<!--
					<div id="menu1" class="tab-pane fade">
					  <h3>Menu 1</h3>
					  <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
					</div>
					<div id="menu2" class="tab-pane fade">
					  <h3>Menu 2</h3>
					  <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
					</div>
					<div id="menu3" class="tab-pane fade">
					  <h3>Menu 3</h3>
					  <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
					</div>
					-->
				</div>
		</div>
		
			<div class="col-sm-4">
				<div class="caption">
					<?php $attributes = array('id' => 'myform'); ?>
					<?php echo form_open('home/add_cart_item', $attributes); ?>
						<?php echo form_hidden('id_produk', $produk->id_produk); ?>
						<?php echo form_hidden('kd_produk', $produk->kd_produk); ?>
						<?php echo form_hidden('berat', $produk->berat); ?>
						<?php echo form_hidden('foto', $produk->foto_1); ?>
						<h2><?php echo '<h2 class="text-primary">'.$produk->nama_produk.'<h2>'; ?></h2>
						<?php echo form_hidden('nama', $produk->nama_produk); ?>
						<hr/>
						<p>Merek : <?php echo $produk->nama_merek; ?></p>
						<p>Satuan : <?php echo $produk->nama_satuan; ?></p>
						<p>Berat : <?php echo $produk->berat; ?> Kg</p>
						<p>Ketersediaan barang: <?php echo $produk->stok-$jumlah_order; ?></p>
							<br/>
						<p>Garansi : 1 Tahun</p>
							<br/>
						<p>Izin Edar Kementrian Kesehatan RI Nomor : <br>AKL-20403511095</p>
							<br/>
						<p>Harga belum termasuk ongkos kirim</p>
						<p><?php echo '<h4 class="text-danger"><strong>Rp. '.number_format($produk->harga, 0, '.', '.').'</h4>'; ?></p>
						<?php echo form_hidden('harga', $produk->harga); ?>
						<p>Qty</p>
						
						<div class="row text-center">
							<p><input name="jumlah" id="jumlah" type="number" class="form-control text-left" value="1"style="width:100%" onchange="validasi()"></p>
							<p>
								<?php if(!empty($id_member)){ ?>
									<button type="submit" class="btn btn-info btn-lg btn-block"><span class="glyphicon glyphicon-shopping-cart"></span> Beli</button>
								<?php }else{ ?>
									<button type="button" class="btn btn-info btn-lg btn-block" onclick="location.href='<?php echo site_url('login_member');?>'"><span class="glyphicon glyphicon-shopping-cart"></span> Beli</button>
								<?php } ?>
							</button>
							</p>
						</div>
					<?php echo form_close(); ?>
				</div>	
			</div>
		</div>

		<div class="row text-center">
				<hr>
				<div class="col-lg-12 text-left">
						<h3>Produk Sejenis</h3>
						<br/>
				</div>
				<!-- /.row -->

				<!-- Page Features -->

				<?php foreach ($produk_sejenis as $hasilnya){
						$harga_rupiah = number_format($hasilnya->harga, 0, '.', '.'); ?>
					
							<div class="col-md-3 col-sm-6 hero-feature">
								<div class="thumbnail">
									<img src="<?php echo base_url('upload/foto_produk/'.$hasilnya->foto_1); ?>" alt="" class="img-responsive" style="height:230px;">
									<div class="caption">
										<h3 class="text-primary"><?php echo substr($hasilnya->nama_produk,0,13).'...';?></h3>
										<p>
										<h4 class="text-danger"><strong>Rp. <?php echo $harga_rupiah; ?></strong></h4>					
											<div class="btn-group btn-group-md">
												<button type="button" class="btn btn-info" onclick="location.href='<?php echo site_url('home/produk_detail').'/'.$hasilnya->id_produk; ?>'"><span class="glyphicon glyphicon-shopping-cart"></span> Beli</button>
												
												<?php 
												if(!empty($id_member)){
													if($hasilnya->id_favorit == NULL) { ?>
														<button type="button" id="favorit" class="btn btn-info" onclick="add_data(<?php echo $hasilnya->id_produk; ?>)"><span class="glyphicon glyphicon-heart"></span> Favorit</button>
														
													<?php } else{  ?>
														<button type="button" id="delete" class="btn btn-danger" onclick="delete_data(<?php echo $hasilnya->id_favorit; ?>)"><span class="glyphicon glyphicon-trash"></span> Hapus</button>
													<?php }
												}else{ ?>
													<button type="button" class="btn btn-info" onclick="location.href='<?php echo site_url('login_member');?>'"><span class="glyphicon glyphicon-heart"></span> Favorit</button>
												<?php }	?>
												
											</div>
										</p>
									</div>
								</div>
							</div>

						<?php } ?>
		</div>
        <!-- /.row -->
		
		<script>
		$("#jumlah").keypress(function( event ){
			var key = event.which;
			
			if( ! ( key >= 48 && key <= 57 ) )
				event.preventDefault();
		});
		
		function validasi(){
			$stok = parseInt(<?php echo $produk->stok; ?>);
			$jumlah_order = parseInt(<?php echo $jumlah_order ?>);
			$order = parseInt($("#jumlah").val());
			$jumlah = $stok-$jumlah_order-$order;
			
			if( $order < 1 ){
				alert('Jumlah pemesanan minimal 1');
				$("#jumlah").val(1);
			}
			
			if( $jumlah < 0 ){
				//alert($jumlah_order);
				//alert($jumlah);
				alert('Stok tidak mencukupi');
				$("#jumlah").val(1);
			}
		}
		
		</script>
	
<?php $this->load->view('include/home-footer');?>
