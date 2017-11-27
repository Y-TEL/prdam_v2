<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/pro_updates.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Product View");
$page->setTag_line("Product_View Page");
$page->setMenu_active("View_Pro_updates_Page");
$page->setMenu_group("Marketing_Department");

$productList = new Product();

date_default_timezone_set('America/New_York');
@$today = date('d-m-Y');

$drop_downs = new DropDownlist();
$drop_down_user_dept = $drop_downs->getAllDepartment();

//To Insert Gallery				
$path = "../../uploads/pro_updates/";
$valid_formats = array("jpg", "png", "gif","JPG");
if (isset($_POST['add'])) { 
if(!empty($_FILES['avatar']["name"]) ){

   	//$old_image = $_POST['old_image'];
   	$name = $_FILES['avatar']['name'];
   	$size = $_FILES['avatar']['size'];
	if(strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats)) {
			if($size<(3264*2448)) {
				
			// getting file extension
			$uploadedfile = $_FILES['avatar']['name'];
			$names = explode(".",basename($uploadedfile));
			$namess = $names[1]; // rhis is file extension
			
			// uploading main pic from here
			$target_path = "../../uploads/pro_updates/" . basename( $_FILES['avatar']['name']); 	
			if(move_uploaded_file($_FILES['avatar']['tmp_name'], $target_path)) {
				$mainimages = basename($_FILES['avatar']['name']);	
			}
			$thistime = md5(time());
			rename("../../uploads/pro_updates/$mainimages", "../../uploads/pro_updates/$thistime.$namess");
			$imagename = "../../uploads/pro_updates/$thistime.$namess";
			$image = "$thistime.$namess";
			$_SESSION['image']=$image;
									
                        }else{
			echo "Image file size max 250k";					
                        }
		 
		} else {
		echo "Invalid file format..";	 
		} 
                
	}  else {
  	echo "Please select image..!";
  	exit;
	}
}
}

if (isset($_POST['add'])) {
	
    $news = $_POST['news'];
    $subject     = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $department  = filter_input(INPUT_POST, 'department', FILTER_SANITIZE_STRING);
    if(isset($_SESSION['image'])){ $news_image = $_SESSION['image']; }else { $news_image = "";}
    $entered_by   = $_SESSION['user_calling_name'];
    $created_date = date('m-d-Y');
    $created_time = date('h:i a');
   
    $msg = $productList->addNewProduct($news,$subject,$department,$news_image,$entered_by,$created_date,$created_time);
    
    if ($msg=1) { 
        header('Location: pro_updates_view?id='.$msg);
	}
   
}
 

?>
<!DOCTYPE html>

<html lang="en">

<head>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>

<!-- class head -->
   <?php require("../../includes/views/head.php") ?>
<!-- class head -->


<link href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-fileinput-master/js/fileinput_locale_fr.js" type="text/javascript"></script>

<style>
.preview1
{
width:150px;
border:solid 1px #dedede;
padding:4px;
height:150px;
}
</style>
<style>
    .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar .file-input {
        display: table-cell;
        max-width: 220px;
    }
</style>
<script>
	$(document).ready(function(){ 
	$("#commentForm").validate({ //common validation start
            rules:  {
                        news             : "required",
                        subject          : "required",
                        department       : "required",
                        
                    },

           messages: {
                        news             : "Enter Description.",
                        subject          : "Enter Subject.",
                        department       : "Select Department.",

                      }
        }); ///common validation end

 });
 
</script>

<script>
jQuery(function() {    
    
    /***********************  front image preview **********************************************************/
    jQuery("#imagePreview").hide();
    jQuery("#imagePreview3").show();

    jQuery("#large_image").on("change", function() {
    jQuery("#imagePreview3").hide();
    jQuery("#imagePreview").show();

        // alert('hi');
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader)
            return; // no file selected, or no FileReader support

        if (/^image/.test(files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function() { // set image data as background of div
                jQuery("#imagePreview").css("background-image", "url(" + this.result + ")");
            }
        }
    });
    /***********************  end ************************************************************************/
            
    });     
