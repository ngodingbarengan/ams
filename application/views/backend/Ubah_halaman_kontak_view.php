<?php $this->load->view('include/header');?>
<?php $this->load->view('include/navbar');?>

<script type="text/javascript">

function save()
{
	// TinyMCE will now save the data into textarea
	tinyMCE.triggerSave();
	
    // ajax adding data to database
    var formData = new FormData($('#form')[0]);
	console.log(formData);
	
    $.ajax({
        url : "<?php echo site_url('halaman/update_kontak')?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
			console.log(data);
			alert('Berhasil merubah isi halaman kontak');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
        }
    });
}


tinymce.init({
  selector: 'textarea',
  height: 500,
  width: '100%',
  plugins: [ //nama folder library dalam folder plugins
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools"
  ],
  toolbar: ["insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"],
  setup: function (editor) {
      editor.on('init', function () {
        
		$.ajax({
			url : "<?php echo site_url('halaman/get_isi_kontak');?>",
			type: "GET",
			dataType: "JSON",
			success: function(data)
			{

				jQuery.each(data['isi'], function(obj, values) {
					//console.log(data['isi'].isi_halaman);
					tinymce.get("Isi_Hal").setContent(data['isi'].isi_halaman);
					
					//tinymce.get("Isi_Hal").execCommand('mceInsertContent',false, data['isi'].isi_halaman);
					//bila menggunakan mceInsertContent maka isi teks akan bertambah setiap halaman di- refresh
				});
				
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error adding / update data');
				console.log(textStatus);
			}
		});
		
    })
  }
});

</script>


<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="glyphicon glyphicon-pencil"></i> UBAH HALAMAN KONTAK</h3>
				</div>
			</div>
            <!-- page start-->
		<div class="modal-body form">
			<div class="form-group">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
						<div class="form-group">
                            <div name="deskripsi" class="col-md-12">
                                <textarea name="Isi_Hal" id="Isi_Hal" placeholder="Isi Konten Halaman" class="form-control" type="text"></textarea>
                                <span class="help-block"></span>
								<br/>
								<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Ubah</button>
                            </div>
                        </div>
                </form>
				
            </div>
		</div>
       


        </section>
		<!-- page end--> <!-- class="wrapper" -->
	</section>
	<!--main content end-->
</section>
<!-- container section end -->
			  
<?php $this->load->view('include/footer');?>