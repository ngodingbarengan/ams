<?php $this->load->view('include/header');?>
<?php $this->load->view('include/navbar');?>


<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="glyphicon glyphicon-folder-open"></i>DATA CUSTOMER</h3>
				</div>
			</div>
        
		<!-- page start-->
        <button class="btn btn-success" onclick="add_data()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
        <button class="btn btn-success" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Segarkan</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" style="text-align:center" cellspacing="0" width="100%">
            <thead>
                <tr>
					<th>Kode Customer</th>
					<th>Nama</th>
					<th>No. Kontak</th>
					<th>Alamat</th>
					<th>ID_Prov</th>
					<th>Provinsi</th>
					<th>ID_Kota</th>
					<th>Kota / Kabupaten</th>
					<th>ID_kec</th>
					<th>Kecamatan</th>
                    <th style="width:150px; text-align:center">Aksi</th>
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
            "url": "<?php echo site_url('customer/ajax_list')?>",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
			{
				"targets": [ -1 ], //last column start from [0]
                "orderable": false, //set not orderable
			},
			{
				"targets": [ 2 ], //last column start from [0]
                "orderable": false, //set not orderable
			},
			{
				"targets": [ 3 ], //last column start from [0]
                "orderable": false, //set not orderable
			},
			{ 
                "targets": [ 4 ], //hide ID provinsi
                "visible": false,
            },
			{ 
                "targets": [ 6 ], //hide ID kota kabupaten
                "visible": false,
            },
			{ 
                "targets": [ 8 ], //hide ID kota kabupaten
                "visible": false,
            },	
        ],
		error: function(jqXHR, textStatus, ex) {
		console.log(textStatus + "," + ex + "," + jqXHR.responseText);
		}
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


//$("#id_Provinsi").change(function(){
function selected(){
	var selectProvinsi = $("#id_Provinsi").val();
	    		
	if (selectProvinsi > 0){
					
	//console.log($("#id_Provinsi").val());
					
	$.ajax({
		type: "POST",
		url : "<?php echo site_url('customer/list_kota')?>/" + selectProvinsi,
		data: selectProvinsi,
		dataType: "JSON",
		success: function(data)
		{	
			//alert('berhasil');						
			//console.log(data);
		
			$('[name="id_KotaKab"]').empty();
			$('[name="id_KotaKab"]').append('<option value="0">-Pilih Kota-</option>');
			$('[name="id_Kecamatan"]').empty();
			$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kecamatan-</option>');
			
			$.each(data, function(i, item){
				$('[name="id_KotaKab"]').append('<option value="'+ data[i].id_kota_kab +'">'+ data[i].nama_kota_kab +'</option>');
			});
			
			$('[name="id_KotaKab"]').on('change', function() {
			//alert( this.value );
			var selectKotaKab = this.value;
			//alert( selectKotaKab );
			
			if (selectKotaKab > 0){
				$.ajax({
					type: "POST",
					url : "<?php echo site_url('customer/list_kecamatan')?>/" +selectKotaKab,
					//data: selectKotaKab,
					dataType: "JSON",
					success: function(data)
					{	
						//alert('berhasil');						
						//console.log(data); berhasil
						
						//$('[name="id_Kecamatan"]')
						
						$('[name="id_Kecamatan"]').empty();
						$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kecamatan-</option>');
						$.each(data, function(i, item){
							$('[name="id_Kecamatan"]').append('<option value="'+ data[i].id_kecamatan +'">'+ data[i].nama_kecamatan +'</option>');
												
						}); //*/
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert('Error get data from ajax');
					}
				});
				}else{
					$('[name="id_Kecamatan"]').empty();
					$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kota/Kabupaten Lebih Dahulu-</option>');
				} //*/
			})	
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Error get data from ajax');
		}
	});
	}else{
		$('[name="id_KotaKab"]').empty();
		$('[name="id_KotaKab"]').append('<option value="0">-Pilih Kota-</option>');
		$('[name="id_Kecamatan"]').empty();
		$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kecamatan-</option>');
	}
	
}


function add_data()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
	$('#id_KotaKab').empty();
	$('[name="id_KotaKab"]').empty();
	$('[name="id_KotaKab"]').append('<option value="0">-Pilih Kota-</option>');
	$('[name="id_Kecamatan"]').empty();
	$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kecamatan-</option>');
	$('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Customer'); // Set Title to Bootstrap modal title
}

