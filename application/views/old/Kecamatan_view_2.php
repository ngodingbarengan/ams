<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajax CRUD with Bootstrap modals and Datatables with Image Upload</title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head> 
<body>
    <div class="container">
        <hr/>
		<h1 style="font-size:20pt" class="text-center">DATA KECAMATAN</h1>
		<hr/>
        <button class="btn btn-success" onclick="add_data()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Segarkan</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
					<th>ID Provinsi</th>
					<th>Nama Provinsi</th>
					<th>ID Kota / Kabupaten</th>
					<th>Nama Kota / Kabupaten</th>
					<th>Nama Kecamatan</th>
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>


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
            "url": "<?php echo site_url('Kecamatan/ajax_list')?>",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
			{
				"targets": [ 5 ], //last column start from [0]
                "orderable": false, //set not orderable
			},
			{ 
                "targets": [ 0 ], //hide ID provinsi
                "visible": false,
            },
			{ 
                "targets": [ 2 ], //hide ID kota kabupaten
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
	var selectValues = $("#id_Provinsi").val();
	//var selectValues = $("#id_Provinsi").val($(this).data('id'));
	    		
	if (selectValues > 0){
					
	//console.log($("#id_Provinsi").val());
					
	$.ajax({
		type: "POST",
		url : "<?php echo site_url('Kecamatan/select_kota')?>/" + selectValues,
		data: selectValues,
		dataType: "JSON",
		success: function(data)
		{	
			//alert('berhasil');						
			//console.log(data);
		
			$('[name="id_KotaKab"]').empty();
			$.each(data, function(i, item){
				$('[name="id_KotaKab"]').append('<option value="'+ data[i].id_kota_kab +'">'+ data[i].nama_kota_kab +'</option>');
									
			});
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('Error get data from ajax');
		}
	});
	}else{
		$('[name="id_KotaKab"]').empty();
		$('[name="id_KotaKab"]').append('<option value="Pilih Kota / Kabupaten">-Pilih Provinsi Lebih Dahulu-</option>');
	}
}
//});



function add_data()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
	$('#id_KotaKab').empty();
	$('[name="id_KotaKab"]').empty();
	$('[name="id_KotaKab"]').append('<option value="Pilih Kota / Kabupaten">-Pilih Provinsi Lebih Dahulu-</option>');
	$('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Kecamatan'); // Set Title to Bootstrap modal title
}

function edit_data(id_kecamatan)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Kecamatan/ajax_edit')?>/"+id_kecamatan,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {	
            $('[name="id"]').val(data.id_kecamatan);
			$('#id_Provinsi').val(data.id_provinsi);
			$('[name="nama_Kecamatan"]').val(data.nama_kecamatan);
			var selectValuesEdit = data.id_provinsi;
			var KotaKab = data.id_kota_kab;
			
			$.ajax({
				url : "<?php echo site_url('Kecamatan/select_kota')?>/"+selectValuesEdit,
				type: "GET",
				dataType: "JSON",
				data: selectValuesEdit,
				success: function(data)
				{
					$('[name="id_KotaKab"]').empty();
					$.each(data, function(i, item){
						$('[name="id_KotaKab"]').append('<option value="'+ data[i].id_kota_kab +'">'+ data[i].nama_kota_kab +'</option>');				
					});
					$('[name="id_KotaKab"]').val(KotaKab);	
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
			
			$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Kecamatan'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
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
        url = "<?php echo site_url('Kecamatan/ajax_add')?>";
    } else {
        url = "<?php echo site_url('Kecamatan/ajax_update')?>";
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

function delete_data(id_kecamatan)
{
    if(confirm('Apakah kamu yakin akan menghapus data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('Kecamatan/ajax_delete')?>/"+id_kecamatan,
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
                <h3 class="modal-title">Form Kecamatan</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>				
                    <div class="form-body">
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
									echo form_dropdown("id_KotaKab", array(0 => '-Pilih Kota / Kabupaten Lebih Dahulu-'),'','id="id_KotaKab" class="form-control"');
								?>
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Masukkan Nama Kecamatan</label>
                            <div class="col-md-9">
                                <input name="nama_Kecamatan" placeholder="Nama Kecamatan" class="form-control" type="text" id="nama_Kecamatan">
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
</body>
</html>