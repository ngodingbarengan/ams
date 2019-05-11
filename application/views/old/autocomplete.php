<!DOCTYPE html>
<html lang="en">
<head>

<!-- jquery and bootstrap -->
	<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/jquery.autocomplete.min.js')?>"></script>

<style>
body{width:610px;}
.frmSearch {border: 1px solid #a8d4b1;background-color: #c6f7d0;margin: 2px 0px;padding:40px;border-radius:4px;}
#country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;}
#country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
#country-list li:hover{background:#ece3d2;cursor: pointer;}
#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
</style>

</head>


<body>

<!--
<input type="text" name="country" id="autocomplete"/>
-->

<script type="text/javascript">
/*
$('#autocomplete').autocomplete({
	type: 'JSON',
    serviceUrl: '<?php echo site_url('sales_order/cek'); ?>',
    onSelect: function (sugesstion) {
        //alert('You selected: ' + data.kd_produk + ', ' + data.nama_produk);
		alert(sugesstion);	
	}
});
*/


$(document).ready(function(){
	//var key = $('#search-box').val();
	
	$("#search-box").keyup(function(){
		
		//var key = $(this).val();
	
		$.ajax({
		type: "POST",
		url: "<?php echo site_url('sales_order/cek'); ?>",
		dataType: "JSON",
		data: 'keyword='+$(this).val(),
		//beforeSend: function(){
		//	$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		//},
		success: function(data){
			
			$("#list").empty();
			//$("#suggesstion-box").show();
			//$("#suggesstion-box").append('<ul>');
			$.each(data, function(i, item){
				$("#list").append('<li value="'+data[i].kd_produk+'">'+data[i].kd_produk+' - '+data[i].nama_produk+'</li>');						
			});
			//$("#suggesstion-box").append('</ul>');
			//$("#suggesstion-box").append(data.kd_produk);
			//$("#search-box").css("background","#FFF");
			//console.log(data);
			document.getElementById("list").addEventListener("click", function(event){
					$("#search-box").text($(this).val());
					$("#suggesstion-box").hide();
			})
		}/*,
		error: function (jqxhr, textStatus, error) {
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
        }*/
		});
	});
});


function selected(val){
	$("#search-box").val(val);
	$("#suggesstion-box").hide();
}
</script>

<div class="frmSearch">
<input type="text" id="search-box" placeholder="Country Name" style="width:500px" />
<div id="suggesstion-box"><ul id="list"></ul></div>
</div>

</body>

</html>
