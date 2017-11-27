 <?php
 session_start();
 require_once '../../includes/views/define_include.php';
 require_once '../../classes/marketing/file_upload.php';

 $loginManager = new LoginManager();
 $logerHD = new LoggerHD();

 $page = new Page();
 $page->setIcon("iconfa-home");
 $page->setHeader("Call Disposition");
 $page->setTag_line("view_files");
 $page->setMenu_active("file_upload");
 $page->setMenu_group("file_upload");

 if (!$loginManager->confirm_member()) {
  header('Location: ../../index.php');
}

// Force download of image file specified in URL query string and which 
// is in the same directory as this script: 
// grab the requested file's name
$file_upload = new gDriveUpload();

if(isset($_GET['delete_id'])){
	$added_by = $_SESSION['user_id'];
	$file_upload->deleteFiles($_GET['delete_id'],$added_by);
	header("Location:file_list_folders.php");
}

if(isset($_GET['file'])){
  @$file_name = $_GET['file'];

// make sure it's a file before doing anything!
  if(is_file($file_name)) {

	/*
		Do any processing you'd like here:
		1.  Increment a counter
		2.  Do something with the DB
		3.  Check user permissions
		4.  Anything you want!
	*/

	// required for IE
   if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}

	// get the file mime type using the file extension
   switch(strtolower(substr(strrchr($file_name, '.'), 1))) {
    case 'pdf': $mime = 'application/pdf'; break;
    case 'zip': $mime = 'application/zip'; break;
    case 'jpeg':
    case 'jpg': $mime = 'image/jpg'; break;
    default: $mime = 'application/force-download';
  }
	header('Pragma: public'); 	// required
	header('Expires: 0');		// no cache
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_name)).' GMT');
	header('Cache-Control: private',false);
	header('Content-Type: '.$mime);
	header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize($file_name));	// provide file size
	header('Connection: close');
	readfile($file_name);		// push it out
	exit();
}
}

$drop_downs = new DropDownlist();

$getAllGraphicsMainCategory = $drop_downs->getAllGraphicsMainCategory();
$getAllGraphicsSubCategory = $drop_downs->getAllGraphicsSubCategory();
$getAllGraphicsBusinessName = $drop_downs->getAllGraphicsBusinessName();
$getAllGraphicsPaperSize = $drop_downs->getAllGraphicsPaperSize();
$getAllCarrier = $drop_downs->getAllCarrier();
$getAllGraphicsDealerTypes = $drop_downs->getAllGraphicsDealerTypes();
$getAllSLUsers = $drop_downs->getGraphicDesigners();
?>   
<!DOCTYPE html>

<html lang="en">
<head>
  <!-- class head -->
  <?php require("../../includes/views/head.php") ?>
  <!-- class head -->
  
<script>   
  $(document).ready(function() {

  });
///////////////////// add invoice number ////////////////

 jQuery(document).ready(function () {
  jQuery('#loading').fadeOut();
  jQuery('#returninvoiceModal').on('show.bs.modal', function (e) {
    $('.modal-backdrop').fadeIn(150);
    var file_name_id = jQuery(e.relatedTarget).data('item-id');
    
    jQuery.ajax({
      type: "POST",
      url: "ajax_show_graphic_details.php",
      cache: false,
      data: {id: file_name_id},
      beforeSend: function() {
        
       $("#returninvoiceModal").find('#orderDetails').html("Loading.Please Wait...");
     },
     success: function (records) {
      $("#returninvoiceModal").find('#orderDetails').html(records);
    }
  });
  });

  jQuery('#returninvoiceModal').on('hide.bs.modal', function (e) {
   $("#returninvoiceModal").find('#orderDetails').html("");
   $('.modal-backdrop').fadeOut(150);
 });

     jQuery("body").on("click", ".view-modal", function(e) {
        e.preventDefault();
        
        var image_name = $(this).attr('href');
        var catagery = $(this).data('catagory');

        $.ajax({
         url : "ajax_thumb_create.php",
         type: "POST",
         data : {image_name:image_name,catagery:catagery},
         success: function(data)
         {
           jQuery('#loading').fadeOut();
              //jQuery("#image_container").html(data);
        //jQuery("#image_container").animate({
          jQuery("#results").html(data);
          jQuery("#results").animate({
            'opacity': 1
          });
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
         
        }
      });

      });
});
           

