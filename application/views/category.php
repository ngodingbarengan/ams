<?php $this->load->view('include/home-header');?>
<?php $this->load->view('include/home-navbar');?>
<?php $id_member_login = $this->session->userdata('id_member'); ?>

	<div class="row">
		<div class="col-lg-12">
		  <ul class="breadcrumb">
			<li><a href="<?php echo site_url('home/index');?>"><span class="glyphicon glyphicon-home"></a></li>
			<li class="active"><a href="">
			<?php echo $nama_kategori->nama_kategori; ?></a></li>
		  </ul>
		</div>
	</div><!-- breadcrumb row end //-->

	<br/>
	
		<!-- Page Features -->
        <div class="row text-center">
			
            <?php 
			if(!empty($produk)){
			foreach ($produk as $hasilnya){
			$harga_rupiah = number_format($hasilnya->harga, 0, '.', '.'); ?>
		
				<div class="col-md-3 col-sm-6 hero-feature">
					<div class="thumbnail">
						<img src="<?php echo base_url('upload/foto_produk/'.$hasilnya->foto_1); ?>" alt="" class="img-responsive" style="height:230px; width:auto;">
						<div class="caption">
							<h3 class="text-primary"><?php echo substr($hasilnya->nama_produk,0,13).'...';?></h3>
							<p>
							<h4 class="text-danger"><strong>Rp. <?php echo $harga_rupiah; ?></strong></h4>					
								<div class="btn-group btn-group-md">
									<button type="button" onclick='location.href="<?php echo site_url('home/produk_detail').'/'.$hasilnya->id_produk; ?>"' class="btn btn-info"><span class="glyphicon glyphicon-shopping-cart"></span> Beli</button>
									
									<?php
									//echo $id_member_login;
									if(!empty($id_member_login)){
										if(!empty($hasilnya->id_member)){
											if($hasilnya->id_member == $id_member_login){ ?>
												<button type="button" id="delete" class="btn btn-danger" onclick="delete_data(<?php echo $hasilnya->id_favorit; ?>)"><span class="glyphicon glyphicon-trash"></span> Hapus</button>
											<?php }else{ ?>
												<button type="button" id="favorit" class="btn btn-info" onclick="add_data(<?php echo $hasilnya->id_produk; ?>)"><span class="glyphicon glyphicon-heart"></span> Favorit</button>
											<?php } ?>
										<?php }else{ ?>
											<button type="button" id="favorit" class="btn btn-info" onclick="add_data(<?php echo $hasilnya->id_produk; ?>)"><span class="glyphicon glyphicon-heart"></span> Favorit</button>
										<?php } ?>
										<?php }else{?>
										<button type="button" onclick='location.href="<?php echo site_url('home/login');?>"' class="btn btn-info"><span class="glyphicon glyphicon-heart"></span> Favorit</button>
									<?php } ?>
								</div>
							</p>
						</div>
					</div>
				</div>

			<?php }
			}else{ ?>
				<p>Belum ada produk dengan kategori ini</p>
			<?php } ?>
        </div>
        <!-- /.row -->
		
		<!-- Paging -->
        <div class="row text-center">
            <?php echo $pagination; ?>
        </div>
        <!-- /.row -->

<?php $this->load->view('include/home-footer');?>
