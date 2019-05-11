<?php $this->load->view('include/home-header');?>
<?php $this->load->view('include/home-navbar');?>


	<div class="row">
		<div class="col-lg-12">
		  <ul class="breadcrumb">
			<li><a href="<?php echo site_url('home/index');?>"><span class="glyphicon glyphicon-home"></a></li>
			<li class="active"><a href="">Shopping Cart</a></li>
		  </ul>
		</div>
		</div><!-- breadcrumb row end //-->
	

	<table id="cart" class="table table-hover table-condensed">
    				<thead>
						<tr><h3><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h3></tr>
					<?php if(!empty($this->my_cart->contents())) { ?>
						<tr>
							<th style="width:50%">Product</th>
							<th style="width:15%">Price</th>
							<th style="width:10%" class="text-center">Quantity</th>
							<th style="width:19%" class="text-center">Subtotal</th>
							<th style="width:6%" class="text-center">Action</th>
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
										<!--<h6 class="nomargin"><strong>Stok (4 tersedia)</strong></h6>-->
									</div>
								</div>
							</td>
							<td data-th="Price"><?php echo number_format($items['price'], 0, ',', '.'); ?></td>
							<td data-th="Quantity">
								<input type="number" id="jumlah<?php echo $i; ?>" name="jumlah<?php echo $i; ?>" class="form-control text-center" value="<?php echo $items['qty']; ?>">
							</td>
							<td data-th="Subtotal" class="text-center">Rp. <?php echo number_format($items['subtotal'], 0, ',', '.'); ?></td>
							<td class="actions text-center" data-th="">
								<button id="update_item" type="button" class="btn btn-link btn-xs" onclick="update_item('<?php echo $items['rowid'];?>', 'jumlah<?php echo $i; ?>')">
										<span class="glyphicon glyphicon-refresh"> </span>
								</button>
								<button id="delete_item" type="button" class="btn btn-link btn-xs" onclick="delete_item('<?php echo $items['rowid'];?>')">
										<span class="glyphicon glyphicon-trash"> </span>
								</button>						
							</td>
						</tr>
						
						<?php $i++; ?>
					<?php endforeach; ?>
					</tbody>
					
					<tfoot>
						<tr>
							<td colspan="2" class="hidden-xs"></td>
							<td class="hidden-xs text-left"><h3><strong>Subtotal</strong></h3></td>
							<td colspan="2" class="hidden-xs text-right"><h3><strong>Rp. <?php echo number_format($this->my_cart->total(), 0, '.', '.'); ?></strong></h3></td>
						</tr>
						<tr>
							<td colspan="2" class="hidden-xs"></td>
							<td class="hidden-xs text-left" style="padding-top:15px;">
								<button type="button" class="btn btn-info" onclick="location.href='<?php echo site_url('home/index');?>'">
									<span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
								</button>
							</td>
							<td colspan="2" class="hidden-xs text-right" style="padding-top:15px;">
							<button type="button" class="btn btn-success" onclick='location.href="<?php echo site_url('home/checkout');?>"'>Checkout
								<span class="glyphicon glyphicon-share-alt"></span>
							</button>
							</td>
						</tr>
					</tfoot>
					<?php }else{ ?>
						<tr><br/></tr>
						<tr>
							Shopping cart masih kosong.
						</tr>
					<?php } ?>
				</table>

	
	<script type="text/javascript">
    
	$(document).ready(function(){
		$("#jumlah").numeric();
	});
	
    function update_item(id, jlh){
        var jumlah = document.getElementById(jlh);
		//alert(id);
		//alert(jumlah.value);
		//Kirim data via ajax untuk update data
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('home/update_cart_item');?>",
			data: { 
				id_item : id, 
				jumlah_item: jumlah.value
			},
			success: function(){
				//alert('wow' + msg);
				//location.reload();
				window.location.replace("<?php echo site_url('home/shopping_cart');?>");
			}
		});
    }
	
	function delete_item(id){
		//alert(id);
		//Kirim data via ajax untuk delete data
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('home/remove_cart_item');?>",
			data: { 
				id_item : id
			},
			success: function(){
				//location.reload();
				window.location.replace("<?php echo site_url('home/shopping_cart');?>");
			}
		});
    }
</script>
	
<?php $this->load->view('include/home-footer');?>
