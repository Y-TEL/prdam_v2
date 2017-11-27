<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/carrier.php';
$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("View_All_Carrier");
$page->setTag_line("View_Carrier");
$page->setMenu_active("Carrier_Page");
$page->setMenu_group("Marketing_Department");

$carrier = new Carrier();

if(isset($_GET['iid'])){
    
$iid = $_GET['iid'];
$delete = $carrier->DeleteCarrier($iid);  

if ($delete=1) {
    header('Location: carrier_view?iiid='.$delete);
}
    
}else{

$id = $_GET['id'];
$details = $carrier->viewSelectedCarrier($id);                            

//To Insert Gallery				
$path = "../../uploads/carriers/";
$valid_formats = array("jpg", "png", "gif","JPG");
if(isset($_POST['add_photo']) ){

   	//$old_image = $_POST['old_image'];
   	$name = $_FILES['large_image']['name'];
   	$size = $_FILES['large_image']['size'];
	if(strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		if(in_array($ext,$valid_formats)) {
			if($size<(3264*2448)) {
				
			// getting file extension
			$uploadedfile = $_FILES['large_image']['name'];
			$names = explode(".",basename($uploadedfile));
			$namess = $names[1]; // rhis is file extension
			
			// uploading main pic from here
			$target_path = "../../uploads/carriers/" . basename( $_FILES['large_image']['name']); 	
			if(move_uploaded_file($_FILES['large_image']['tmp_name'], $target_path)) {
				$mainimages = basename($_FILES['large_image']['name']);	
			}
			$thistime = md5(time());
			rename("../../uploads/carriers/$mainimages", "../../uploads/carriers/$thistime.$namess");
			$imagename = "../../uploads/carriers/$thistime.$namess";
			$image = "$thistime.$namess";
			$_SESSION['image']=$image;
				//------------------------------
				
				// for big size thumh
				$thumbheights = '115';
				$thumbwidths = '200';
				
				// creating another big size thumbnail		
				$mainimage = imagecreatefromjpeg($imagename);	//imagecreatefromjpeg($imagename);		
				$mainwidth = imagesx($mainimage);
				$mainheight = imagesy($mainimage);	
				
				if ($mainwidth == '$mainheight') {
					$arkowidth = $mainheight / $thumbheights;
					$thumbwidths = $mainwidth / $arkowidth;
					$thumbwidths  = ceil($thumbwidths );
				} elseif ($mainwidth > $mainheight) {
					$arkoheight = $mainwidth / $thumbwidths;
					$thumbheights = $mainheight / $arkoheight;
					$thumbheights = ceil($thumbheights);
				} elseif ($mainwidth < $mainheight) {
					$arkowidth = $mainheight / $thumbheights;
					$thumbwidths = $mainwidth / $arkowidth;
					$thumbwidths  = ceil($thumbwidths );	
				}
				$mythumb = imagecreatetruecolor($thumbwidths, $thumbheights);
				$mythumbimg = imagecopyresampled($mythumb, $mainimage, 0, 0, 0, 0, $thumbwidths, $thumbheights, $mainwidth, $mainheight);
				$filename = "../../uploads/carriers/thumbs/". $thistime.".".$namess; // uploaded to t folder
				imagejpeg($mythumb,$filename,100);
									
		 }	else  {
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


if (isset($_POST['update'])) {
	
    $carrier_name = filter_input(INPUT_POST, 'carrier_name', FILTER_SANITIZE_STRING);
    $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
	
    if(isset($_SESSION['image'])){ 
        $carrier_image = $_SESSION['image'];
    }else{
             if($details['carrier_image']!=NULL){  
               $carrier_image = $details['carrier_image'];
               }else { $carrier_image = "";}
    }
            
	$msg = $carrier->UpdateCarrier($carrier_name,$desc,$carrier_image, $id);
            
   if ($msg=1) {
       header('Location: carrier_view?id='.$msg);
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

<script>
        $(document).ready(function(){
            $("#commentForm").validate({
                rules :
                        {
                         
                          carrier_name        : "required",
                        },
              messages:  
                        {
                         
                         carrier_name          : "Enter Carrier Name",
                        }
            });
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
								<div class="portlet box blue-madison">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Edit Carrier Form
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                                        <form id="form_1" class="form-horizontal" name ="add_dep_updates_img" action="" method="post" enctype="multipart/form-data">    
                                                                                            <div class="form-body" >
                                                                                                <div class="row">   
                                                                                                    <div class="col-md-12">
                                                                                                    <div class="form-group">
                                                                                                            <label class="control-label col-md-4">Image : </label>
                                                                                                            <div class="col-md-5">

                                                                                                            <div class="fileinput fileinput-new" data-provides="fileinput">

                                                                                                               <div class="fileinput-new thumbnail" style="width: 210px; height: 125px;">
                                                                                                                <?php
                                                                                                                 if (isset($_SESSION['image'])){ ?>
                                                                                                                 <div id="message"><?php echo "<img src='".SITEURL."/uploads/carriers/".$_SESSION['image']."'  class='img-polaroid' width='200px' height='115px' align='left'>"; ?></div>
                                                                                                                 <?php }elseif ($details['carrier_image']!=NULL){ ?>
                                                                                                                 <?php echo "<img src='".SITEURL."/uploads/carriers/".$details['carrier_image']."'  class='img-polaroid' width='200px' height='115px' align='left'>"; ?>
                                                                                                                 <?php }else{ ?>      
                                                                                                                 <img src="<?php echo SITEURL ?>/assets/resources/images/default_carrier.png" alt="" class="img-polaroid" width='200px' height='115px' align='left' />
                                                                                                                 <?php } ?>   
                                                                                                              </div>

                                                                                                         <div class="widgetbox profile-photo">

                                                                                                            <div id="list_view" style="margin: 5px 0px 5px 0px;" >
                                                                                                            <table>
                                                                                                              <tr>
                                                                                                                <td> 
                                                                                                                    <span class="btn green fileinput-button" style="margin-right:10px;">
                                                                                                                    <input type="file" name="large_image" id="large_image"/>
                                                                                                                    </span>
                                                                                                                </td> 
                                                                                                                <td><input type="submit" id="add_photo"  name="add_photo" value="Add Image" class="btn btn-primary"/></td>
                                                                                                              </tr>
                                                                                                            </table>
                                                                                                            </div>

                                                                                                          <div id="uploader"></div> 

                                                                                                           </div>
                                                                                                            </div>
                                                                                                           </div>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
                                                                                                  </div>
                                                                                                <!--/row-->
                                                                                            </div>
                                                                                        </form>
                                                                                
                                                                                        <form id="commentForm" class="form-horizontal" name ="add_new_activation" action="" method="post" enctype="multipart/form-data"> 
                                                                                        <div class="form-body" >
                                                                                                    
                                                                                                    <div class="row">
                                                                                                    
                                                                                                        <div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Carrier Name <span style="font-size:14px; color:#D90000;" >*</span> :</label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <input type="text" name="carrier_name" id="carrier_name" class="form-control" value="<?php echo $details['carrier_name']; ?>">
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
                                                                                                  </div>
												<!--/row-->
                                                                                                
                                                                                                <div class="row">
													<div class="col-md-12">
                                                                                                                <div class="form-group">
                                                                                                                        <label class="control-label col-md-4">Description : </label>
                                                                                                                        <div class="col-md-4">
                                                                                                                            <textarea class="form-control" rows='5' id="desc" name="desc"><?php echo $details['carrier_desc']; ?></textarea>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <!--/span-->
												  </div>
												<!--/row-->
												<!--/row-->
                                                                                                
                                                                                                
											</div>
											<div class="form-actions">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-offset-4 col-md-8">
																<button type="submit" class="btn blue-madison" id="update" name="update">Update</button>
                                                                                                                                <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
                                                                                                                                <a href="carrier_view" class="btn default" style="text-decoration:none;" >Cancel</a>
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
<?php } ?>