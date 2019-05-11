<?php $this->load->view('include/header');?>
<?php $this->load->view('include/navbar');?>

<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="glyphicon glyphicon-folder-open"></i> SALES ORDER </h3>
				</div>
			</div>
            <!-- page start-->


        <button class="btn btn-success" onclick="location.href='<?php echo site_url('sales_order/form_so'); ?>'"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
        <button class="btn btn-success" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Segarkan</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" style="text-align:center" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nomor SO</th>
					<th>Tanggal</th>
					<th>Waktu</th>
					<th>Customer</th>
					<th>No. Kontak</th>
					<th>Alamat</th>
					<th>User</th>
					<th>Total Item</th>
					<th>Total SO</th>
					<th>Total Diskon</th>
					<th>PPN</th>
					<th>Grand Total</th>
					<th>Keterangan</th>
					<th>Bukti Pembayaran</th>
                    <th style="width:100px; text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('sales_order/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
			{ 
                "targets": [ -2 ], //last column
                "orderable": false, //set not orderable
            }
        ],

    });


    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

	$(".btnPrint").printPage();
	//window.print();
	
});


function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}


$(document).on('click', '#LihatDetailTransaksi', function(e){
		e.preventDefault();
		var total_so;
		var total_diskon;
		var total_ppn;
		var grand_total;
		
		$.ajax({
			url: "<?php echo site_url('sales_order/detail_so');?>",
			type: "POST",
			cache: false,
			data: { 
			nomor_so : $(this).text()
			},
			dataType:"json",
			success: function(data){
				//alert(data.no);
				console.log(data.detail);
				
				jQuery.each(data['master'], function(obj, values) {

				   console.log(obj, values);
				   //console.log(data['master'].nomor_so);
				   
				   $('#btnPrint').attr('onclick', 'window.open("<?php echo site_url('sales_order/get_invoice');?>/'+data['master'].id_order+'", "_blank")');
				
					$('#modal_form').modal('show'); // show bootstrap modal
					$('.modal-title').text('Rincian Sales Order No : '+data['master'].nomor_order); // Set Title to Bootstrap modal title
					$('#detail-body').empty();
					$('#detail-body').append('<table>');
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td style="width:120px;">Tanggal Order</td>');
					$('#detail-body').append('<td style="width:20px;">:</td>');
					$('#detail-body').append('<td style="width:200px;">'+data['master'].tanggal+'</td>');
					$('#detail-body').append('</tr>');
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td style="width:120px;">Nama Customer</td>');
					$('#detail-body').append('<td style="width:20px;">:</td>');
					$('#detail-body').append('<td style="width:200px;">'+data['master'].nama_lengkap+'</td>');
					$('#detail-body').append('</tr>');
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td>Alamat</td>');
					$('#detail-body').append('<td>: </td>');
					$('#detail-body').append('<td style="width:600px;">'+data['master'].alamat+'<br/>'+data['master'].nama_kecamatan+'<br/>'+data['master'].nama_kota_kab+'<br/>'+data['master'].nama_provinsi+'</td>');
					$('#detail-body').append('</tr>');
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td>Telp. / HP</td>');
					$('#detail-body').append('<td>: </td>');
					$('#detail-body').append('<td>'+data['master'].no_kontak+'</td>');
					$('#detail-body').append('</tr>');
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td>Keterangan</td>');
					$('#detail-body').append('<td>: </td>');
					if(data['master'].keterangan != ''){
						$('#detail-body').append('<td>'+data['master'].keterangan+'</td>');
					}else{
						$('#detail-body').append('<td>-</td>');
					}
					$('#detail-body').append('</tr>');	
					$('#detail-body').append('</table>');
					$('#detail-body').append('<hr/>');
					
					total_so = data['master'].total_harga;
					total_diskon = data['master'].total_diskon;
					total_ppn = data['master'].total_ppn;
					grand_total = data['master'].grand_total;
				
				});

					$('#detail-body').append('<table class="table table-bordered" style="margin-bottom: 0px; margin-top: 10px;" width="100%">');
					$('#detail-body').append('<thead>');
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<th style="width:120px; text-align:center;">No.</th>');
					$('#detail-body').append('<th style="width:170px;">Kode Produk</th>');
					$('#detail-body').append('<th style="width:400px;">Nama Produk</th>');
					$('#detail-body').append('<th style="width:100px; text-align:center;">Jumlah</th>');
					$('#detail-body').append('<th style="width:100px; text-align:center;">Berat (Kg)</th>');
					$('#detail-body').append('<th style="width:150px; text-align:center;">Harga</th>');
					$('#detail-body').append('<th style="width:200px; text-align:center;">Jumlah Berat (Kg)</th>');
					$('#detail-body').append('<th style="width:150px; text-align:center;">Jumlah Total</th>');
					$('#detail-body').append('</tr>');
					$('#detail-body').append('</thead>');
					$('#detail-body').append('<tbody>');
					
				$i = 0;
				
				jQuery.each(data['detail'], function(obj, values) {
				
					//console.log(obj, values);
					//console.log(data['detail'][obj].nama_produk);
					$i++
					
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td style="text-align:center;">'+$i+'</td>');
					$('#detail-body').append('<td>'+data['detail'][obj].kd_produk+'</td>');
					$('#detail-body').append('<td>'+data['detail'][obj].nama_produk+'</td>');
					$('#detail-body').append('<td style="text-align:center;">'+data['detail'][obj].kuantitas+'</td>');
					$('#detail-body').append('<td style="text-align:center;">'+data['detail'][obj].berat+'</td>');
					$('#detail-body').append('<td style="text-align:center;">'+to_rupiah(data['detail'][obj].harga)+'</td>');
					$('#detail-body').append('<td style="text-align:center;">'+data['detail'][obj].jumlah_berat+'</td>');
					$('#detail-body').append('<td style="text-align:center;">'+to_rupiah(data['detail'][obj].jumlah_harga)+'</td>');
					$('#detail-body').append('</tr>');
					
				});
				
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td colspan="8"><hr/><td>');
					$('#detail-body').append('</tr>');
						
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td colspan="4"><td>');
					$('#detail-body').append('<td>Total SO<td>');
					$('#detail-body').append('<td colspan="3" style="text-align:left;">'+to_rupiah(total_so)+'<td>');
					$('#detail-body').append('</tr>');
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td colspan="4"><td>');
					$('#detail-body').append('<td>Total Diskon<td>');
					$('#detail-body').append('<td colspan="3" style="text-align:left;">'+to_rupiah(total_diskon)+'<td>');
					$('#detail-body').append('</tr>');
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td colspan="4"><td>');
					$('#detail-body').append('<td>Total PPN<td>');
					$('#detail-body').append('<td colspan="3" style="text-align:left;">'+to_rupiah(total_ppn)+'<td>');
					$('#detail-body').append('</tr>');
					$('#detail-body').append('<tr>');
					$('#detail-body').append('<td colspan="4"><td>');
					$('#detail-body').append('<td>Grand Total<td>');
					$('#detail-body').append('<td colspan="3" style="text-align:left;">'+to_rupiah(grand_total)+'<td>');
				
					$('#detail-body').append('</tr>');
					$('#detail-body').append('</tbody>');
					$('#detail-body').append('</table>');
				
			}
		});
	});


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


