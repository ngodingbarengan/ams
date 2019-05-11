<?php $this->load->view('include/header');?>
<?php $this->load->view('include/navbar');?>

<?php
	$id = $this->session->userdata('id_user');
	$user = $this->session->userdata('nama_user');
	$user = $this->session->userdata('email_user');
	$pass = $this->session->userdata('password_user');
	$hak_akses = $this->session->userdata('hak_akses_user');
?>

<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="glyphicon glyphicon-folder-open"></i> DATA PRODUK</h3>
				</div>
			</div>
            <!-- page start-->

		<?php if($hak_akses == 'ADMINISTRATOR') { ?>
        <button class="btn btn-success" onclick="add_data()"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
		<?php } ?>
        <button class="btn btn-success" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Segarkan</button>
        <br />
		<br />

        <table id="table" class="table table-striped table-bordered" style="text-align:center" cellspacing="0" width="100%">
            <thead>
                <tr style="text-align:center">
					<th>ID Kategori</th>
					<th>Kategori</th>
					<th>Kode Produk</th>
                    <th>Nama Produk</th>
					<th>ID Merk</th>
                    <th>Merk</th>
					<th>ID Satuan</th>
                    <th>Satuan</th>
					<th>Berat (Kg)</th>
                    <th>Harga</th>
                    <th>Stok</th>
					<th>Deskripsi</th>
                    <th>Foto Utama</th>
					<th>Foto 2</th>
					<th>Foto 3</th>
					<th>Foto 4</th>
					<th>Foto 5</th>
					<th>Aktif</th>
                    <th style="width:150px; text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


<script type="text/javascript">

tinymce.init({
  selector: 'textarea',
  height: 200,
  width: 400,
  plugins: [ //nama folder library dalam folder plugins
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  //imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
  //content_css: [
  //  'coba.css'
  //]
});



var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		"autoWidth": false,
		
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('produk/ajax_list')?>",
            "type": "POST"
        },
		
        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ 0 ], //hide ID kategori
                "visible": false,
            },
			{ 
				"width": "100px",
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            { 
                "targets": [ -2 ], //2 last column (Aktif)
                "orderable": false, //set not orderable
            },
			{ 
                "targets": [ -3 ], //2 last column (Foto 5)
                "orderable": false, //set not orderable
				 "visible": false, 
            },
			{ 
                "targets": [ -4 ], //2 last column (Foto 4)
                "orderable": false, //set not orderable
				 "visible": false,
            },
			{ 
                "targets": [ -5 ], //2 last column (Foto 3)
                "orderable": false, //set not orderable
				 "visible": false,
            },
			{ 
                "targets": [ -6 ], //2 last column (Foto 2)
                "orderable": false, //set not orderable
				 "visible": false,
            },
			{ 
                "targets": [ -7 ], //2 last column (Foto 2)
                "orderable": false, //set not orderable
            },
			{ 
                "targets": [ -8 ], //2 last column (Deskripsi)
                "orderable": false, //set not orderable
				 "visible": false,
            },
			{ 
                "targets": [ 4 ], //hide ID merek
                "visible": false,
            },
			{ 
                "targets": [ 6 ], //hide ID satuan
                "visible": false,
            },
        ],

    });

    //datepicker
    /*$('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });*/

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

