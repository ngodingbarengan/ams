<?php $this->load->view('include/header');?>
<?php $this->load->view('include/navbar');?>

<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="glyphicon glyphicon-folder-open"></i> FORM PURCHASE ORDER</h3>
				</div>
			</div>
            <!-- page start-->


<div class="panel panel-default">


			<div class="col-xs-6" style="padding-top:20px">
				<div class="modal-body form">
					<form action="#" id="form_PO" class="form-horizontal">
						<input type="hidden" value="" name="id"/>
						<input type="hidden" name="nilai_total_harga" id="nilai_total_harga" value="<?php echo $this->purchase_order->total();?>"/>
						<input type="hidden" name="nilai_ppn" id="nilai_ppn" value="0"/>
						<input type="hidden" name="nilai_grand_total" id="nilai_grand_total" value="<?php echo $this->purchase_order->total();?>"/>
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">Nomor PO</label>
								<div class="col-md-9">
									<input name="nomor_PO" id="nomor_PO" placeholder="Masukkan Nomor Purchase Order" class="form-control" type="text">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">Tanggal	</label>
								<div class="col-md-9">
									<input name="tgl_PO" id="tgl_PO" placeholder="yyyy-mm-dd" class="form-control" type="text" readonly="readonly">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">Supplier</label>
								<div class="col-md-9">
									<?php 
									echo form_dropdown("id_Supplier", $option_supplier, '' ,'id="id_Supplier" class="form-control" name="id_Supplier"'); //name(string), option value(array), selected(array), extra(mixed)  --selectednya dikosongkan
									?>
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">Diajukan Oleh</label>
								<div class="col-md-9">
									<input value="<?php echo $this->session->userdata('nama_user');?>" placeholder="Diajukan Oleh" class="form-control" type="text" readonly="readonly">
									<input name="User" id="User" type="hidden" value="<?php echo $this->session->userdata('id_user');?>">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						
				</div>
			</div>
			<div class="col-xs-6 pull-right" style="padding-bottom:20px">
				<div class="modal-body form">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label col-md-12">Keterangan (optional) :</label>
							<div class="col-md-12">
								<textarea name="Keterangan" id="Keterangan" placeholder="Tambahkan Keterangan Tambahan Bila Ada" class="form-control" style="height: 130px;"></textarea>
								<span class="help-block"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
	  <div class="panel-body" style="padding:0px">
	  <table class="table table-striped table-bordered" style="margin:0px">
		<thead>
			<tr>
				<th style="text-align:center">Kode Produk</th>
				<th style="text-align:center">Nama</th>
				<th style="text-align:center">Qty</th>
				<th style="text-align:center">Item Price</th>
				<th style="text-align:center">Sub-Total</th>
				<th style="text-align:center">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
					
			<?php foreach ($this->purchase_order->contents() as $items): ?>
			
			<?php echo form_hidden('id', $items['rowid']); ?>
			
		
			<tr>
				<td class="text-center"><?php echo $items['code']; ?></td>
				<td class="text-center"><?php echo $items['name']; ?></td>
				<td class="text-center"><input type="number" id="jumlah<?php echo $i; ?>" name="jumlah<?php echo $i; ?>" class="form-control text-center" value="<?php echo $items['qty']; ?>"></td>
				<td class="text-center">Rp. <?php echo number_format($items['price'], 0, '.', '.'); ?></td>
				<td class="text-center">Rp. <?php echo number_format($items['subtotal'], 0, '.', '.'); ?></td>
				<td class="text-center">
					<button type="button" class="btn btn-xs btn-default" onclick="update_item('<?php echo $items['rowid'];?>', 'jumlah<?php echo $i; ?>')">
						<span class="glyphicon glyphicon-refresh"> </span>
					</button>
					<button type="button" class="btn btn-xs btn-default" onclick="delete_item('<?php echo $items['rowid'];?>')">
						<span class="glyphicon glyphicon-trash"> </span>
					</button>
				</td>   
			</tr>
			
			<?php $i++; ?>
 
			<?php endforeach; ?>
			
			<tr>
				<td colspan="6" class="text-center">		
					<button type="button" class="btn-success btn-md" onclick="add_item()" data-toggle="tooltip" data-placement="top" data-original-title="Add">
					<span class="glyphicon glyphicon-plus"></span> Tambahkan Item
					</button>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4" class="text-right"><label class="control-label">Total Harga (Rp.)</label></td>
				<td colspan="2" class=""><strong>Rp. <?php echo number_format($this->purchase_order->total(), 0, '.', '.'); ?></strong></td>
			</tr>	
			<tr>
				<td colspan="4" class="text-right"><label class="control-label"><input type="checkbox" value="0"onchange="ppn()"> PPN (Rp.)</label></td>
				<td colspan="2" class="" id="total_ppn"></td>
			</tr>
			<tr>
				<td colspan="4" class="text-right"><h4><label class="control-label">Grand Total (Rp.)</label></h4></td>
				<td colspan="2" class="" id="grand_total"><h4><strong>Rp. <?php echo number_format($this->purchase_order->total(), 0, '.', '.'); ?></strong></h4></td>
			</tr>
		</tfoot>
	</table>

		<div class="col-md-12">
			<div class="modal-body form pull-right">
				<button type="button" id="btnSavePO" onclick="save_PO()" class="btn-success btn-lg">
					<span class="glyphicon glyphicon-floppy-disk"></span>  Simpan PO
				</button>
			</div>
		</div>
	</form>
	</div> 