// ajax search results with pagination	
jQuery(document).ready(function () {

	$("#results" ).load("fetch_pages.php"); //load initial records
	
	//executes code below when user click on pagination links
	$("#results").on( "click", ".pager a", function (e){
		e.preventDefault();
		
		jQuery('#loading').fadeIn();
   jQuery("#results").animate({
    'opacity': 0.2
  });

		var page = $(this).attr("data-page"); //get page number from link
   updateResults(page);
 });
  

  $("#daterange").daterangepicker({ 
    locale: {
     "cancelLabel": "Clear"
   }
 });
  updateResults(1);
  $("#daterange").on('apply.daterangepicker', function(ev, picker) {
    var daterange = $('#daterange').val();	
    updateResults(1);
  });

  $("#daterange").on('cancel.daterangepicker', function(ev, picker) {
   var todate = $('#todate').val();			 
   $(this).val(todate);
   updateResults(1);
 });
  
  jQuery('body').on('change', '.search', function() {  
   updateResults(1);
 }); 
  
	 // $("#image_container" ).load( "ajax_file_list_folders.php"); //load initial records
  
   function updateResults(page) {
     jQuery('#loading').fadeIn();
		  //jQuery("#image_container").animate({
       jQuery("#results").animate({
        'opacity': 0.2
      });
       var page = page;
       var maincategory = $('#maincategory').val();	
       var subCategory = $('#subCategory').val();	
       var businessName = $('#businessName').val();	
       var dealertype = $('#dealertype').val();	
       var carrier = $('#carrier').val();
       var designedBy = $('#designedBy').val();	
       var daterange = $('#daterange').val();	
       var flyer_name = $('#flyer_name').val();	

       var formData = {
         maincategory:maincategory,
         subCategory:subCategory,
         businessName:businessName,
         dealertype:dealertype,
         carrier:carrier,
         designedBy:designedBy,
         flyer_name:flyer_name,
         daterange:daterange,
         page:page			
       }
       
       $.ajax({
         url : "fetch_pages.php",
         type: "POST",
         data : formData,
         success: function(data)
         {
           jQuery('#loading').fadeOut();
              //jQuery("#image_container").html(data);
			  //jQuery("#image_container").animate({
          jQuery("#results").html(data);
          jQuery("#results").animate({
            'opacity': 1
          });
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
         
        }
      });	
     }
     
   });

 </script>
 <style>
  
  #loading {
    background:url(loading.gif) no-repeat center center;
    height: 100px;
    width: 100px;
    position: fixed;
    padding-top: 25%;
    left: 50%;
    //top: 20%;
    // margin: -25px 0 0 -25px;
    z-index: 1000;
  }



  #uuu
  {
    width:  100%; /*or 70%, or what you want*/
    height: 150px; /*or 70%, or what you want*/
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }


  /* Pagination style */

  .pager li{
   display: inline;
   padding: 1px 1px 1px 1px;
   //border: 1px solid #ddd;
   //margin-right: -1px;
   font: 15px/20px Arial, Helvetica, sans-serif;
   background: #FFFFFF;
   //box-shadow: inset 1px 1px 5px #F4F4F4;
 }

 .pager li:hover{
   //background: #CFF;
 }
 .pager li.active{
   background: #F0F0F0;
   color: #333;
   padding: 6px 14px 7px 14px;
   border: 1px solid #ddd;
 }
