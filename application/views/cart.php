<!DOCTYPE html>
<html lang="en">

<head>
    <title>anugrahmitraselaras.com</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="OneTech shop project">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/oneTechTemplate/styles/bootstrap4/bootstrap.min.css');?>">
        

    <link href="<?php echo base_url('assets/oneTechTemplate/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css');?>" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/oneTechTemplate/plugins/OwlCarousel2-2.2.1/owl.carousel.css');?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/oneTechTemplate/plugins/OwlCarousel2-2.2.1/owl.theme.default.css');?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/oneTechTemplate/plugins/OwlCarousel2-2.2.1/animate.css');?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/oneTechTemplate/plugins/slick-1.8.0/slick.css');?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/oneTechTemplate/styles/main_styles.css');?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/oneTechTemplate/styles/responsive.css');?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/oneTechTemplate/styles/product_styles.css');?>">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/oneTechTemplate/styles/product_responsive.css');?>">

    <style>
        #contain {
            object-fit: contain;
            width: 200px;
            height: 93px;
        }
    </style>

</head>

<body>

<?php $id_member_login = $this->session->userdata('id_member'); ?>

    <div id="preloader"></div>

    <div class="super_container">

        <!-- Header -->

        <header class="header">

            <!-- Top Bar -->

            <div class="top_bar">
                <div class="container">
                    <div class="row">
                        <div class="col d-flex flex-row">
                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon"><img src="<?php echo base_url('assets/oneTechTemplate/images/phone.png');?>" alt=""></div>021 6406070</div>
                            <div class="top_bar_contact_item">
                                <div class="top_bar_icon"><img src="<?php echo base_url('assets/oneTechTemplate/images/mail.png');?>" alt=""></div><a href="mailto:fastsales@gmail.com">marketing@anugrahmitraselaras.com</a></div>
                            <div class="top_bar_content ml-auto">
                                <div class="top_bar_menu">

                                </div>
                                <div class="top_bar_user">
                                    <div class="user_icon"><img src="<?php echo base_url('assets/oneTechTemplate/images/user.svg');?>" alt=""></div>
                                    <div><a href="#">Register</a></div>
                                    <div><a href="#">Sign in</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Main -->

            <div class="header_main">
                <div class="container">
                    <div class="row">

                        <!-- Logo -->
                        <div class="col-lg-2 col-sm-3 col-3 order-1">
                            <div class="logo_container">
                                <div class="logo">
                                    <a href="#"><img id="contain" src="<?php echo base_url('assets/oneTechTemplate/images/logo.png');?>" alt=""></a>
                                </div>
                            </div>
                        </div>

                        <!-- Search -->
                        <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                            <div class="header_search">
                                <div class="header_search_content">
                                    <div class="header_search_form_container">
                                        <form action="#" class="header_search_form clearfix">
                                            <input type="search" required="required" class="header_search_input" placeholder="Search for products...">
                                            <div class="custom_dropdown">
                                                <div class="custom_dropdown_list">
                                                    <span class="custom_dropdown_placeholder clc">All Categories</span>
                                                    <i class="fas fa-chevron-down"></i>
                                                    <ul class="custom_list clc">
                                                        <li><a class="clc" href="#">All Categories</a></li>
                                                        <li><a class="clc" href="#">Alat Pelindung Diri</a></li>
                                                        <li><a class="clc" href="#">Laptops</a></li>
                                                        <li><a class="clc" href="#">Cameras</a></li>
                                                        <li><a class="clc" href="#">Hardware</a></li>
                                                        <li><a class="clc" href="#">Smartphones</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <button type="submit" class="header_search_button trans_300" style="background: #ec3237;" value="Submit"><img src="<?php echo base_url('assets/oneTechTemplate/images/search.png');?>" alt=""></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Wishlist -->
                        <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                            <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                                <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                                    <div class="wishlist_icon"><img src="<?php echo base_url('assets/oneTechTemplate/images/heart.png');?>" alt=""></div>
                                    <div class="wishlist_content">
                                        <div class="wishlist_text"><a href="#">Wishlist</a></div>
                                        <div class="wishlist_count">115</div>
                                    </div>
                                </div>

                                <!-- Cart -->
                                <div class="cart">
                                    <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                                        <div class="cart_icon">
                                            <img src="<?php echo base_url('assets/oneTechTemplate/images/cart.png');?>" alt="">
                                            <div class="cart_count"><span>10</span></div>
                                        </div>
                                        <div class="cart_content">
                                            <div class="cart_text"><a href="#">Cart</a></div>
                                            <div class="cart_price">$85</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Navigation -->

            <nav class="main_nav">
                <div class="container">
                    <div class="row">
                        <div class="col">

                            <div class="main_nav_content d-flex flex-row">

                                <!-- Categories Menu -->

                                <div class="cat_menu_container" style="background: #ec3237;">
                                    <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                                        <div class="cat_burger"><span></span><span></span><span></span></div>
                                        <div class="cat_menu_text">categories</div>
                                    </div>

                                    <ul class="cat_menu">

                                        <li class="hassubs">
                                            <a href="#">Alat Pelindung Diri<i class="fas fa-chevron-right"></i></a>
                                            <ul>
                                                <li><a href="#">Masker</a></li>
                                                <li><a href="#">Sarung Tangan<i class="fas fa-chevron-right"></i></a></li>
                                            </ul>
                                        </li>

                                        <li><a href="#">Instrument<i class="fas fa-chevron-right ml-auto"></i></a></li>
                                        <li><a href="#">Dressing<i class="fas fa-chevron-right"></i></a></li>
                                        <li><a href="#">Perawatan Pernafasan<i class="fas fa-chevron-right"></i></a></li>
                                        <li><a href="#">Perawatan Kardiovaskular<i class="fas fa-chevron-right"></i></a></li>
                                        <li><a href="#">Perawatan Perkemihan<i class="fas fa-chevron-right"></i></a></li>
                                        <li class="hassubs">
                                            <a href="#">Elektromedik<i class="fas fa-chevron-right"></i></a>
                                            <ul>
                                                <li><a href="#">Syringe Pump<i class="fas fa-chevron-right"></i></a></li>
                                                <li><a href="#">Infusion Pump<i class="fas fa-chevron-right"></i></a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Alcohol Swab Remedi<i class="fas fa-chevron-right"></i></a></li>
                                        <li><a href="#">ID Brecelet<i class="fas fa-chevron-right"></i></a></li>
                                        <li><a href="#">Suture Needle Hecting<i class="fas fa-chevron-right"></i></a></li>
                                        <li><a href="#">Suture Catgut<i class="fas fa-chevron-right"></i></a></li>
                                        <li><a href="#">Torniquet<i class="fas fa-chevron-right"></i></a></li>
                                        <li><a href="#">Haemolance Plus Safety Lancet<i class="fas fa-chevron-right"></i></a></li>
                                        <li><a href="#">Safety Box<i class="fas fa-chevron-right"></i></a></li>
                                    </ul>
                                </div>

                                <!-- Main Nav Menu -->

                                <div class="main_nav_menu ml-auto">
                                    <ul class="standard_dropdown main_nav_dropdown">
                                        <li><a href="#">Home<i class="fas fa-chevron-down"></i></a></li>
                                        <li class="hassubs">
                                            <a href="#">Super Deals<i class="fas fa-chevron-down"></i></a>
                                            <ul>
                                                <li>
                                                    <a href="#">Menu Item<i class="fas fa-chevron-down"></i></a>
                                                    <ul>
                                                        <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                        <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                        <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                            </ul>
                                        </li>
                                        <li class="hassubs">
                                            <a href="#">Featured Brands<i class="fas fa-chevron-down"></i></a>
                                            <ul>
                                                <li><a href="#">Remedi<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="#">Hohlkorpel<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="#">Sino MDT<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="#">Jeva Mask<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="#">Vasflow<i class="fas fa-chevron-down"></i></a></li>
                                            </ul>
                                        </li>
                                        <li class="hassubs">
                                            <a href="#">Pages<i class="fas fa-chevron-down"></i></a>
                                            <ul>
                                                <li><a href="shop.html">Shop<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="product.html">Product<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="blog.html">Blog<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="blog_single.html">Blog Post<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="regular.html">Regular Post<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="cart.html">Cart<i class="fas fa-chevron-down"></i></a></li>
                                                <li><a href="contact.html">Contact<i class="fas fa-chevron-down"></i></a></li>
                                            </ul>
                                        </li>
                                        <li><a href="blog.html">Blog<i class="fas fa-chevron-down"></i></a></li>
                                        <li><a href="contact.html">Contact<i class="fas fa-chevron-down"></i></a></li>
                                    </ul>
                                </div>

                                <!-- Menu Trigger -->

                                <div class="menu_trigger_container ml-auto">
                                    <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                                        <div class="menu_burger">
                                            <div class="menu_trigger_text">menu</div>
                                            <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Menu -->

            <div class="page_menu">
                <div class="container">
                    <div class="row">
                        <div class="col">

                            <div class="page_menu_content">

                                <div class="page_menu_search">
                                    <form action="#">
                                        <input type="search" required="required" class="page_menu_search_input" placeholder="Search for products...">
                                    </form>
                                </div>
                                <ul class="page_menu_nav">
                                    <li class="page_menu_item has-children">
                                        <a href="#">Language<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">English<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Italian<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Spanish<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Japanese<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="page_menu_item has-children">
                                        <a href="#">Currency<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">US Dollar<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">EUR Euro<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">GBP British Pound<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">JPY Japanese Yen<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="page_menu_item">
                                        <a href="#">Home<i class="fa fa-angle-down"></i></a>
                                    </li>
                                    <li class="page_menu_item has-children">
                                        <a href="#">Super Deals<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">Super Deals<i class="fa fa-angle-down"></i></a></li>
                                            <li class="page_menu_item has-children">
                                                <a href="#">Menu Item<i class="fa fa-angle-down"></i></a>
                                                <ul class="page_menu_selection">
                                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="page_menu_item has-children">
                                        <a href="#">Featured Brands<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">Featured Brands<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="page_menu_item has-children">
                                        <a href="#">Trending Styles<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">Trending Styles<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="page_menu_item"><a href="blog.html">blog<i class="fa fa-angle-down"></i></a></li>
                                    <li class="page_menu_item"><a href="contact.html">contact<i class="fa fa-angle-down"></i></a></li>
                                </ul>

                                <div class="menu_contact">
                                    <div class="menu_contact_item">
                                        <div class="menu_contact_icon"><img src="<?php echo base_url('assets/oneTechTemplate/images/phone_white.png');?>" alt=""></div>+38 068 005 3570</div>
                                    <div class="menu_contact_item">
                                        <div class="menu_contact_icon"><img src="<?php echo base_url('assets/oneTechTemplate/images/mail_white.png');?>" alt=""></div><a href="mailto:fastsales@gmail.com">fastsales@gmail.com</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </header>

        	<!-- Cart -->

	<div class="cart_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="cart_container">
						<div class="cart_title">Shopping Cart</div>
						<div class="cart_items">
							<ul class="cart_list">
								<li class="cart_item clearfix">
									<div class="cart_item_image"><img src="images/shopping_cart.jpg" alt=""></div>
									<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
										<div class="cart_item_name cart_info_col">
											<div class="cart_item_title">Name</div>
											<div class="cart_item_text">MacBook Air 13</div>
										</div>
										<div class="cart_item_color cart_info_col">
											<div class="cart_item_title">Color</div>
											<div class="cart_item_text"><span style="background-color:#999999;"></span>Silver</div>
										</div>
										<div class="cart_item_quantity cart_info_col">
											<div class="cart_item_title">Quantity</div>
											<div class="cart_item_text">1</div>
										</div>
										<div class="cart_item_price cart_info_col">
											<div class="cart_item_title">Price</div>
											<div class="cart_item_text">$2000</div>
										</div>
										<div class="cart_item_total cart_info_col">
											<div class="cart_item_title">Total</div>
											<div class="cart_item_text">$2000</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
						
						<!-- Order Total -->
						<div class="order_total">
							<div class="order_total_content text-md-right">
								<div class="order_total_title">Order Total:</div>
								<div class="order_total_amount">$2000</div>
							</div>
						</div>

						<div class="cart_buttons">
							<button type="button" class="button cart_button_clear">Add to Cart</button>
							<button type="button" class="button cart_button_checkout">Add to Cart</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Recently Viewed -->

	<div class="viewed">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="viewed_title_container">
						<h3 class="viewed_title">Similar Products</h3>
						<div class="viewed_nav_container">
							<div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
							<div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
						</div>
					</div>

					<div class="viewed_slider_container">
						
						<!-- Recently Viewed Slider -->

						<div class="owl-carousel owl-theme viewed_slider">
							
                            <?php foreach ($produk_sejenis as $hasilnya){
                        $harga_rupiah = number_format($hasilnya->harga, 0, '.', '.'); ?>
							<!-- Recently Viewed Item -->
							<div class="owl-item">
								<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="<?php echo base_url('upload/foto_produk/'.$hasilnya->foto_1); ?>" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">Rp. <?php echo $harga_rupiah; ?></div>
										<div class="viewed_name"><a href="<?php echo site_url('Tes/produk_detail').'/'.$hasilnya->id_produk; ?>"><?php echo substr($hasilnya->nama_produk,0,13).'...';?></a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>
							</div>

                            <?php } ?>


						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Brands -->

	<div class="brands">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="brands_slider_container">
						
						<!-- Brands Slider -->

						<div class="owl-carousel owl-theme brands_slider">
							
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_1.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_2.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_3.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_4.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_5.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_6.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_7.jpg" alt=""></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><img src="images/brands_8.jpg" alt=""></div></div>

						</div>
						
						<!-- Brands Slider Navigation -->
						<div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>
						<div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Newsletter -->

	<div class="newsletter">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
						<div class="newsletter_title_container">
							<div class="newsletter_icon"><img src="images/send.png" alt=""></div>
							<div class="newsletter_title">Sign up for Newsletter</div>
							<div class="newsletter_text"><p>...and receive %20 coupon for first shopping.</p></div>
						</div>
						<div class="newsletter_content clearfix">
							<form action="#" class="newsletter_form">
								<input type="email" class="newsletter_input" required="required" placeholder="Enter your email address">
								<button class="newsletter_button">Subscribe</button>
							</form>
							<div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

        <!-- Footer -->

        <footer class="footer">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 footer_col">
                        <div class="footer_column footer_contact">
                            <div class="logo_container">
                                <div class="logo"><a href="#"><img id="contain" src="<?php echo base_url('assets/oneTechTemplate/images/logo.png');?>" alt=""></a></div>
                            </div>
                            <div class="footer_title">Got Question? Call Us </div>
                            <div class="footer_phone">021 - 640 6070</div>
                            <div class="footer_contact_text">
                                <p>Jl. Agung Niaga IV No. 55</p>
                                <p>Sunter Agung Podomoro</p>
                            </div>
                            <div class="footer_social">
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                    <li><a href="#"><i class="fab fa-google"></i></a></li>
                                    <li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 offset-lg-2">
                        <div class="footer_column">
                            <div class="footer_title">Find it Fast</div>
                            <ul class="footer_list">
                                <li><a href="#">Masker</a></li>
                                <li><a href="#">Sarung Tangan</a></li>
                                <li><a href="#">Instrument</a></li>
                                <li><a href="#">Dressing</a></li>
                                <li><a href="#">Perawatan Pernapasan</a></li>
                                <li><a href="#">Perawatan Kardiovaskular</a></li>
                                <li><a href="#">Perawatan Perkemihan</a></li>
                                <li><a href="#">Syringe Pump</a></li>
                                <li><a href="#">Infusion Pump</a></li>
                            </ul>
                            
                            
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="footer_column">
                            <ul class="footer_list footer_list_2">
                                
                                <li><a href="#">Alcohol Swab</a></li>
                                <li><a href="#">ID Brecelet</a></li>
                                <li><a href="#">Suture Needle Hecting</a></li>
                                <li><a href="#">Suture Catgut</a></li>
                                <li><a href="#">Torniquet</a></li>
                                <li><a href="#">Haemolance plus Safety Lancet</a></li>
                                <li><a href="#">Suture Needle Hecting</a></li>
                                <li><a href="#">Safety Box</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="footer_column">
                            <div class="footer_title">Customer Care</div>
                            <ul class="footer_list">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">Order Tracking</a></li>
                                <li><a href="#">Wish List</a></li>
                                <li><a href="#">Customer Services</a></li>
                                <li><a href="#">Returns / Exchange</a></li>
                                <li><a href="#">FAQs</a></li>
                                <li><a href="#">Product Support</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </footer>

        <!-- Copyright -->

        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <div class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
                            <div class="copyright_content">
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                Copyright &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            </div>
                            <div class="logos ml-sm-auto">
                                <ul class="logos_list">
                                    <li>
                                        <a href="#"><img src="<?php echo base_url('assets/oneTechTemplate/images/logos_1.png');?>" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="<?php echo base_url('assets/oneTechTemplate/images/logos_2.png');?>" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="<?php echo base_url('assets/oneTechTemplate/images/logos_3.png');?>" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="<?php echo base_url('assets/oneTechTemplate/images/logos_4.png');?>" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('assets/oneTechTemplate/js/jquery-3.3.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/styles/bootstrap4/popper.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/styles/bootstrap4/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/plugins/greensock/TweenMax.min.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/plugins/greensock/TimelineMax.min.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/plugins/scrollmagic/ScrollMagic.min.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/plugins/greensock/animation.gsap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/plugins/greensock/ScrollToPlugin.min.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/plugins/OwlCarousel2-2.2.1/owl.carousel.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/plugins/slick-1.8.0/slick.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/plugins/easing/easing.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/js/custom.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/js/preload.js');?>"></script>
    <script src="<?php echo base_url('assets/oneTechTemplate/js/product_custom.js');?>"></script>
</body>

</html>