</script>

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

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
			<div id="hide"><?php include ("../../includes/views/messager.php"); //Display  Messages for Entered Data  ?></div>
            		<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
                        <div class="row">
				<div class="col-md-12">
					<div class="tabbable tabbable-custom boxless tabbable-reversed">
						
						  <div class="tab-pane active" id="tab_2">
								<div class="portlet box green">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Add Product Update
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                                
                                                                                <form id="commentForm" class="form-horizontal form-bordered" name ="add_news" action="" method="post" enctype="multipart/form-data"> 
											<div class="form-body" >
                                                                                                
                                                                                                <div class="row">   
                                                                                                <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                        <label class="control-label col-md-2">Image : </label>
                                                                                                        <div class="col-md-5">

                                                                                                         <div class="row fileupload-buttonbar">

                                                                                                            <div class="col-md-5" style=" margin-left: 30px;">

                                                                                                                <!-- the avatar markup -->
                                                                                                            <div id="kv-avatar-errors" class="center-block" style="width:620px; display:none"></div>
                                                                                                            <div class="kv-avatar center-block" style="width:300px">
                                                                                                                <input id="avatar" name="avatar" type="file" class="file-loading">
                                                                                                            </div>
                                                                                                            <script>
                                                                                                               
                                                                                                                var btnCust = "";

                                                                                                                jQuery("#avatar").fileinput({
                                                                                                                    overwriteInitial: true,
                                                                                                                    maxFileSize: 1500,
                                                                                                                    showClose: false,
                                                                                                                    showCaption: false,
                                                                                                                    browseLabel: ' Browse',
                                                                                                                    removeLabel: ' Close',
                                                                                                                    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
                                                                                                                    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                                                                                                                    removeTitle: 'Cancel or reset changes',
                                                                                                                    elErrorContainer: '#kv-avatar-errors',
                                                                                                                    msgErrorClass: 'alert alert-block alert-danger',
                                                                                                                    defaultPreviewContent: '<img src="<?php echo SITEURL ?>/assets/resources/images/default_news.png" alt="Your Avatar" style="width:170px">',
                                                                                                                    layoutTemplates: {main2: '{preview} ' + btnCust + ' {remove} {browse}'},
                                                                                                                    allowedFileExtensions: ["jpg", "png", "gif"]
                                                                                                                });
                                                                                                            </script>

                                                                                                            </div>

                                                                                                        </div>

                                                                                                       </div>

                                                                                                    </div>
                                                                                                    </div>
                                                                                                    <!--/span-->
                                                                                                </div>
                                                                                                
                                                                                                <div class="row">   
                                                                                                        <div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-2">Department : <span style="font-size:14px; color:#D90000;" >*</span></label>
															<div class="col-md-5">
                                                                                                                            <select name="department" id="department" class="form-control" required="">
                                                                                                                                <option value="" selected="true" disabled="true">Select</option>
                                                                                                                                <?php  foreach ($drop_down_user_dept as $value) {?>
                                                                                                                                <option value="<?php echo $value['dep_name'];?>"><?php echo $value['dep_name'];?></option>
                                                                                                                                <?php }?>
                                                                                                                            </select>
															</div>
														</div>
													</div>
													<!--/span-->
                                                                                                  </div>
                                                                                                <!--/row-->
                                                                                                
                                                                                                <div class="row">   
                                                                                                        <div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-2">Subject : <span style="font-size:14px; color:#D90000;" >*</span></label>
															<div class="col-md-5">
                                                                                                                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject" value="">
															</div>
														</div>
													</div>
													<!--/span-->
                                                                                                  </div>
                                                                                                <!--/row-->
                                                                                                
                                                                                                <div class="row">   
                                                                                                        <div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-2">Description : <span style="font-size:14px; color:#D90000;" >*</span></label>
															<div class="col-md-10">
                                                                                                                            <textarea class="ckeditor form-control" rows='5' id="news" name="news"></textarea>
															</div>
														</div>
													</div>
													<!--/span-->
                                                                                                  </div>
                                                                                                <!--/row-->
                                                                                                
                                                                                                
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-offset-2 col-md-8">
																<button type="submit" name="add" class="btn green">Submit</button>
                                                                                                                                <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
                                                                                                                                <a href="pro_updates_view" class="btn default" style="text-decoration:none;" >Cancel</a>
															</div>
														</div>
													</div>
													<div class="col-md-6">
													</div>
												</div>
											</div>
                                                                                </form><!-- END FORM-->
                                                                              </div>
										
							</div>
						  </div>
					  
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

<?php
//Clear all the Message Session Variables...
if(isset($_SESSION['returnmessage'])) { unset($_SESSION['returnmessage']);}
?>
 
</body>

<!-- END BODY -->
</html>