function add_file_upload(nomor)
{
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
	$('#upload')[0].reset(); // reset form on modals
    $('#modal_upload').modal('show'); // show bootstrap modal
    $('.modal_upload_title').text(nomor); // Set Title to Bootstrap modal title
	$('#nomor').val(nomor);
}


function save()
{
	$('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
	
    $('#btnSave').text('Menyimpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 

    // ajax adding data to database
    var formData = new FormData($('#upload')[0]);
    $.ajax({
        url : "<?php echo site_url('sales_order/add_order_confirmation')?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
				//console.log(data);
                $('#modal_upload').modal('hide');
                alert('Berhasil upload bukti pembayaran');
				reload_table();

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
            alert('Error adding / update data');
            $('#btnSave').text('Menyimpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}


function cancel_order(nomor_so)
{
    if(confirm('Apakah kamu yakin akan membatalkan order?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('sales_order/cancel_so')?>",
            type: "POST",
			data: { 
			nomor : nomor_so
			},
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
				alert('Berhasil membatalkan pesanan');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Rincian SO</h3>
            </div>
            <div id="detail-body" class="modal-body form">
                
				
            </div>
            <div class="modal-footer">
                <button type="button" id="btnPrint" class="btn btn-primary">Print</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

	<!-- Bootstrap modal -->
	<div class="modal fade" id="modal_upload" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal_upload_title">Upload Bukti Pembayaran</h3>
				</div>
				<div class="modal-body form">
					<form action="#" id="upload" class="form-horizontal">
						<input type="hidden" value="" name="nomor" id="nomor"/> 
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">Pilih Bank</label>
								<div class="col-md-9">
									<?php 
										echo form_dropdown("id_Bank", $option_bank, '' ,'id="id_Bank" class="form-control" name="id_Bank"'); //name(string), option value(array), selected(array), extra(mixed)  --selectednya dikosongkan
									?>
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">No. Rekening</label>
								<div class="col-md-9">
									<input name="no_Rekening" placeholder="Masukkan Nomor Rekening" class="form-control" type="text">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-3">Bukti Pembayaran</label>
								<div class="col-md-9">
									<input name="bukti_bayar" type="file">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
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