function view_data(id_produk)
{
	//Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('produk/ajax_view')?>/"+id_produk,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            //$('[name="id"]').val(data.id_produk);
			$('[name="view_Nama_Kategori"]').val(data.nama_kategori);
			$('[name="view_Kd_Produk"]').val(data.kd_produk);
			$('[name="view_Nama_Produk"]').val(data.nama_produk);
			$('[name="view_Nama_Merek"]').val(data.nama_merek);
			$('[name="view_Nama_Satuan"]').val(data.nama_satuan);
			$('[name="view_Berat"]').val(data.berat);
			$('[name="view_Harga"]').val(data.harga);
			$('[name="view_Stok"]').val(data.stok);
			
			if(data.deskripsi == '')
			{
				$('[name="view_Deskripsi"]').html('<span class="badge badge-info">Tidak ada deskripsi</span>');
			}
			else{
				$('[name="view_Deskripsi"]').html(data.deskripsi);
			}
			
			$('[name="view_Aktif"]').html('<span class="badge badge-info">'+data.aktif+'</span>');

			$('#modal_view').modal('show'); // show bootstrap modal when complete loaded

            if(data.foto_1)
            {
                $('#view_foto_1 div').html('<img src="'+base_url+'upload/foto_produk/'+data.foto_1+'" class="img-responsive">'); // show photo
            }
            else
            {

                $('#view_foto_1 div').html('<span class="badge badge-info">Tidak ada foto</span>');
            }
			
			if(data.foto_2)
            {
                $('#view_foto_2 div').html('<img src="'+base_url+'upload/foto_produk/'+data.foto_2+'" class="img-responsive">'); // show photo
            }
            else
            {

                $('#view_foto_2 div').html('<span class="badge badge-info">Tidak ada foto</span>');
            }
			
			if(data.foto_3)
            {
                $('#view_foto_3 div').html('<img src="'+base_url+'upload/foto_produk/'+data.foto_3+'" class="img-responsive">'); // show photo
            }
            else
            {

                $('#view_foto_3 div').html('<span class="badge badge-info">Tidak ada foto</span>');
            }
			
			if(data.foto_4)
            {
                $('#view_foto_4 div').html('<img src="'+base_url+'upload/foto_produk/'+data.foto_4+'" class="img-responsive">'); // show photo
            }
            else
            {

                $('#view_foto_4 div').html('<span class="badge badge-info">Tidak ada foto</span>');
            }
			
			if(data.foto_5)
            {
                $('#view_foto_5 div').html('<img src="'+base_url+'upload/foto_produk/'+data.foto_5+'" class="img-responsive">'); // show photo
            }
            else
            {

                $('#view_foto_5 div').html('<span class="badge badge-info">Tidak ada foto</span>');
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}


function add_data()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Produk'); // Set Title to Bootstrap modal title

    $('#photo-preview_1').hide(); // hide photo preview modal
	$('#photo-preview_2').hide(); // hide photo preview modal
	$('#photo-preview_3').hide(); // hide photo preview modal
	$('#photo-preview_4').hide(); // hide photo preview modal
	$('#photo-preview_5').hide(); // hide photo preview modal

    $('#label-photo_1').text('Upload Foto 1 (Foto Utama)'); // label photo upload
	$('#label-photo_2').text('Upload Foto 2'); // label photo upload
	$('#label-photo_3').text('Upload Foto 3'); // label photo upload
	$('#label-photo_4').text('Upload Foto 4'); // label photo upload
	$('#label-photo_5').text('Upload Foto 5'); // label photo upload
	
}

