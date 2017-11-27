<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dep_updates.php';
$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Dep Updates View");
$page->setTag_line("Dep_Updates_Page");
$page->setMenu_active("View_Dep_Update_Page");
$page->setMenu_group("Marketing_Department");

$depupdates = new DepUpdates();

date_default_timezone_set('America/New_York');
@$today = date('Y-m-d');

$drop_downs = new DropDownlist();
$drop_down_user_dept = $drop_downs->getAllDepartment();

$id = $_GET['id'];
$details = $depupdates->viewSelectedDepUpdates($id);  

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
<!--Image Upload-->
<link href="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-fileinput-master/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-fileinput-master/js/fileinput_locale_fr.js" type="text/javascript"></script>
<script src="<?php echo SITEURL ?>/assets/global/plugins/js/bootstrap-fileinput-master/fileinput_locale_es.js" type="text/javascript"></script>
<!--Image Upload-->

<style>
.succeses {
   color: #35AA47;	
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
jQuery(function() {    
   
    /***********************  front image preview **********************************************************/
    jQuery("#imagePreview").hide();
    
    jQuery("#large_image").on("change", function() {
    jQuery("#imagePreview3").hide();
    jQuery("#imagePreview").show();

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
								<div class="portlet box blue-madison">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Update Department Updates
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                                
                                                                                <form id="commentForm" class="form-horizontal" name ="edit_dep_updates" action="" method="post" enctype="multipart/form-data"> 
											<div class="form-body" >
                                                                                                
                                                                                                <div class="row">   
                                                                                                <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                        <label class="control-label col-md-2">Image : </label>
                                                                                                        <div class="col-md-5">
                                                                                                            
                                                                                                            <div class="fileinput-new thumbnail" style="width:150px;height:160px;margin:0px 11px 0px 11px; ">
                                                                                                                <?php if($details['dep_updates_image']!=NULL){ ?>
                                                                                                                <img src="<?php echo SITEURL ?>/uploads/dep_update/<?php echo $details['dep_updates_image'] ?>" alt="" width='150px' height='150px' align='left' />
                                                                                                                <?php }else{ ?>
                                                                                                                <img src="<?php echo SITEURL ?>/assets/resources/images/default_news.png" alt="" width='150px' height='150px' align='left' />
                                                                                                                <?php } ?>  
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
                                                                                                                            <label class="control-label-left"><?php echo $details['dep_name']; ?></label>
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
                                                                                                                            <label class="control-label-left"><?php echo $details['dep_updates_subject']; ?></label>
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
                                                                                                                            <label class="control-label-left"><?php echo $details['dep_updates_body']; ?></label> 
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
																
                                                                                                                                <a href="../main/index.php" class="btn default" style="text-decoration:none;" >Cancel</a>
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

<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/plugins/ckeditor/ckeditor.js"></script>

<?php
//Clear all the Message Session Variables...
if(isset($_SESSION['returnmessage'])) { unset($_SESSION['returnmessage']);}
?>
 
</body>

<!-- END BODY -->
</html>
