<!DOCTYPE html>
<html lang="en">
<head>

	<!-- jquery and bootstrap -->
	<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
	<script src="<?php echo base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.js')?>"></script>
	
	<!-- CSS -->
	<link href="<?php echo base_url('assets/jquery-ui-1.12.1.custom/jquery-ui.min.css');?>" rel="stylesheet">

</head>


<body>

<!--
<input type="text" name="country" id="autocomplete"/>
-->

<script>
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
    $( "#tags" ).autocomplete({
      source: availableTags,
	  select: 	
			function(event, ui) {
                $.ajax({
					url: "<?php echo site_url('sales_order/cek');?>",
					type: "POST",
					//contentType: "application/json; charset=utf-8",
					dataType: "JSON",
					data: 'keyword='+ui.item.value,
					success: function (data) 
					{
						console.log(data);
						$("#nama").html(data.nama_produk);
						$("#kode").html(data.kd_produk);
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

 
/*
$(function(){
  $("#tags").autocomplete({
    source: function (request, response) {
         $.ajax({
             url: "<?php echo site_url('sales_order/cek');?>",
             type: "POST",
			 //contentType: "application/json; charset=utf-8",
			 dataType: "JSON",
             data: 'keyword'+request,
             success: function (data) {
                 
				response($.map(data, function(obj) {
                    return {
                        label: obj.nama_produk,
                        value: obj.kd_produk
                        //description: obj.description,
                        //id: obj.name // don't really need this unless you're using it elsewhere.
                    };
                }));
             },
			 error: function (jqxhr, textStatus, error) {
				//var err = textStatus + ", " + error;
				//console.log( "Request Failed: " + err );
				alert('Error get data from ajax');
			}
         });
    }
	});
});
*/
  </script>

 
<div class="ui-widget">
  <label for="tags">Tags: </label>
  <input id="tags">
</div>

<div>
	<div id="kode"></div>
	<div id="nama"></div>
</div>


</body>

</html>