</div>


<script type="text/javascript">

$(document).ready(function() {
	
	var date = new Date();
	var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
	
	//datepicker
    $('#tgl_PO').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
	
	$('#tgl_PO').datepicker('setDate', today);
});


  $( function() {
    var availableTags = [
		<?php
			foreach ($produk as $row)
			{
			echo "{value: '".$row->kd_produk."', label: '".$row->kd_produk." ( ".$row->nama_produk." )'},";
			}
		?>
		//{value: "foo", label: "label1"},
		//{value: "foo2", label: "label2" },
		//{value: "foo3", label: "label3"}
    ];
    $( "#kd_Produk" ).autocomplete({
      source: availableTags,
	  select: 	
			function(event, ui) {
                $.ajax({
					url: "<?php echo site_url('purchase_order/cek');?>",
					type: "POST",
					dataType: "JSON",
					data: 'keyword='+ui.item.value,
					success: function (data) 
					{
						console.log(data);
						$("#Id").val(data.id_produk);
						$("#kd_Produk").val(ui.item.value);
						$("#harga_Jual").val(to_rupiah(data.harga));
						$("#Jumlah").val(1);
						$("#id").val(data.id_produk);
						$("#nama_Produk").val(data.nama_produk);
					},
					error: function (jqxhr, textStatus, error) 
					{
						//var err = textStatus + ", " + error;
						//console.log( "Request Failed: " + err );
						alert('Error get data from ajax');
					}
					});
            }
    });
  }); 
 

