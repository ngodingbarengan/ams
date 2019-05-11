<?php $this->load->view('include/header');?>
<?php $this->load->view('include/navbar');?>

<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="glyphicon glyphicon-folder-open"></i> FORM SALES ORDER</h3>
				</div>
			</div>
            <!-- page start-->

<div class="panel panel-default">

        <div class="col-xs-6" style="padding-top:20px">
			<div class="modal-body form">
                <form action="#" id="form_SO" class="form-horizontal">
					<input type="hidden" value="" name="id"/>
					<input type="hidden" name="nilai_total_harga" id="nilai_total_harga" value="<?php echo $this->sales_order->total();?>"/>
					<input type="hidden" name="nilai_ppn" id="nilai_ppn" value="0"/>
					<input type="hidden" name="nilai_diskon" id="nilai_diskon" value="0"/>
					<input type="hidden" name="nilai_grand_total" id="nilai_grand_total" value="<?php echo $this->sales_order->total();?>"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nomor SO</label>
                            <div class="col-md-9">
                                <input name="nomor_SO" id="nomor_SO" placeholder="Masukkan Nomor Sales Order" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
					<div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal	</label>
                            <div class="col-md-9">
                                <input name="tgl_SO" id="tgl_SO" placeholder="yyyy-mm-dd" class="form-control" type="text" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
					<div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer</label>
                            <div class="col-md-9">
                                <?php 
									echo form_dropdown("id_Customer", $option_customer, '' ,'id="id_Customer" class="form-control" name="id_Customer"'); //name(string), option value(array), selected(array), extra(mixed)  --selectednya dikosongkan
									?>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
					<div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Salesman</label>
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
				<th style="text-align:center">Weight</th>
				<th style="text-align:center">Sub-Weight</th>
				<th style="text-align:center">Item Price</th>
				<th style="text-align:center">Sub-Total</th>
				<th style="text-align:center">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
					
			<?php foreach ($this->sales_order->contents() as $items): ?>
			
			<?php echo form_hidden('id', $items['rowid']); ?>
			
			<tr>
				<td class="text-center"><?php echo $items['code']; ?></td>
				<td class="text-center"><?php echo $items['name']; ?></td>
				<td class="text-center"><input type="number" id="jumlah<?php echo $i; ?>" name="jumlah<?php echo $i; ?>" class="form-control text-center" value="<?php echo $items['qty']; ?>"></td>
				<td class="text-center"><?php echo $items['weight']; ?></td>
				<td class="text-center"><?php echo number_format($items['subweight'], 3, ',', '.'); ?> Kg</td>
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
				<td colspan="8" class="text-center">		
					<button type="button" class="btn-success btn-md" onclick="add_item()" data-toggle="tooltip" data-placement="top" data-original-title="Add">
					<span class="glyphicon glyphicon-plus"></span> Tambahkan Item
					</button>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6" class="text-right"><label class="control-label">Total Harga</label></td>
				<td colspan="2" class=""><strong>Rp. <?php echo number_format($this->sales_order->total(), 0, '.', '.'); ?></strong></td>
			</tr>
			<tr>
				<td colspan="6" class="text-right">
				<div class="col-md-9 form-group">
					<label class="control-label col-md-4">Tambahkan Diskon</label>
					<div class="col-md-3">
						<input name="diskon" id="diskon" placeholder="Diskon" class="form-control text-center" type="number" value="0" onchange="hitung_diskon()">
						<span class="help-block"></span>
					</div>
					<label class="control-label col-md-1 text-left">%</label>
					<div class="col-md-3">
						<label class="control-label text-left" id="total_diskon"></label>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="col-md-3 pull-right"></div>
					<label class="control-label">Total Setelah Diskon</label>
				</div>
				</td>
				<td colspan="2" class="" id="total_setelah_diskon"></td>
			</tr>	
			<tr>
				<td colspan="6" class="text-right"><label class="control-label"><input id="ppn" type="checkbox" onchange="hitung_ppn()" value="0"> PPN</label></td>
				<td colspan="2" class="" id="total_ppn"></td>
			</tr>
			<tr>
				<td colspan="6" class="text-right"><h4><label class="control-label">Grand Total</label></h4></td>
				<td colspan="2" class="" id="grand_total"><h4><strong>Rp. <?php echo number_format($this->sales_order->total(), 0, '.', '.'); ?></strong></h4></td>
			</tr>
		</tfoot>
	</table>

	<div class="col-md-12">
        <div class="modal-body form pull-right">
			<button type="button" id="btnSaveSO" onclick="save_SO()" class="btn-success btn-lg">
					<span class="glyphicon glyphicon-floppy-disk"></span>  Simpan SO
			</button>
        </div>
    </form>
	</div>
</div>


<script type="text/javascript">

var save_method; //for save method string

