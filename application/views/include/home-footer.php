    <!-- /.container -->
	    <hr>
	</div>
	
	<!-- Footer -->
		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="row text-center">
						<p class="text-muted">Powered by PT. Anugrah Mitra Selaras &copy; 2017</p>
					</div>
				</div>
			</div>
		</footer>
	
		
	<!-- Javascript Library Load from Server
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	-->
    
	<!-- Placed at the end of the document so the pages load faster -->
	<!--taruh jquery dan bootsrap di paling atas karena akan library utama harus diatas plugin-->
	
	<!-- Add on JavaScript -->
	<script src="<?php echo base_url('assets/home/js/thumb_slider.js');?>"></script>
	
	<script type="text/javascript">
	
		function add_data(id){

			$.ajax({
				url : "<?php echo site_url('home/add_wishlist'); ?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					alert('Anda berhasil menambah wishlist');
					location.reload();
				},
				error: function (xhr, status, error)
				{
					//alert('Error get data from ajax');
					 alert(xhr.responseText);
				}
			});
		}
	
		function delete_data(id){

			$.ajax({
				url : "<?php echo site_url('home/delete_wishlist'); ?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					alert('Anda berhasil menghapus wishlist');
					location.reload();
				},
				error: function (xhr, status, error)
				{
					//alert('Error get data from ajax');
					 alert(xhr.responseText);
				}
			});
		}
		
		$('#form_search').submit(function(e){
			if($('#search_text').val() == ""){
				alert('Masukkan dulu keyword pencarian');
				return false;
			}else{
				return true;
			}
		});
		
	</script>

	
	<script type="text/javascript">
		$(document).ready(function(){

			//show the menu category
			$.ajax({
				url : "<?php echo site_url('home/select_kategori')?>/",
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					$.each(data, function(i, item){
						$('[name="Kategori"]').append('<li role="menuitem"><a tabindex="-1" href="<?php echo site_url('home/category')?>/'+data[i].id_kategori+'">'+data[i].nama_kategori+'</a></li>');				
					});
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
				alert('Error get data from ajax');
				}
			});
			
			//count total wishlist by user
			<?php if(!empty($this->session->userdata('id_member'))){ ?>
			$.ajax({
				url : "<?php echo site_url('home/count_all_wishlist'); ?>/"+<?php echo $this->session->userdata('id_member');?>,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					//alert(data);
					$("#total_wishlist").text('  Wishlist ('+data+')');
				},
				error: function (xhr, status, error)
				{
					//alert('Error get data from ajax');
					alert(xhr.responseText);
				}
			});
			<?php }else{ ?>
				$("#total_wishlist").text('  Wishlist (0)');
			<?php } ?>
		});
		
		/* define $ as jQuery just in case */
		(function($) {
		/* doc ready */
		$(function() {
		/* init the plugin */
		$('#my_thumb_slider').thumb_slider();
		});
		})(jQuery);
	</script>
	
	<script type="javascript">
	@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);
	body {
	  font-family: 'Open Sans', 'sans-serif';
	}
	.mega-dropdown {
	  position: static !important;
	}
	.mega-dropdown-menu {
		padding: 20px 0px;
		width: 100%;
		box-shadow: none;
		-webkit-box-shadow: none;
	}
	.mega-dropdown-menu > li > ul {
	  padding: 0;
	  margin: 0;
	}
	.mega-dropdown-menu > li > ul > li {
	  list-style: none;
	}
	.mega-dropdown-menu > li > ul > li > a {
	  display: block;
	  color: #222;
	  padding: 3px 5px;
	}
	.mega-dropdown-menu > li ul > li > a:hover,
	.mega-dropdown-menu > li ul > li > a:focus {
	  text-decoration: none;
	}
	.mega-dropdown-menu .dropdown-header {
	  font-size: 18px;
	  color: #ff3546;
	  padding: 5px 60px 5px 5px;
	  line-height: 30px;
	}

	.carousel-control {
	  width: 30px;
	  height: 30px;
	  top: -35px;

	}
	.left.carousel-control {
	  right: 30px;
	  left: inherit;
	}
	.carousel-control .glyphicon-chevron-left, 
	.carousel-control .glyphicon-chevron-right {
	  font-size: 12px;
	  background-color: #fff;
	  line-height: 30px;
	  text-shadow: none;
	  color: #333;
	  border: 1px solid #ddd;
	}
	</script>
	
	
</body>

</html>