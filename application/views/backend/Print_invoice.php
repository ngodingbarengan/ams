<html>
<head>
	<!-- Bootstrap CSS -->    
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
	
    <!-- bootstrap theme --> <!-- penyebab modal tidak mau tampil karena ada dua Bootstrap CSS -->
	<!--<link href="<?php echo base_url('assets/NiceAdmin/css/bootstrap-theme.css');?>" rel="stylesheet">-->
    
	<!--external css-->
    <!-- font icon -->
	<link href="<?php echo base_url('assets/NiceAdmin/css/elegant-icons-style.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/NiceAdmin/css/font-awesome.min.css');?>" rel="stylesheet">
    <!-- Custom styles -->
	<link href="<?php echo base_url('assets/NiceAdmin/css/style.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/NiceAdmin/css/style-responsive.css');?>" rel="stylesheet">
	<!-- Bootstrap styles -->
	<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet">
	<!-- jQuery UI -->
	<link href="<?php echo base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.css');?>" rel="stylesheet">
	<!-- datepicker CSS -->
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
	
	<!-- javascript library -->
	
	<!-- jquery and bootstrap -->
	<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
	
	<!-- datatables -->
	<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
	<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
	
	<!-- jQuery UI -->
	<script src="<?php echo base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.js')?>"></script>
	
	<!-- tinyMCE -->
	<script src="<?php echo base_url('assets/tinymce/tinymce.min.js')?>"></script>
</head>

<body>
	<table border="0">
	<tr>
	<td width="55%">
		<table>
			
			<tr> 
				<td><img src="<?php echo base_url('assets/images/logo2.png')?>"/></td>  
			</tr>
			<tr> 
				<td><br/></td>
			</tr>
			<tr> 
				<td>Jl. Agung Niaga IV, RT. 014/RW. 013</td>
			</tr> 
			<tr> 
				<td>Sunter Agung</td>
			</tr> 
			<tr> 
				<td>Tanjung Priok</td>
			</tr> 
			<tr> 
				<td>Kota Jakarta Utara</td>
			</tr>
			<tr> 
				<td>Indonesia - 14350</td>
			</tr>
			
			<tr> 
				<td>E-mail : info@amsshop.com</td>
			</tr>
			<tr> 
				<td>Phone : +62-21-6406029</td>
			</tr>
			<tr> 
				<td>Fax : +62-21-6406028</td>
			</tr>
		</table> 
	</td>
	<td width="45%">
		<table>
			<tr> 
				<td style="width:120px; vertical-align:top;"><strong><i>Invoice No.</i></strong></td> 
				<td style="width:20px; vertical-align:top;"><strong><i>:</i></strong></td> 
				<td style="width:200px; vertical-align:top;"><strong><i><?php echo $master->nomor_order; ?></i></strong></td> 
			</tr>
			<tr> 
				<td style="width:120px; vertical-align:top;"><strong><i>Tanggal</i></strong></td> 
				<td style="width:20px; vertical-align:top;"><strong><i>:</i></strong></td> 
				<td style="width:200px; vertical-align:top;"><strong><i><?php echo $master->tanggal; ?></i></strong></td> 
			</tr>
			
			<tr> 
				<td><br/></td>
			</tr> 
			
			<tr> 
				<td style="width:120px; vertical-align:top;">Kepada</td> 
				<td style="width:20px; vertical-align:top;">:</td> 
				<td style="width:200px; vertical-align:top;"><?php echo $master->nama_lengkap; ?></td> 
			</tr> 
			<tr> 
				<td style="width:200px; vertical-align:top;">Alamat</td> 
				<td style="width:20px; vertical-align:top;">: </td> 
				<td style="width:600px; vertical-align:top;"><?php echo $master->alamat; ?><br/><?php echo $master->nama_kecamatan; ?><br/><?php echo $master->nama_kota_kab; ?><br/><?php echo $master->nama_provinsi; ?></td> 
			</tr> 
			<tr> 
				<td style="width:120px; vertical-align:top;">Telp. / HP</td> 
				<td style="width:20px; vertical-align:top;">: </td> 
				<td style="width:200px; vertical-align:top;"><?php echo $master->no_kontak; ?></td> 
			</tr> 
			<tr> 
				<td style="width:120px; vertical-align:top;">Keterangan</td> 
				<td style="width:20px; vertical-align:top;">: </td> 
				<?php if($master->keterangan != ''){ ?>
				<td style="width:200px; vertical-align:top;"><?php echo $master->keterangan; ?></td> 
				<?php }else{ ?>
				<td>-</td> 
				<?php } ?>
			</tr>

		</table> 
	</td>
	</tr>
	
	<tr>
	<td colspan="2">
	<table class="table" style="margin-bottom: 0px; margin-top: 30px;"> 
		<thead>
			<tr></tr>
			<tr> 
				<th style="width:5%; text-align:center;">No.</th> 
				<th style="width:10%">Kode Produk</th> 
				<th style="width:25%">Nama Produk</th> 
				<th style="width:10%; text-align:center;">Jumlah</th> 
				<th style="width:15%; text-align:center;">Berat (Kg)</th> 
				<th style="width:10%; text-align:center;">Harga</th> 
				<th style="width:15%; text-align:center;">Jumlah Berat (Kg)</th> 
				<th style="width:10%; text-align:center;">Jumlah Total</th> 
			</tr>		
		</thead> 
		
		<tbody> 
			
			<?php 
			$i = 0;
			foreach($detail as $isi){
			$i++;
			?>
					
			<tr> 
				<td style="text-align:center;"><?php echo $i; ?></td> 
				<td><?php echo $isi->kd_produk; ?></td> 
				<td><?php echo $isi->nama_produk; ?></td> 
				<td style="text-align:center;"><?php echo $isi->kuantitas; ?></td> 
				<td style="text-align:center;"><?php echo $isi->berat; ?></td> 
				<td style="text-align:center;"><?php echo number_format($isi->harga, 0, '.', '.'); ?></td> 
				<td style="text-align:center;"><?php echo $isi->jumlah_berat; ?></td> 
				<td style="text-align:center;"><?php echo number_format($isi->jumlah_harga, 0, '.', '.'); ?></td> 
			</tr> 
					
			<?php } ?>
				
			<tr>
				<td colspan="8"><br/><td> 
			</tr> 
						
			<tr> 
				<td colspan="3"><td> 
				<td colspan="2">Total SO<td> 
				<td style="text-align:left;"><?php echo number_format($master->total_harga, 0, '.', '.'); ?><td> 
			</tr> 
			<tr> 
				<td colspan="3"><td> 
				<td colspan="2">Total Diskon<td> 
				<td style="text-align:left;"><?php echo number_format($master->total_diskon, 0, '.', '.'); ?><td> 
			</tr> 
			<tr> 
				<td colspan="3"><td> 
				<td colspan="2">Total PPN<td> 
				<td style="text-align:left;"><?php echo number_format($master->total_ppn, 0, '.', '.'); ?><td> 
			</tr> 
			<tr> 
				<td colspan="3"><td> 
				<td colspan="2">Grand Total<td> 
				<td style="text-align:left;"><?php echo number_format($master->grand_total, 0, '.', '.'); ?><td> 
			</tr> 
		</tbody>
		</table>
		</td>
		</tr>
	</table> 
</body>

<script src="<?php echo base_url('assets/jquery.printPage.js');?>"></script>

<script type="text/javascript">
$(document).ready(function() {
	window.print();
});

</script>

</html>