$(document).ready(function() {
	
	var date = new Date();
	var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
	
	//datepicker
    $('#tgl_SO').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
	
	$('#tgl_SO').datepicker('setDate', today);
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
					url: "<?php echo site_url('sales_order/cek');?>",
					type: "POST",
					dataType: "JSON",
					data: 'keyword='+ui.item.value,
					success: function (data) 
					{
						console.log(data);
						$("#Id").val(data.id_produk);
						$("#kd_Produk").val(ui.item.value);
						$("#Jumlah").val(1);
						$("#id").val(data.id_produk);
						$("#nama_Produk").val(data.nama_produk);
						$("#Harga").val(data.harga); 
						$("#Berat").val(data.berat);
						$("#Stok").val(data.stok);
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

function save_SO()
{
    // ajax adding data to database
	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	 
    var formData = new FormData($("#form_SO")[0]);
	//var formData = $('#form_item').serialize();
	console.log(formData);
    $.ajax({
        url : "<?php echo site_url('sales_order/add_SO');?>",
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
				alert('Berhasil menambahkan SO. Silahkan upload invoice ');
				window.location.replace("<?php echo site_url('sales_order/index');?>");
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
    save_method = 'add';
    $('#form_item')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Item'); // Set Title to Bootstrap modal title
}


function save_item()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('sales_order/add_so_item');?>";
    } else {
        url = "<?php echo site_url('sales_order/update_so_item');?>";
    }

    // ajax adding data to database
    var formData = new FormData($("#form_item")[0]);
	//var formData = $('#form_item').serialize();
	console.log(formData);
    $.ajax({
        url : url,
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
				//console.log(data);
				window.location.replace("<?php echo site_url('sales_order/form_so');?>");
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
		url: "<?php echo site_url('sales_order/update_so_item');?>",
		data: { 
			id_item : id, 
			jumlah_item: jumlah.value
		},
		success: function(){
			//alert('wow' + msg);
			//location.reload();
			window.location.replace("<?php echo site_url('sales_order/form_so');?>")
		}
	});
}
	
function delete_item(id)
{
	//alert(id);
	//Kirim data via ajax untuk delete data
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('sales_order/remove_so_item');?>",
		data: { 
			id_item : id
		},
		success: function(){
			//location.reload();
			window.location.replace("<?php echo site_url('sales_order/form_so');?>");
		}
	});
}


function hitung_diskon()
{
	var total_harga = <?php echo $this->sales_order->total(); ?>;
	var diskon = $("#diskon").val();
	var jumlah_diskon;

	//alert(diskon);

	jumlah_diskon = (diskon/100)*<?php echo $this->sales_order->total(); ?>;
	$("#total_diskon").html("<strong>"+to_rupiah(jumlah_diskon)+"</strong>");
	$("#nilai_diskon").val(jumlah_diskon);
	
	total_setelah_diskon = total_harga-jumlah_diskon;
	$("#total_setelah_diskon").html("<strong>"+to_rupiah(total_setelah_diskon)+"</strong>");
	$("#nilai_grand_total").val(total_setelah_diskon);
	
	$("#grand_total").empty();
	$("#grand_total").append("<h4><strong>"+to_rupiah(total_setelah_diskon)+"</strong></h4>");
	
	//$("#total_ppn").empty();
	
	return total_setelah_diskon;
	
	/*
	if($('#ppn').attr('checked', true))
	{
		//$('#ppn').attr('checked', false);
		$("#total_ppn").empty();
		//hitung_ppn();
	}*/
	//total_setelah_diskon_global = total_setelah_diskon;
	//alert(total_setelah_diskon_global);
}

//alert(hitung_diskon());
//merubah jadi variabel global
//var hasil = hitung_diskon();
//alert(hasil);


function hitung_ppn()
{
	//alert(hitung_diskon());
	$total_setelah_diskon_global = hitung_diskon();
	//alert($total_setelah_diskon_global);
	
	if ($('#total_ppn').is(':empty')){
		
		$ppn = 0.1*$total_setelah_diskon_global;
		$grand_total = $ppn+$total_setelah_diskon_global;
		
		$("#total_ppn").append("<strong>"+to_rupiah($ppn)+"</strong>");
		$("#grand_total").empty();
		$("#grand_total").append("<h4><strong>"+to_rupiah($grand_total)+"</strong></h4>");
		$("#nilai_ppn").val($ppn);
		$("#nilai_grand_total").val($grand_total);
		
	}else{
		$grand_total = $total_setelah_diskon_global;
		
		$('#ppn').attr('checked', false);
		$("#total_ppn").empty();

		$("#grand_total").empty();
		$("#grand_total").append("<h4><strong>"+to_rupiah($grand_total)+"</strong></h4>");
		$("#nilai_ppn").val(0);
		$("#nilai_grand_total").val($grand_total);
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


$("#Jumlah").keypress(function( event ){
	var key = event.which;
			
	if( ! ( key >= 48 && key <= 57 ) )
		event.preventDefault();
});

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
                            <label class="control-label col-md-3">Jumlah Item</label>
                            <div class="col-md-9">
                                <input name="Jumlah" id="Jumlah" placeholder="Tentukan Jumlah Item" class="form-control text-left" type="number">
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
                            <label class="control-label col-md-3">Harga (Rp.)</label>
                            <div class="col-md-9">
                                <input name="Harga" id="Harga" class="form-control text-left" type="number" readonly="readonly">
                                <span class="help-block"></span>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Berat (Kg)</label>
                            <div class="col-md-9">
                                <input name="Berat" id="Berat" class="form-control text-left" type="number" readonly="readonly">
                                <span class="help-block"></span>
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Stok Tersedia</label>
                            <div class="col-md-9">
                                <input name="Stok" id="Stok" class="form-control text-left" type="number" readonly="readonly">
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