</style>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="css/thirdeffect1.css" type="text/css" media="screen"/>	

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="page-header-fixed page-footer-fixed page-quick-sidebar-over-content">
  <!-- BEGIN HEADER -->
  <?php require("../../includes/views/header_admin.php") ?>
  <!-- END HEADER -->
  <div class="clearfix">
  </div>
  <!-- BEGIN CONTAINER -->
  <div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <?php require("../../includes/views/quick_sidebar.php") ?>
    <!-- END SIDEBAR -->

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
      <div class="page-content">

        <!-- BEGIN PAGE HEADER-->
        <div id="hide"><?php include ("../../includes/views/messager.php"); //Display  Messages for Entered Data ?></div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row" >
          <div class="col-md-12">

            <div class="portlet light">
              <div class="portlet-title">
               <div class="caption">
                
                <span class="caption-subject bold uppercase">View Gallery</span>
              </div>
                <div class="tools">
                  <?php if (isset($_SESSION['user_permissions']['File_upload_enable']) && ($_SESSION['user_permissions']['File_upload_enable'] == '1')){?>
                  <a href="file_upload" class="btn default" style="text-decoration:none; height:30px;">Upload File</a>
                  <?php }?>

                </div>
              </div>
              <div class="portlet-body form"><br />
                <!--<a class="btn btn-xs red" href="?fileID=0Byz4UgDEDPszNjFLUmFxSXI2RGc"><i class="fa fa-trash-o"></i></a>-->
                <?php
                $file_upload = new gDriveUpload();
                $viewMainCategoryName = $file_upload->viewMainCategoryName();	

                $records_per_page = 24;
                $starting_position=1;
                $total_records=60;
                if(isset($_GET["page_no"]))
                {
                  $starting_position=(($_GET["page_no"]-1)*$records_per_page);
                }
                
				                     	$viewUploadedFiles = $file_upload->viewUploadedFiles($records_per_page,$starting_position);									//print_r($results);
                              ?>
                              <div class="row" style="margin-left:20px;">												
                                <div class="col-md-2">
                                 <h4 class="help-block"> Main Category : </h4>
                                 <select name="maincategory" class="input-small input-sm form-control search" id="maincategory">
                                  <option value="" selected="true">--- Select ---</option>
                                  <?php
                                  foreach ($getAllGraphicsMainCategory as $values) {
                                    ?>
                                    <option value="<?php echo $values['category_id']; ?>"><?php echo $values['category_name']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                
                                
                                <div class="col-md-2">
                                 <h4 class="help-block"> Sub Category : </h4>
                                 <select name="subCategory" class="input-small input-sm form-control search" id="subCategory">
                                  <option value="" selected="true">--- Select ---</option>
                                  <?php
                                  foreach ($getAllGraphicsSubCategory as $values) {
                                    ?>
                                    <option value="<?php echo $values['sub_category_id']; ?>"><?php echo $values['sub_category_name']; ?></option>
                                    <?php } ?>
                                  </select>
                                  

                                </div>

                                <div class="col-md-2">
                                 <h4 class="help-block"> Business Name : </h4>
                                 <select name="businessName" class="input-small input-sm form-control search" id="businessName">
                                  <option value="" selected="true">--- Select ---</option>
                                  <?php
                                  foreach ($getAllGraphicsBusinessName as $values) {
                                    ?>
                                    <option value="<?php echo $values['business_id']; ?>"><?php echo $values['business_name']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                
                                <div class="col-md-2">
                                 <h4 class="help-block"> Dealer Types : </h4>
                                 <select name="dealertype" class="input-small input-sm form-control search" id="dealertype">
                                  <option value="" selected="true">--- Select ---</option>
                                  <?php
                                  foreach ($getAllGraphicsDealerTypes as $index=>$values) {
                                    ?>
                                    <option value="<?php echo $index; ?>"><?php echo $values; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                
                                <div class="col-md-2">
                                 <h4 class="help-block"> Carrier : </h4>
                                 <select name="carrier" class="input-small input-sm form-control search" id="carrier">
                                  <option value="" selected="true">--- Select ---</option>
                                  <?php
                                  foreach ($getAllCarrier as $values) {
                                    ?>
                                    <option value="<?php echo $values['carrier_id']; ?>"><?php echo $values['carrier_name']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>


                              </div>
                              <br />
                              
                              <div class="row" style="margin-left:20px;">												


                                <div class="col-md-2">
                                 <h4 class="help-block"> Designed by : </h4>
                                 <select name="designedBy" class="input-small input-sm form-control search" id="designedBy">
                                  <option value="" selected="true">--- Select ---</option>
                                  <?php
                                  foreach ($getAllSLUsers as $values) {
                                    ?>
                                    <option value="<?php echo $values['user_id']; ?>"><?php echo $values['user_calling_name']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                                
                                
                                <div class="col-md-4">
                                 <h4 class="help-block"> Date Range : </h4>
                                 <input type="text" class="input-large input-sm form-control search" name="daterange" id="daterange" value="01/01/2015 - <?php echo date('m/d/Y'); ?>" />
                               </div>

                               <div class="col-md-2">
                                 <h4 class="help-block"> Flyer Name : </h4>
                                 <input type="text" class="input-large input-sm form-control search" name="flyer_name" id="flyer_name" value="">
                               </div>
                             </div>
                             <input type="hidden" name="todate" id="todate" value="01/01/2015 - <?php echo date('m/d/Y'); ?>" />
                             <hr /> <div id="loading"></div>                                            
                             <div id="results"  style="min-height:700px;"><!-- content will be loaded here -->
                               
                             </div>
                           </div>										
                           
                           <!-- image modal  -->
                           <div class="modal fade" id="returninvoiceModal" role="dialog" aria-labelledby="returninvoiceModal" style="display:none; ">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&amp;times;</button>
                                  <h4 class="modal-title" id="myModalLabel"><b><i class="fa fa-file-pdf-o"></i> View File Details</b></h4>
                                </div>
                                <div id="orderDetails" class="modal-body"></div>     
                              </div>
                            </div>
                          </div>
                          <!-- end -->
                          

                        </div>
                        

                        
                      </div>  
                    </div>

                  </div>
                  <!-- END PAGE CONTENT-->
                </div>

                
              </div>
              <!-- END CONTENT -->

              <!-- BEGIN FOOTER -->
              <?php require("../../includes/views/footer_admin.php"); ?>
              <!-- END FOOTER -->
            </body>

            <!-- END BODY -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js"></script>
            </html>

            <?php
//Clear all the Message Session Variables...
            if (isset($_SESSION['returnmessage'])) {
              unset($_SESSION['returnmessage']);
            }
            ?>

