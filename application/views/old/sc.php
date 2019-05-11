	
<b>My Cart</b>
 
<?php form_open('home/update'); ?> 
<table cellpadding="6" cellspacing="1" style="width:100%" border="1">
 
    <tr>
		<th>ID</th>
		<th>Nama</th>
        <th>Qty</th>
		<th>Weight</th>
		<th>Sub-Weight</th>
        <th style="text-align:right">Item Price</th>
        <th style="text-align:right">Sub-Total</th>
		<th>Action</th>
    </tr>
 
    <?php 
 
    $i = 1;
 
    foreach ($this->my_cart->contents() as $items): ?>
 
        <?php echo form_hidden('id', $items['rowid']); ?>
 
        <tr>
			<td><?php echo $items['id']; ?></td>
			<td><?php echo $items['name']; ?></td>
            <td><input type="jumlah" name="<?php echo $i.'[qty]'; ?>" maxlength="10" size="5" value="<?php echo $items['qty']; ?>" /></td>
			<td><?php echo number_format($items['weight'], 3, ',', '.'); ?> Kg</td>
			<td style="text-align:right"><?php echo number_format($items['subweight'], 3, ',', '.'); ?> Kg</td>
            <td style="text-align:right">Rp. <?php echo number_format($items['price'], 0, '.', '.'); ?></td>
			<td style="text-align:right">Rp. <?php echo number_format($items['subtotal'], 0, '.', '.'); ?></td>
			<td>
				<!--
				<button type="button" onclick="location.href='home/update/'">Ubah</button>
				<button type="button" onclick="location.href='remove/<?php echo $items['rowid']; ?>'">Hapus</button>
				-->
				<button type="submit">Ubah</button>
				<a href="<?php echo site_url('home/remove').'/'.$items['rowid'];?>">Hapus</a>
			</td>
        </tr>
 
        <?php $i++; ?>
 
    <?php endforeach; ?>
 
    <tr>
        <td colspan="2"></td>
        <td class="right"><strong>Total</strong></td>
		<td colspan="2" class="right" class="right" align="center"><?php echo number_format($this->my_cart->total_weight(), 3, ',', '.'); ?> Kg</td>
        <td colspan="3" class="right" align="center">Rp. <?php echo number_format($this->my_cart->total(), 0, '.', '.'); ?></td>
    </tr>
 
</table>

<?php form_close(); ?>
