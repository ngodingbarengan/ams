<?php $this->load->view('include/header');?>
<?php $this->load->view('include/navbar');?>

<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="glyphicon glyphicon-folder-open"></i> APPROVAL CUSTOMER ORDER</h3>
				</div>
			</div>
            <!-- page start-->

        <table id="table" class="table table-striped table-bordered" style="text-align:center" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nomor Order</th>
					<th>Tanggal</th>
					<th>Waktu</th>
					<th>Nama Penerima</th>
					<th>No. Kontak</th>
					<th>Alamat</th>
					<th>User</th>
					<th>Total Item</th>
					<th>Total Harga</th>
					<th>Ongkir</th>
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
            "url": "<?php echo site_url('approval/ajax_list_co')?>",
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

});


function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

$(document).on('click', '#LihatDetailTransaksi', function(e){
		e.preventDefault();
		var total_co;
		var total_diskon;
		var total_ongkir;
		var grand_total;
		
		$.ajax({
			url: "<?php echo site_url('approval/detail_co');?>",
			type: "POST",
			cache: false,
			data: { 
			nomor_co : $(this).text()
			},
			dataType:"json",
			success: function(data){
				//alert(data.no);
				console.log(data.detail);
				
				jQuery.each(data['master'], function(obj, values) {

				   console.log(obj, values);
				   //console.log(data['master'].nomor_so);
				
					$('#modal_form').modal('show'); // show bootstrap modal
					$('.modal-title').text('Rincian Order No : '+data['master'].nomor_order); // Set Title to Bootstrap modal title
					$('.modal-body').empty();
					$('.modal-body').append('<table>');
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td style="width:120px;">Tanggal Order</td>');
					$('.modal-body').append('<td style="width:20px;">:</td>');
					$('.modal-body').append('<td style="width:200px;">'+data['master'].tanggal+'</td>');
					$('.modal-body').append('</tr>');
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td style="width:120px;">Nama Penerima</td>');
					$('.modal-body').append('<td style="width:20px;">:</td>');
					$('.modal-body').append('<td style="width:200px;">'+data['master'].nama_lengkap+'</td>');
					$('.modal-body').append('</tr>');
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td>Alamat</td>');
					$('.modal-body').append('<td>: </td>');
					$('.modal-body').append('<td style="width:600px;">'+data['master'].alamat+'<br/>'+data['master'].nama_kecamatan+'<br/>'+data['master'].nama_kota_kab+'<br/>'+data['master'].nama_provinsi+'</td>');
					$('.modal-body').append('</tr>');
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td>Telp. / HP</td>');
					$('.modal-body').append('<td>: </td>');
					$('.modal-body').append('<td>'+data['master'].no_kontak+'</td>');
					$('.modal-body').append('</tr>');
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td>Keterangan</td>');
					$('.modal-body').append('<td>: </td>');
					if(data['master'].keterangan != ''){
						$('.modal-body').append('<td>'+data['master'].keterangan+'</td>');
					}else{
						$('.modal-body').append('<td>-</td>');
					}
					$('.modal-body').append('</tr>');	
					$('.modal-body').append('</table>');
					$('.modal-body').append('<hr/>');
					
					total_co = data['master'].total_harga;
					total_diskon = data['master'].total_diskon;
					total_ongkir = data['master'].ongkir;
					grand_total = data['master'].grand_total;
				
				});

					$('.modal-body').append('<table class="table table-bordered" style="margin-bottom: 0px; margin-top: 10px;" width="100%">');
					$('.modal-body').append('<thead>');
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<th style="width:120px; text-align:center;">No.</th>');
					$('.modal-body').append('<th style="width:170px;">Kode Produk</th>');
					$('.modal-body').append('<th style="width:400px;">Nama Produk</th>');
					$('.modal-body').append('<th style="width:100px; text-align:center;">Jumlah</th>');
					$('.modal-body').append('<th style="width:100px; text-align:center;">Berat (Kg)</th>');
					$('.modal-body').append('<th style="width:150px; text-align:center;">Harga</th>');
					$('.modal-body').append('<th style="width:200px; text-align:center;">Jumlah Berat (Kg)</th>');
					$('.modal-body').append('<th style="width:150px; text-align:center;">Jumlah Total</th>');
					$('.modal-body').append('</tr>');
					$('.modal-body').append('</thead>');
					$('.modal-body').append('<tbody>');
					
				$i = 0;
				
				jQuery.each(data['detail'], function(obj, values) {
				
					//console.log(obj, values);
					//console.log(data['detail'][obj].nama_produk);
					$i++
					
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td style="text-align:center;">'+$i+'</td>');
					$('.modal-body').append('<td>'+data['detail'][obj].kd_produk+'</td>');
					$('.modal-body').append('<td>'+data['detail'][obj].nama_produk+'</td>');
					$('.modal-body').append('<td style="text-align:center;">'+data['detail'][obj].kuantitas+'</td>');
					$('.modal-body').append('<td style="text-align:center;">'+data['detail'][obj].berat+'</td>');
					$('.modal-body').append('<td style="text-align:center;">'+to_rupiah(data['detail'][obj].harga)+'</td>');
					$('.modal-body').append('<td style="text-align:center;">'+data['detail'][obj].jumlah_berat+'</td>');
					$('.modal-body').append('<td style="text-align:center;">'+to_rupiah(data['detail'][obj].jumlah_harga)+'</td>');
					$('.modal-body').append('</tr>');
					
				});
				
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td colspan="8"><hr/><td>');
					$('.modal-body').append('</tr>');
						
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td colspan="4"><td>');
					$('.modal-body').append('<td>Total Order<td>');
					$('.modal-body').append('<td colspan="3" style="text-align:left;">'+to_rupiah(total_co)+'<td>');
					$('.modal-body').append('</tr>');
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td colspan="4"><td>');
					$('.modal-body').append('<td>Total Diskon<td>');
					$('.modal-body').append('<td colspan="3" style="text-align:left;">'+to_rupiah(total_diskon)+'<td>');
					$('.modal-body').append('</tr>');
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td colspan="4"><td>');
					$('.modal-body').append('<td>Ongkos Kirim<td>');
					$('.modal-body').append('<td colspan="3" style="text-align:left;">'+to_rupiah(total_ongkir)+'<td>');
					$('.modal-body').append('</tr>');
					$('.modal-body').append('<tr>');
					$('.modal-body').append('<td colspan="4"><td>');
					$('.modal-body').append('<td>Grand Total<td>');
					$('.modal-body').append('<td colspan="3" style="text-align:left;">'+to_rupiah(grand_total)+'<td>');
				
					$('.modal-body').append('</tr>');
					$('.modal-body').append('</tbody>');
					$('.modal-body').append('</table>');
				
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


function approve_order(nomor_co)
{
	//alert(nomor_co);

	// ajax delete data to database
    $.ajax({
        url : "<?php echo site_url('approval/approve_co')?>/",
        type: "POST",
		data: { 
			nomor : nomor_co
			},
        dataType: "JSON",
        success: function(data)
        {
            //if success reload ajax table
            //console.log(data);
            alert('Order Approved !');
			reload_table();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error deleting data');
        }
    });
}


function cancel_order(nomor_co)
{
    if(confirm('Apakah kamu yakin akan membatalkan order?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('approval/cancel_co')?>",
            type: "POST",
			data: { 
			nomor : nomor_co
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
                <h3 class="modal-title">Rincian PO</h3>
            </div>
            <div class="modal-body form">
                
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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