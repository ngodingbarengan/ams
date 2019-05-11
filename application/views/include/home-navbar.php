<?php
	$id_member = $this->session->userdata('id_member');
	$nama = $this->session->userdata('nama_member');
?>

<body>
	
    <!-- Navigation -->
	
	<nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo site_url('home/index');?>">PT. Anugrah Mitra Selaras</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<form id="form_search" action="<?php echo site_url('home/search');?>" class="navbar-form navbar-left" method="post">
					  <div class="input-group">
						<input type="text" class="form-control" placeholder="Search Product" name="search_text" id="search_text">
						<div class="input-group-btn">
						<!--
						<button class="btn btn-default" type="button" onclick="location.href='<?php echo site_url('home/search');?>'">
						//or
						<button class="btn btn-default" type="button" onclick="search()">
							<i class="glyphicon glyphicon-search"></i>
						</button>
						-->
						<button class="btn btn-default" type="submit">
							<i class="glyphicon glyphicon-search"></i>
						</button>
						
						</div>
					  </div>
					</form>
				<ul/>
				<ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li><a href="<?php echo site_url('home/shopping_cart');?>"><span class="glyphicon glyphicon-shopping-cart"></span> <?php echo number_format($this->my_cart->total_items(), 0, '.', '.'); ?> Item(s) - Rp. <?php echo number_format($this->my_cart->total(), 0, '.', '.'); ?></a></li>
					<li><a href="<?php echo site_url('home/wishlist');?>"><span class="glyphicon glyphicon-heart"></span><span id="total_wishlist"></span></a></li>
					<?php if(empty($id_member)){ ?>
						<li><a href="<?php echo site_url('home/register');?>">Register</a></li>
					<?php } ?>
					<?php if(empty($id_member)){ ?>
						<li><a href="<?php echo site_url('login_member');?>">Login</a></li>
					<?php }else{ ?>
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata('nama_member');?> <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href=""><span class="badge badge-info">My Account</span></a></li>
						<li class="dropdown-header"><a href="<?php echo site_url('home/message');?>">Send Message</a></li>
						<li class="dropdown-header"><a href="<?php echo site_url('home/change_profile');?>">Change Profile & Password</a></li>
						<li class="dropdown-header"><a href="<?php echo site_url('home/change_address');?>">Change Address</a></li>
						<li class="dropdown-header"><a href="<?php echo site_url('login_member/logout');?>">Logout</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="" class><span class="badge badge-info">Transaction</span></a></li>
						<li class="dropdown-header"><a href="<?php echo site_url('home/order_transaction');?>">Order Transaction</a></li>
						<li class="dropdown-header"><a href="<?php echo site_url('home/order_cancel');?>">Order Cancelled</a></li>
						<li class="dropdown-header"><a href="<?php echo site_url('home/order_history');?>">Order History</a></li>
					  </ul>
					</li>
					<?php }  ?>
				</ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    
	
	<!-- Page Content -->    
	<div class="container">
	
	<div class="row">
		<!-- BASIC NAVBAR //-->
		<div class="col-lg-12">
		  <div class="navbar navbar-default">
			<a class="navbar-brand" href="<?php echo site_url('home/index');?>"><span class="glyphicon glyphicon-home"></a>
			<ul class="nav navbar-nav">
			  <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="drop8">
				  Kategori Produk <span class="caret"></span>
				</a>
				<ul id="Kategori" name="Kategori" class="dropdown-menu" role="menu" aria-labelledby="drop8">
				</ul>
			  </li>
			  <!--<li><a href="#">Produk Baru</a></li>-->
			  <li><a href="<?php echo site_url('home/how_to_order');?>">Cara Pemesanan</a></li>
			  <li><a href="<?php echo site_url('home/about_us');?>">Tentang Kami</a></li>
			  <li><a href="<?php echo site_url('home/contact');?>">Kontak</a></li>
			  
			</ul>
		  </div>
		</div><!-- navbar col end //-->
	</div>