function save_PO()
{
	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	
	// ajax adding data to database
    var formData = new FormData($("#form_PO")[0]);
	//var formData = $('#form_item').serialize();
	console.log(formData);
    $.ajax({
        url : "<?php echo site_url('purchase_order/add_PO');?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                //$('#modal_form').modal('hide');
				//location.reload();
				console.log(data);
				alert('berhasil menambahkan PO');
				window.location.replace("<?php echo site_url('purchase_order/index');?>");
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            //alert('Error adding / update data');
			console.log( "Request failed: " +textStatus+ " " +errorThrown );
            $('#btnSave').text('Menyimpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}
 
 
function add_item()
{
    $('#form_item')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Item'); // Set Title to Bootstrap modal title
}

/*
$("#nomor_PO").keyup(function(){
	$nomor_PO = $('#nomor_PO').val();
	$('#value_nomor_PO').val($nomor_PO);
});
*/

function save_item()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
	
    // ajax adding data to database
    var formData = new FormData($("#form_item")[0]);
	
	//var formData = $('#form_item').serialize();
	console.log(formData);
    $.ajax({
        url : "<?php echo site_url('purchase_order/add_po_item');?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
				//location.reload();
				console.log(data);
				window.location.replace("<?php echo site_url('purchase_order/form_po');?>");				
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Menyimpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            //alert('Error adding / update data');
			console.log( "Request failed: " +textStatus+ " " +errorThrown );
            $('#btnSave').text('Menyimpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function update_item(id,jlh)
{
    var jumlah = document.getElementById(jlh);
	//alert(id);
	//alert(jumlah.value);
	
	//Kirim data via ajax untuk update data
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('purchase_order/update_po_item');?>",
		data: { 
			id_item : id, 
			jumlah_item: jumlah.value
		},
		success: function(){
			//alert('wow' + msg);
			//location.reload();
			window.location.replace("<?php echo site_url('purchase_order/form_po');?>");
		}
	});
}
	
function delete_item(id)
{
	//alert(id);
	//Kirim data via ajax untuk delete data
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('purchase_order/remove_po_item');?>",
		data: { 
			id_item : id
		},
		success: function(){
			//location.reload();
			window.location.replace("<?php echo site_url('purchase_order/form_po');?>");
		}
	});
}

/*
$(".ppn").change(function() {
    if(this.checked) {
        <?php 
		$ppn = 0.1*$this->purchase_order->total();
		echo '("#total_ppn").append("Rp. '.number_format($ppn, 0, '.', '.').'");'; 
		?>
    }
});*/

function ppn()
{
	if ($('#total_ppn').is(':empty')){
	<?php 
		$total = $this->purchase_order->total();
		$ppn = 0.1*$total;
		$grand_total = $ppn+$total;
		echo '$("#total_ppn").append("<strong>Rp. '.number_format($ppn, 0, '.', '.').'</strong>");';
		echo '$("#grand_total").empty();';
		echo '$("#grand_total").append("<h4><strong>Rp. '.number_format($grand_total, 0, '.', '.').'</strong></h4>");'; 
		echo '$("#nilai_ppn").val('.$ppn.');';
		echo '$("#nilai_grand_total").val('.$grand_total.');';
	?>
	}else{
	<?php
		$grand_total = $this->purchase_order->total();
		echo '$("#total_ppn").empty();';
		echo '$("#grand_total").empty();';
		echo '$("#grand_total").append("<h4><strong>Rp. '.number_format($grand_total, 0, '.', '.').'</strong></h4>");'; 
		echo '$("#nilai_ppn").val(0);';
		echo '$("#nilai_grand_total").val('.$grand_total.');';
	?>
	}
}

function to_rupiah(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('');
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Tambah Item</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_item" class="form-horizontal">
                    <input type="hidden" name="Id" id="Id">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Masukkan Kode / Nama Produk</label>
                            <div class="col-md-9">
                                <input name="kd_Produk" id="kd_Produk" placeholder="Kode Produk / Nama Produk" class="form-control" type="text">
                                <span class="help-block"></span>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Nama Produk</label>
                            <div class="col-md-9">
                                <input name="nama_Produk" id="nama_Produk" class="form-control text-left" type="text" readonly="readonly">
                                <span class="help-block"></span>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Harga Jual <br/>Saat ini</label>
                            <div class="col-md-9">
                                <input name="Harga_Jual" id="harga_Jual" class="form-control text-left" type="text" readonly="readonly">
                                <span class="help-block"></span>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Harga (Rp.)</label>
                            <div class="col-md-9">
                                <input name="Harga" id="Harga" placeholder="Masukkan Harga Beli" class="form-control text-left" type="text">
                                <span class="help-block"></span>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Jumlah Item</label>
                            <div class="col-md-9">
                                <input name="Jumlah" id="Jumlah" placeholder="Tentukan Jumlah Item" class="form-control text-left" type="number">
                                <span class="help-block"></span>
							</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save_item()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

</section>
		<!-- page end--> <!-- class="wrapper" -->
	</section>
	<!--main content end-->
</section>
<!-- container section end -->
   
<?php $this->load->view('include/footer');?>