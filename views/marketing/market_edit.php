<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/markets.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Market Page");
$page->setTag_line("Market View Page");
$page->setMenu_active("Market_view");
$page->setMenu_group("Marketing_Department");

$markets = new DealerMarket();

date_default_timezone_set('America/New_York');
@$today = date('Y-m-d');

if(isset($_GET['iid'])){
    
$iid = $_GET['iid'];
$delete = $markets->DeleteMarket($iid);  

if ($delete=1) {
     header('Location: market_view?iiid='.$delete);
}
    
}else{

$id = $_GET['id'];
$details = $markets->viewSelectedMarket($id);  


if (isset($_POST['update'])) {
	
    $market_name    = filter_input(INPUT_POST, 'market_name', FILTER_SANITIZE_STRING);
    
    $msg = $markets->updateMarket($market_name,$id);
            
   if ($msg=1) {
       header('Location: market_view?iid='.$msg);
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
	$("#commentForm").validate({ //common validation start
            rules:  {
                        market_name  : "required",
                    },

           messages: {
                        market_name  : "Enter Market.",
                      }
        }); ///common validation end

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
											<i class="fa fa-gift"></i>Update Market
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
											
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                           
                                                                                
                                                                                <form id="commentForm" class="form-horizontal" name ="update_market" action="" method="post" enctype="multipart/form-data"> 
											<div class="form-body" >
                                                                                            
                                                                                            <div class="row">   
                                                                                                <div class="col-md-12">
                                                                                                        <div class="form-group">
                                                                                                                <label class="control-label col-md-2">Market : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                <div class="col-md-5">
                                                                                                                    <input type="text" name="market_name" id="market_name" class="form-control" value="<?php echo $details['market_name']; ?>">
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
																<button type="submit" class="btn blue-madison" id="update" name="update">Update</button>
                                                                                                                                <input type="reset"  class="btn default" name="reset" id="reset" value="Reset" />
                                                                                                                                <a href="market_view" class="btn default" style="text-decoration:none;" >Cancel</a>
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