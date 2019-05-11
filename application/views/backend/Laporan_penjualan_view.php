<?php $this->load->view('include/header');?>
<?php $this->load->view('include/navbar');?>

<!--main content start-->
    <section id="main-content">
        <section class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="glyphicon glyphicon-list-alt"></i> LAPORAN PENJUALAN</h3>
				</div>
			</div>
            <!-- page start-->

<div class="container">    
            
    <!--<div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Form Laporan Penjualan</h3>
            </div>
            <div class="panel-body" >

                    <form  class="form-body" method="post" >

                        <div id="div_id_select" class="form-group required">
                            <label for="id_select"  class="control-label col-md-4  requiredField"> Pilih Jenis Laporan </label>
                            <div class="controls col-md-8 "  style="margin-bottom: 20px">
                                
								<select class="form-control" name="housetype">
								  <option>All</option>
								  <option>Customer Order</option>
								  <option>Sales Order</option>
								</select>
								
                            </div>
                        </div>

						<div id="div_id_select" class="form-group">
                            <label for="id_select"  class="control-label col-md-4  requiredField"> Dari Tanggal </label>
                            <div class="controls col-md-8 "  style="margin-bottom: 10px">
                                
								<input class="input-md  textinput textInput form-control" id="id_username" maxlength="30" name="username" placeholder="Klik untuk memilih tanggal" style="margin-bottom: 10px" type="text" readonly />
								
                            </div>
                        </div> 
						
						<div id="div_id_select" class="form-group">
                            <label for="id_select"  class="control-label col-md-4  requiredField"> Hingga Tanggal </label>
                            <div class="controls col-md-8 "  style="margin-bottom: 10px">
                                
								<input class="input-md  textinput textInput form-control" id="id_username" maxlength="30" name="username" placeholder="Klik untuk memilih tanggal" style="margin-bottom: 10px" type="text" readonly />
								
                            </div>
                        </div> 
						
                        <div id="div_id_As" class="form-group required">
                            <label for="id_As"  class="control-label col-md-4  requiredField"></label>
                            <div class="controls col-md-8 "  style="margin-bottom: 20px">
                                <label class="radio-inline col-md-5"> <input type="radio" name="As" id="id_As_1" value="I"  style="margin-bottom: 10px">Rekap </label>
                                <label class="radio-inline col-md-5"> <input type="radio" name="As" id="id_As_2" value="CI"  style="margin-bottom: 10px">Detail </label>
                            </div>
                        </div>
                        
						<div class="form-group"> 
                            <div class="aab controls col-md-4 "></div>
                            <div class="controls col-md-8 ">
                                <input type="submit" name="Tampilkan" value="Tampilkan" class="btn btn-primary btn btn-success" id="submit-id-signup" />
                            </div>
                        </div> 
                            
                    </form>
            </div>
        </div>
    <!--</div>--> 
</div>
        


        </section>
		<!-- page end--> <!-- class="wrapper" -->
	</section>
	<!--main content end-->
</section>
<!-- container section end -->
			  
<?php $this->load->view('include/footer');?>