function edit_data(id_produk)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string


    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('produk/ajax_edit')?>/"+id_produk,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id_produk);
            $('[name="id_Kategori"]').val(data.id_kategori);
            $('[name="kd_Produk"]').val(data.kd_produk);
            $('[name="nama_Produk"]').val(data.nama_produk);
            $('[name="id_Merek"]').val(data.id_merek);
            $('[name="id_Satuan"]').val(data.id_satuan);
			$('[name="berat_Produk"]').val(data.berat);
			$('[name="harga_Produk"]').val(data.harga);
			$('[name="stok_Produk"]').val(data.stok);
			tinymce.get("deskripsi_Produk").execCommand('mceInsertContent',false, data.deskripsi);
			$('[name="aktif_Produk"]').val(data.aktif);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Ubah Produk'); // Set title to Bootstrap modal title

            //$('#photo-preview').show(); // show photo preview modal
			
            if(data.foto_1)
            {
                $('#photo-preview_1 div').html('<img src="'+base_url+'upload/foto_produk/'+data.foto_1+'" class="img-responsive">'); // show photo
				$('#photo-preview_1 div').append('<input type="checkbox" name="hapus_foto_1" value="'+data.foto_1+'"/> Hapus foto saat menyimpan'); // remove photo
				$('#label-photo_1').text('Ubah Foto 1'); // label photo upload
            }
            else
            {

                $('#photo-preview_1 div').html('<span class="badge badge-info">Tidak ada foto</span>');
            }
			
			if(data.foto_2)
            {
                $('#photo-preview_2 div').html('<img src="'+base_url+'upload/foto_produk/'+data.foto_2+'" class="img-responsive">'); // show photo
				$('#photo-preview_2 div').append('<input type="checkbox" name="hapus_foto_2" value="'+data.foto_2+'"/> Hapus foto saat menyimpan'); // remove photo
				$('#label-photo_2').text('Ubah Foto 2'); // label photo upload
            }
            else
            {

                $('#photo-preview_2 div').html('<span class="badge badge-info">Tidak ada foto</span>');
            }
			
			if(data.foto_3)
            {
                $('#photo-preview_3 div').html('<img src="'+base_url+'upload/foto_produk/'+data.foto_3+'" class="img-responsive">'); // show photo
				$('#photo-preview_3 div').append('<input type="checkbox" name="hapus_foto_3" value="'+data.foto_3+'"/> Hapus foto saat menyimpan'); // remove photo
				$('#label-photo_3').text('Ubah Foto 3'); // label photo upload
            }
            else
            {

                $('#photo-preview_3 div').html('<span class="badge badge-info">Tidak ada foto</span>');
            }
			
			if(data.foto_4)
            {
                $('#photo-preview_4 div').html('<img src="'+base_url+'upload/foto_produk/'+data.foto_4+'" class="img-responsive">'); // show photo
				$('#photo-preview_4 div').append('<input type="checkbox" name="hapus_foto_4" value="'+data.foto_4+'"/> Hapus foto saat menyimpan'); // remove photo
				$('#label-photo_4').text('Ubah Foto 4'); // label photo upload
            }
            else
            {

                $('#photo-preview_4 div').html('<span class="badge badge-info">Tidak ada foto</span>');
            }
			
			if(data.foto_5)
            {
                $('#photo-preview_5 div').html('<img src="'+base_url+'upload/foto_produk/'+data.foto_5+'" class="img-responsive">'); // show photo
				$('#photo-preview_5 div').append('<input type="checkbox" name="hapus_foto_5" value="'+data.foto_5+'"/> Hapus foto saat menyimpan'); // remove photo
				$('#label-photo_5').text('Ubah Foto 5'); // label photo upload
            }
            else
            {

                $('#photo-preview_5 div').html('<span class="badge badge-info">Tidak ada foto</span>');
            }
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
	// TinyMCE will now save the data into textarea
	tinyMCE.triggerSave();
	
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('produk/ajax_add')?>";
    } else {
        url = "<?php echo site_url('produk/ajax_update')?>";
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
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function delete_data(id_produk)
{
    if(confirm('Apakah kamu yakin akan menghapus data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('produk/ajax_delete')?>/"+id_produk,
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

<!-- Bootstrap modal for add and edit data-->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Produk</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kategori Produk</label>
                            <div class="col-md-9">
                                <!--<input name="nama_Kategori" placeholder="Kategori Produk" class="form-control" type="text">-->
								<?php 
									echo form_dropdown("id_Kategori", $option_kategori, '' ,'id="id_Kategori" class="form-control" name="id_Kategori"'); //name(string), option value(array), selected(array), extra(mixed)  --selectednya dikosongkan
								?>
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Kode Produk</label>
                            <div class="col-md-9">
                                <input name="kd_Produk" placeholder="Kode Produk" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Produk</label>
                            <div class="col-md-9">
                                <input name="nama_Produk" placeholder="Nama Produk" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Merek</label>
                            <div class="col-md-9">
								<?php 
									echo form_dropdown("id_Merek", $option_merek, '' ,'id="id_Merek" class="form-control" name="id_Merek"'); //name(string), option value(array), selected(array), extra(mixed)  --selectednya dikosongkan
								?>
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Satuan</label>
                            <div class="col-md-9">
								<?php 
									echo form_dropdown("id_Satuan", $option_satuan, '' ,'id="id_Satuan" class="form-control" name="id_Satuan"'); //name(string), option value(array), selected(array), extra(mixed)  --selectednya dikosongkan
								?>
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Berat (Kg)</label>
                            <div class="col-md-9">
                                <input name="berat_Produk" placeholder="Berat Produk" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Harga</label>
                            <div class="col-md-9">
                                <input name="harga_Produk" placeholder="Harga Produk" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Stok</label>
                            <div class="col-md-9">
                                <input name="stok_Produk" placeholder="Stok Produk" class="form-control" type="text" value="0" readonly="readonly">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Deskripsi</label>
                            <div name="deskripsi" class="col-md-9">
                                <textarea name="deskripsi_Produk" id="deskripsi_Produk" placeholder="Deskripsi Produk" class="form-control" type="text"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group" id="photo-preview_1">
                            <label class="control-label col-md-3">Foto 1</label>
                            <div class="col-md-9">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" id="label-photo_1"> </label>
                            <div class="col-md-9">
                                <input name="foto1" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group" id="photo-preview_2">
                            <label class="control-label col-md-3">Foto 2</label>
                            <div class="col-md-9">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" id="label-photo_2"> </label>
                            <div class="col-md-9">
                                <input name="foto2" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group" id="photo-preview_3">
                            <label class="control-label col-md-3">Foto 3</label>
                            <div class="col-md-9">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" id="label-photo_3"> </label>
                            <div class="col-md-9">
                                <input name="foto3" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group" id="photo-preview_4">
                            <label class="control-label col-md-3">Foto 4</label>
                            <div class="col-md-9">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" id="label-photo_4"> </label>
                            <div class="col-md-9">
                                <input name="foto4" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group" id="photo-preview_5">
                            <label class="control-label col-md-3">Foto 5</label>
                            <div class="col-md-9">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" id="label-photo_5"> </label>
                            <div class="col-md-9">
                                <input name="foto5" type="file">
                                <span class="help-block"></span>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Aktif</label>
                            <div class="col-md-9">
                                <select name="aktif_Produk" class="form-control">
                                    <option value="">-Tampilkan Produk-</option>
                                    <option value="Y">Ya</option>
                                    <option value="N">Tidak</option>
                                </select>
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

<!--Bootstrap modal view-->
	<div class="modal fade" id="modal_view" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title-view">Rincian Produk</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kategori Produk</label>
                            <div class="col-md-9">
								<input name="view_Nama_Kategori" class="form-control" type="text" readonly="readonly">
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Kode Produk</label>
                            <div class="col-md-9">
								<input name="view_Kd_Produk" class="form-control" type="text" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Produk</label>
                            <div class="col-md-9">
								<input name="view_Nama_Produk" class="form-control" type="text" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Merek</label>
							<div class="col-md-9">
								<input name="view_Nama_Merek" class="form-control" type="text" readonly="readonly">
							</div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Satuan</label>
                            <div class="col-md-9">
								<input name="view_Nama_Satuan" class="form-control" type="text" readonly="readonly">
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Berat (Kg)</label>
                            <div class="col-md-9">
								<input name="view_Berat" class="form-control" type="text" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Harga</label>
                            <div class="col-md-9">
                                <input name="view_Harga" class="form-control" type="text" readonly="readonly">
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Stok</label>
                            <div class="col-md-9">
                                <input name="view_Stok" class="form-control" type="text" readonly="readonly">
                            </div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Deskripsi</label>
                            <div name="view_Deskripsi" class="col-md-9"></div>
                        </div>
                        <div class="form-group" id="view_foto_1">
                            <label class="control-label col-md-3">Foto 1 <br/>(Foto Utama)</label>
                            <div class="col-md-9"></div>
                        </div>
						<div class="form-group" id="view_foto_2">
                            <label class="control-label col-md-3">Foto 2</label>
                            <div class="col-md-9"></div>
                        </div>
						<div class="form-group" id="view_foto_3">
                            <label class="control-label col-md-3">Foto 3</label>
                            <div class="col-md-9"></div>
                        </div>
						<div class="form-group" id="view_foto_4">
                            <label class="control-label col-md-3">Foto 4</label>
                            <div class="col-md-9"></div>
                        </div>
						<div class="form-group" id="view_foto_5">
                            <label class="control-label col-md-3">Foto 5</label>
                            <div class="col-md-9"></div>
                        </div>
						<div class="form-group">
                            <label class="control-label col-md-3">Aktif</label>
							<div name="view_Aktif" class="col-md-9"></div>
                        </div>
                    </div>
                </form>
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