function edit_data(id_customer)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('customer/ajax_edit')?>/"+id_customer,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {	
		
            $('[name="id"]').val(data.id_member);
			$('[name="kd_Customer"]').val(data.kd_member);
			$('[name="nama_Customer"]').val(data.nama_lengkap);
			$('[name="no_Kontak"]').val(data.no_kontak);
			$('[name="alamat_Customer"]').val(data.alamat);
			$('[name="id_Provinsi"]').val(data.id_provinsi);
			$('[name="id_KotaKab"]').val(data.id_kota_kab);
			$('[name="id_Kecamatan"]').val(data.id_kecamatan);
			
			var selectProvinsi = data.id_provinsi;
			var selectKotaKab = data.id_kota_kab;
			var selectKecamatan = data.id_kecamatan;
			
			//tampil pilihan data kota yang dipilih di database dan option pilihan sesuai provinsi yang dipilih
			$.ajax({
				url : "<?php echo site_url('customer/list_kota')?>/"+selectProvinsi,
				type: "GET",
				dataType: "JSON",
				data: selectProvinsi,
				success: function(data)
				{
					//console.log(data);
					
					$('[name="id_KotaKab"]').empty();
					
					$.each(data, function(i, item){
						$('[name="id_KotaKab"]').append('<option value="'+ data[i].id_kota_kab +'">'+ data[i].nama_kota_kab +'</option>');				
					});
					$('[name="id_KotaKab"]').val(selectKotaKab);
					
					
					$('[name="id_KotaKab"]').on('change', function(){
						selectKotaKab = this.value;
						
						$.ajax({
							url	: "<?php echo site_url('customer/list_kecamatan')?>/"+selectKotaKab,
							type: "POST",
							dataType: "JSON",
							data: selectKotaKab,
							success: function(data)
							{
								$('[name="id_Kecamatan"]').empty();
								$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kecamatan-</option>');
												
								$.each(data, function(i, item){
									$('[name="id_Kecamatan"]').append('<option value="'+ data[i].id_kecamatan +'">'+ data[i].nama_kecamatan +'</option>');
								});
								
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								alert('Error get data from ajax');
							}
						});
					})
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
			//end ajax kota kab
			
			
			//tampil pilihan data kecamatan yang dipilih di database dan option pilihan sesuai kecamatan yang dipilih
			$.ajax({
				type: "POST",
				url : "<?php echo site_url('customer/list_kecamatan')?>/" +selectKotaKab,
				//data: selectKotaKab,
				dataType: "JSON",
				success: function(data)
				{
					//console.log(data);
					$('[name="id_Kecamatan"]').empty();
					$('[name="id_Kecamatan"]').append('<option value="0">-Pilih Kecamatan-</option>');
									
					$.each(data, function(i, item){
						$('[name="id_Kecamatan"]').append('<option value="'+ data[i].id_kecamatan +'">'+ data[i].nama_kecamatan +'</option>');
					});
									
					$('[name="id_Kecamatan"]').val(selectKecamatan);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
			//end ajax kecamatan
			
			$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Ubah Customer'); // Set title to Bootstrap modal title	
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        } // 
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('Menyimpan...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('customer/ajax_add')?>";
    } else {
        url = "<?php echo site_url('customer/ajax_update')?>";
    }

    // ajax adding data to database

    var formData = new FormData($('#form')[0]);
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

function delete_data(id_customer)
{
    if(confirm('Apakah kamu yakin akan menghapus data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('customer/ajax_delete')?>/"+id_customer,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Customer</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>				
                    <div class="form-body">
						<div class="form-group">
                            <label class="control-label col-md-3">Kode Customer</label>
                            <div class="col-md-9">
                                <input name="kd_Customer" placeholder="Kode Customer" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Nama Customer</label>
                            <div class="col-md-9">
                                <input name="nama_Customer" placeholder="Nama Customer" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Nomor Kontak</label>
                            <div class="col-md-9">
                                <input name="no_Kontak" placeholder="Nomor Telefon / Handphone" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-9">
                                <textarea name="alamat_Customer" placeholder="Alamat Customer" class="form-control" type="text"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Pilih Provinsi</label>
                            <div class="col-md-9">
                                <?php 
									echo form_dropdown("id_Provinsi", $option_provinsi, '' ,'id="id_Provinsi" class="form-control" onchange="selected()"'); //name(string), option value(array), selected(array), extra(mixed)  --selectednya dikosongkan
								?>
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Pilih Kota / Kabupaten</label>
                            <div class="col-md-9">
								<?php 
									echo form_dropdown("id_KotaKab", array(0 => '-Pilih Kota / Kabupaten-'),'','id="id_KotaKab" class="form-control"');
								?>
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Pilih Kecamatan</label>
                            <div class="col-md-9">
                                <?php 
									echo form_dropdown("id_Kecamatan", array(0 => '-Pilih Kecamatan-'),'','id="id_Kecamatan" class="form-control"');
								?>
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
</html>