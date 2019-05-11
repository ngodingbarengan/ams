<?php $this->load->view('include/home-header');?>
<?php $this->load->view('include/home-navbar');?>
<?php $id_member_login = $this->session->userdata('id_member'); ?>
        <!-- Jumbotron Header 
        <header class="jumbotron">
            <h1>A Warm Welcome!</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris egestas laoreet neque ut pulvinar. Mauris non varius odio. Pellentesque et tellus lectus. Curabitur ullamcorper, diam ut molestie semper, risus dolor consectetur mi, tristique vulputate sem augue id felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce vel sollicitudin dui. Vestibulum ac sagittis dolor, non lacinia odio. Integer semper orci erat, ac venenatis augue faucibus sit amet. Donec diam nulla, dapibus non faucibus in, bibendum nec dui. Fusce sollicitudin iaculis sapien id condimentum. Fusce massa risus, sodales vitae mi nec, feugiat volutpat ligula.
            </p>
        </header>
		
		<div class="thumbnail">
			<img src="<?php echo base_url('upload/foto_produk/foto_index.png');?>" alt="Sumber Terpercaya" class="img-responsive">
		</div>	
		-->
		
        <!-- Title -->
        <div class="row text-center">
            <div class="col-lg-12">

				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#terbaru">Produk Terbaru</a></li>
					<!--
					<li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
					<li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
					<li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
					-->
				</ul>
				
				<div class="tab-content">
					<div id="terbaru" class="tab-pane fade in active" style="padding-top:40px;">
					
						<?php 
						if(!empty($produk)){
						foreach ($produk as $hasilnya){
						$harga_rupiah = number_format($hasilnya->harga, 0, '.', '.'); ?>
					
							<div class="col-md-2 hero-feature">
								<div class="thumbnail">
									<img src="<?php echo base_url('upload/foto_produk/'.$hasilnya->foto_1); ?>" alt="" class="img-responsive" style="height:150px; width:auto;">
									<div class="caption">
										<p class="text-primary"><?php echo substr($hasilnya->nama_produk,0,13).'...';?></p>
										<p>
										<p class="text-danger"><strong>Rp. <?php echo $harga_rupiah; ?></strong></p>					
											<div class="btn-group btn-group-md">
												<button type="button" onclick='location.href="<?php echo site_url('home/produk_detail').'/'.$hasilnya->id_produk; ?>"' class="btn btn-info"><span class="glyphicon glyphicon-shopping-cart"></span></button>
												
												<?php
												//echo $id_member_login;
												if(!empty($id_member_login)){
													if(!empty($hasilnya->id_member)){
														if($hasilnya->id_member == $id_member_login){ ?>
															<button type="button" id="delete" class="btn btn-danger" onclick="delete_data(<?php echo $hasilnya->id_favorit; ?>)"><span class="glyphicon glyphicon-trash"></span></button>
														<?php }else{ ?>
															<button type="button" id="favorit" class="btn btn-info" onclick="add_data(<?php echo $hasilnya->id_produk; ?>)"><span class="glyphicon glyphicon-heart"></span></button>
														<?php } ?>
													<?php }else{ ?>
														<button type="button" id="favorit" class="btn btn-info" onclick="add_data(<?php echo $hasilnya->id_produk; ?>)"><span class="glyphicon glyphicon-heart"></span></button>
													<?php } ?>
													<?php }else{?>
													<button type="button" onclick='location.href="<?php echo site_url('home/login');?>"' class="btn btn-info"><span class="glyphicon glyphicon-heart"></span></button>
												<?php } ?>
											</div>
										</p>
									</div>
								</div>
							</div>

						<?php }
						}else{ ?>
							<p class="text-left" style="padding-left:20px">Tidak ada produk</p>
						<?php } ?>
						
						<!-- Paging -->
						<?php echo $pagination; ?>
					</div>
				</div>
				
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#terbaru">Best Seller</a></li>
					<!--
					<li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
					<li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
					<li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
					-->
				</ul>
				
				<div class="tab-content">
					<div id="terbaru" class="tab-pane fade in active" style="padding-top:40px;">
					
						<?php 
						if(!empty($produk)){
						foreach ($produk as $hasilnya){
						$harga_rupiah = number_format($hasilnya->harga, 0, '.', '.'); ?>
					
							<div class="col-md-4 hero-feature">
								<div class="thumbnail">
									<div class="col-md-5">
										<img src="<?php echo base_url('upload/foto_produk/'.$hasilnya->foto_1); ?>" alt="" class="img-responsive" style="height:120px; width:auto;">
									</div>
									<div class="caption">
										<p class="text-primary"><?php echo substr($hasilnya->nama_produk,0,13).'...';?></p>
										<p>
										<p class="text-danger"><strong>Rp. <?php echo $harga_rupiah; ?></strong></p>					
											<div class="btn-group btn-group-md">
												<button type="button" onclick='location.href="<?php echo site_url('home/produk_detail').'/'.$hasilnya->id_produk; ?>"' class="btn btn-info"><span class="glyphicon glyphicon-shopping-cart"></span></button>
												
												<?php
												//echo $id_member_login;
												if(!empty($id_member_login)){
													if(!empty($hasilnya->id_member)){
														if($hasilnya->id_member == $id_member_login){ ?>
															<button type="button" id="delete" class="btn btn-danger" onclick="delete_data(<?php echo $hasilnya->id_favorit; ?>)"><span class="glyphicon glyphicon-trash"></span></button>
														<?php }else{ ?>
															<button type="button" id="favorit" class="btn btn-info" onclick="add_data(<?php echo $hasilnya->id_produk; ?>)"><span class="glyphicon glyphicon-heart"></span></button>
														<?php } ?>
													<?php }else{ ?>
														<button type="button" id="favorit" class="btn btn-info" onclick="add_data(<?php echo $hasilnya->id_produk; ?>)"><span class="glyphicon glyphicon-heart"></span></button>
													<?php } ?>
													<?php }else{?>
													<button type="button" onclick='location.href="<?php echo site_url('home/login');?>"' class="btn btn-info"><span class="glyphicon glyphicon-heart"></span></button>
												<?php } ?>
											</div>
										</p>
									</div>
								</div>
							</div>

						<?php }
						}else{ ?>
							<p class="text-left" style="padding-left:20px">Tidak ada produk</p>
						<?php } ?>
						
						<!-- Paging -->
						<?php echo $pagination; ?>
					</div>
				
			</div>
		
		
        </div>	


<?php $this->load->view('include/home-footer');?>