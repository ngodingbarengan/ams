<?php $this->load->view('include/header');?>
<?php $this->load->view('include/navbar');?>

<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="glyphicon glyphicon-folder-open"></i> DATA KOTA / KABUPATEN</h3>
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
					<th>ID Provinsi</th>
					<th>Nama Provinsi</th>
                    <th>Nama Kota / Kabupaten</th>
					<th style="width:150px; text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>


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
            "url": "<?php echo site_url('Kota_kab/ajax_list')?>",
            "type": "POST"
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ 3 ], //last column
                "orderable": false, //set not orderable
            },
			{
				"targets": [ 0 ], //last column
				"visible": false,
                "orderable": false, //set not orderable
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



function add_data()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Kota / Kabupaten'); // Set Title to Bootstrap modal title
}

function edit_data(id_kota_kab)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('Kota_kab/ajax_edit')?>/"+id_kota_kab,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {	
            $('[name="id"]').val(data.id_kota_kab);
			$('[name="nama_Kota_kab"]').val(data.nama_kota_kab);
            $('#id_Provinsi').val(data.id_provinsi);
			//$('#id_provinsi').options[$('#id_provinsi').selectedIndex].value(id_provinsi);
            //document.getElementById("#id_provinsi").selectedIndex.value(data.id_provinsi);
			$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Kota / Kabupaten'); // Set title to Bootstrap modal title
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
        url = "<?php echo site_url('Kota_kab/ajax_add')?>";
    } else {
        url = "<?php echo site_url('Kota_kab/ajax_update')?>";
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

function delete_data(id_kota_kab)
{
    if(confirm('Apakah kamu yakin akan menghapus data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('kota_kab/ajax_delete')?>/"+id_kota_kab,
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
                <h3 class="modal-title">Form Kota / Kabupaten</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>				
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Pilih Provinsi</label>
                            <div class="col-md-9">
                                <?php 
									echo form_dropdown("id_Provinsi", $option_provinsi, '' ,'id="id_Provinsi" class="form-control" name="id_Provinsi"'); //name(string), option value(array), selected(array), extra(mixed)  --selectednya dikosongkan
								?>
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Masukkan Nama Kota / Kabupaten</label>
                            <div class="col-md-9">
                                <input name="nama_Kota_kab" placeholder="Nama Kota Kabupaten" class="form-control" type="text">
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
