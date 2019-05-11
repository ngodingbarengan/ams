<?php $hak_akses = $this->session->userdata('hak_akses_user');?>

<!--header start-->
      <header class="header dark-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Klik Menu" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>

            <!--logo start-->
            <a href="#" class="logo"><span class="lite">PT. Anugrah Mitra Selaras</span></a>
            <!--logo end-->


            <div class="top-nav notification-row">                
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">
                    

                    <!-- inbox notification start-->
					<!--
                    <li id="mail_notificatoin_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon-envelope-l"></i>
                            <span class="badge bg-important">5</span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <div class="notify-arrow notify-arrow-blue"></div>
                            <li>
                                <p class="blue">You have 5 new messages</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="<?php echo base_url('assets/NiceAdmin/img/avatar-mini.jpg');?>"></span>
                                    <span class="subject">
                                    <span class="from">Greg  Martin</span>
                                    <span class="time">1 min</span>
                                    </span>
                                    <span class="message">
                                        I really like this admin panel.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="<?php echo base_url('assets/NiceAdmin/img/avatar-mini2.jpg');?>"></span>
                                    <span class="subject">
                                    <span class="from">Bob   Mckenzie</span>
                                    <span class="time">5 mins</span>
                                    </span>
                                    <span class="message">
                                     Hi, What is next project plan?
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="<?php echo base_url('assets/NiceAdmin/img/avatar-mini3.jpg');?>"></span>
                                    <span class="subject">
                                    <span class="from">Phillip   Park</span>
                                    <span class="time">2 hrs</span>
                                    </span>
                                    <span class="message">
                                        I am like to buy this Admin Template.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="photo"><img alt="avatar" src="<?php echo base_url('assets/NiceAdmin/img/avatar-mini4	.jpg');?>"></span>
                                    <span class="subject">
                                    <span class="from">Ray   Munoz</span>
                                    <span class="time">1 day</span>
                                    </span>
                                    <span class="message">
                                        Icon fonts are great.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">See all messages</a>
                            </li>
                        </ul>
                    </li>
					-->
                    <!-- inbox notificatoin end -->
					
                    <!-- alert notification start-->
					<!--
                    <li id="alert_notificatoin_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <i class="icon-bell-l"></i>
                            <span class="badge bg-important">7</span>
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-blue"></div>
                            <li>
                                <p class="blue">You have 4 new notifications</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary"><i class="icon_profile"></i></span> 
                                    Friend Request
                                    <span class="small italic pull-right">5 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-warning"><i class="icon_pin"></i></span>  
                                    John location.
                                    <span class="small italic pull-right">50 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-danger"><i class="icon_book_alt"></i></span> 
                                    Project 3 Completed.
                                    <span class="small italic pull-right">1 hr</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-success"><i class="icon_like"></i></span> 
                                    Mick appreciated your work.
                                    <span class="small italic pull-right"> Today</span>
                                </a>
                            </li>                            
                            <li>
                                <a href="#">See all notifications</a>
                            </li>
                        </ul>
                    </li>
					-->
                    <!-- alert notification end-->
                    
					<!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">
                                <img alt="" src="<?php base_url('assets/NiceAdmin/img/avatar1_small.jpg');?>">
                            </span>
                            <span class="username"><?php echo $this->session->userdata('nama_user'); ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li class="eborder-top">
                                <a href="#"><i class="icon_profile"></i> Change Profile</a>
                            </li>
                            <li>
                                <a href="#"><i class="icon_mail_alt"></i> My Inbox</a>
                            </li>
                            <li>
                                <a href="#"><i class="icon_clock_alt"></i> Notification</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('login_user/logout');?>"><i class="icon_key_alt"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
      </header>      
      <!--header end-->

      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu">
				
				<!-- HAK AKSES ADMINISTRATOR -->
				<?php if($hak_akses == "ADMINISTRATOR") {?>
                  <!--
				  <li class="">
                      <a class="" href="#">
                          <i class="glyphicon glyphicon-home"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
				  -->
				  <li class="">
                      <a class="" href="<?php echo site_url('approval/app_co');?>">
                          <i class="glyphicon glyphicon-ok"></i>
                          <span>Approval <br/>Customer Order</span>
                      </a>
                  </li>
				  <li class="">
                      <a class="" href="<?php echo site_url('approval/app_so');?>">
                          <i class="glyphicon glyphicon-ok"></i>
                          <span>Approval <br/>Sales Order</span>
                      </a>
                  </li>
				  <li class="">
                      <a class="" href="<?php echo site_url('approval/app_po');?>">
                          <i class="glyphicon glyphicon-ok"></i>
                          <span>Approval <br/>Purchase Order</span>
                      </a>
                  </li>
				  <li class="sub-menu ">
                      <a href="javascript:;" class="">
                          <i class="glyphicon glyphicon-list-alt"></i>
                          <span>Laporan</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">                          
                          <li><a class="" href="<?php echo site_url('laporan/lap_penjualan');?>">Penjualan</a></li>
						  <li><a class="" href="<?php echo site_url('laporan/lap_pembelian');?>">Pembelian</a></li>
                      </ul>
                  </li>
				  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="glyphicon glyphicon-hdd"></i>
                          <span>Master Data</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="<?php echo site_url('user/index');?>">Data User</a></li>
						  <li><a class="" href="<?php echo site_url('produk/index');?>">Data Produk</a></li>
						  <li><a class="" href="<?php echo site_url('satuan/index');?>">Data Satuan</a></li>
						  <li><a class="" href="<?php echo site_url('merek/index');?>">Data Merek</a></li>
						  <li><a class="" href="<?php echo site_url('kategori/index');?>">Data Kategori</a></li>
						  <li><a class="" href="<?php echo site_url('kategori/index');?>">Data Nama Bank</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu ">
                      <a href="javascript:;" class="">
                          <i class="glyphicon glyphicon-duplicate"></i>
                          <span>Halaman</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">                          
                          <li><a class="" href="<?php echo site_url('halaman/cara_pemesanan');?>">Cara Pemesanan</a></li>
                          <li><a class="" href="<?php echo site_url('halaman/tentang_kami');?>"><span>Tentang Kami</span></a></li>
                          <li><a class="" href="<?php echo site_url('halaman/kontak');?>">Kontak</a></li>
						  <li><a class="" href="<?php echo site_url('halaman/syarat_ketentuan');?>">Syarat dan Ketentuan</a></li>
                      </ul>
                  </li>
                <?php } ?>
				
				
				<!-- HAK AKSES GUDANG -->
				<?php if($hak_akses == "GUDANG") {?>
                  <li class="">
                      <a class="" href="<?php echo site_url('purchase_order/index');?>">
                          <i class="glyphicon glyphicon-edit"></i>
                          <span>Purchase Order</span>
                      </a>
                  </li>
				  <li class="">
                      <a class="" href="<?php echo site_url('kirim_order/index');?>">
                          <i class="glyphicon glyphicon-send"></i>
                          <span>Kirim Pesanan</span>
                      </a>
                  </li>
				  <li class="">
                      <a class="" href="<?php echo site_url('produk/index');?>">
                          <i class="glyphicon glyphicon-info-sign"></i>
                          <span>Informasi Produk</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="glyphicon glyphicon-hdd"></i>
                          <span>Master Data</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="<?php echo site_url('supplier/index');?>">Data Supplier</a></li>
						  <li><a class="" href="<?php echo site_url('provinsi/index');?>">Data Provinsi</a></li>
						  <li><a class="" href="<?php echo site_url('kota_kab/index');?>">Data Kota/Kabupaten</a></li>
						  <li><a class="" href="<?php echo site_url('kecamatan/index');?>">Data Kecamatan</a></li>
						  <li><a class="" href="<?php echo site_url('jenis_pengiriman/index');?>">Data Jenis Pengiriman</a></li>
						  <li><a class="" href="<?php echo site_url('ongkir/index');?>">Ongkos Kirim</a></li>
						  
                      </ul>
                  </li>
                <?php } ?>
				
				
				<!-- HAK AKSES SALES -->
				<?php if($hak_akses == "SALES") {?>
                  <li class="">
                      <a class="" href="<?php echo site_url('sales_order/index');?>">
                          <i class="glyphicon glyphicon-edit"></i>
                          <span>Sales Order</span>
                      </a>
                  </li>
				  <li class="">
                      <a class="" href="<?php echo site_url('laporan/lap_sales');?>">
                          <i class="glyphicon glyphicon-list-alt"></i>
                          <span>Laporan Penjualan</span>
                      </a>
                  </li>
				  <li class="">
                      <a class="" href="<?php echo site_url('produk/index');?>">
                          <i class="glyphicon glyphicon-info-sign"></i>
                          <span>Informasi Produk</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="glyphicon glyphicon-hdd"></i>
                          <span>Master Data</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="<?php echo site_url('customer/index');?>">Data Customer</a></li>	  
                      </ul>
                  </li>
                <?php } ?>
				
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->