<?php
/**
 * Description of User
 * @author Nirushika
 */
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/market_allocation.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Market Allocation Page");
$page->setTag_line("Market Allocation View Page");
$page->setMenu_active("Market_Allocation_view");
$page->setMenu_group("Marketing_Department");

$market = new Market();

date_default_timezone_set('America/New_York');
@$today = date('d-m-Y');

########### DROP DOWNS ############
$drop_downs = new DropDownlist();
$drop_down_acc_manager      = $drop_downs->getAllAccManagers();
$drop_down_regional_manager  = $drop_downs->getAllRegionalManager();
$drop_down_ME                = $drop_downs->getAllME();
$drop_down_supervisor        = $drop_downs->getAllSupervisor();
$drop_down_marketing_user    = $drop_downs->getAllMarketingUser();
$drop_down_assistant_manager = $drop_downs->getAllSLManager();
$drop_down_region            = $drop_downs->getRegion();
########### END ###################

if (isset($_POST['add'])) {
	
    $market_name              = filter_input(INPUT_POST, 'market_name', FILTER_SANITIZE_STRING);
    $market_RM                = filter_input(INPUT_POST, 'market_RM', FILTER_SANITIZE_STRING);
    $market_region            = filter_input(INPUT_POST, 'market_region', FILTER_SANITIZE_STRING);
    $market_territory         = filter_input(INPUT_POST, 'market_territory', FILTER_SANITIZE_STRING);
    $market_territory_code    = filter_input(INPUT_POST, 'market_territory_code', FILTER_SANITIZE_STRING);
    $market_ACM               = filter_input(INPUT_POST, 'market_ACM', FILTER_SANITIZE_STRING);
    $market_assistant_manager = filter_input(INPUT_POST, 'market_assistant_manager', FILTER_SANITIZE_STRING);
    $market_supervisor        = filter_input(INPUT_POST, 'market_supervisor', FILTER_SANITIZE_STRING);
    $market_mark_exe          = filter_input(INPUT_POST, 'market_mark_exe', FILTER_SANITIZE_STRING);
    $market_type              = filter_input(INPUT_POST, 'market_type', FILTER_SANITIZE_STRING);
    $market_active_dealers    = filter_input(INPUT_POST, 'market_active_dealers', FILTER_SANITIZE_STRING);
    $market_inactive_dealers  = filter_input(INPUT_POST, 'market_inactive_dealers', FILTER_SANITIZE_STRING);
   
    $msg = $market->addMarket($market_name,$market_RM,$market_region,$market_territory,$market_territory_code,$market_ACM,$market_assistant_manager,$market_supervisor,$market_mark_exe,$market_type,$market_active_dealers,$market_inactive_dealers);
    
    if ($msg=1) { 
        header('Location: market_allocation_structure?id='.$msg);
    }
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/select2/select2.css"/>
<!-- class head -->
   <?php require("../../includes/views/head.php") ?>
<!-- class head -->

<style>
.succeses {
  color: #35AA47;	
}  
</style>
<script>
	$(document).ready(function(){ 
	$("#commentForm").validate({ //common validation start
            
        }); ///common validation end
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
								<div class="portlet box green">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-gift"></i>Add New Market
										</div>
										<div class="tools">* Mandatory fields
											<a href="javascript:;" class="reload">
											</a>
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
                                                                                
                                                                                <form id="commentForm" class="form-horizontal" name ="add_market" action="" method="post" enctype="multipart/form-data"> 
											<div class="form-body" >
                                                                                                                                                                                                
                                                                                            <div class="row">   
                                                                                                    <div class="col-md-12">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-3">Market : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-4">
                                                                                                                        <input type="text" name="market_name" id="market_name" class="form-control" required="">
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <!--/span-->
                                                                                            </div>
                                                                                            <!--/row-->
                                                                                                
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label col-md-3">Regional Manager(RM) <span class="required"> * </span> :</label>
                                                                                                        <div class="col-md-4">
                                                                                                            <select name="market_RM" id="market_RM" class="form-control select2me">
                                                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                                                <?php foreach ($drop_down_regional_manager as $value) { ?>
                                                                                                                    <option value="<?php echo $value['user_id']; ?>"><?php echo $value['user_calling_name']; ?></option>
                                                                                                                <?php } ?>
                                                                                                            </select>  
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                                
                                                                                                
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label col-md-3">Region <span class="required"> * </span> :</label>
                                                                                                        <div class="col-md-4">
                                                                                                            <select name="market_region" id="market_region" class="form-control" required>
                                                                                                            <option value="" selected="true" disabled="true">Select</option>
                                                                                                            <?php foreach ($drop_down_region as $values) { ?>
                                                                                                                    <option value="<?php echo $values; ?>"><?php echo $values; ?></option>
                                                                                                            <?php } ?>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label col-md-3">Territory <span class="required"> * </span> :</label>
                                                                                                        <div class="col-md-4">
                                                                                                            <select name="market_territory" id="market_territory" class="form-control" required>
                                                                                                            <option value="" selected="true" disabled="true">Select</option>
                                                                                                            <option value="TEXAS">TEXAS</option>
                                                                                                            <option value="CALIFORNIA">CALIFORNIA</option>
                                                                                                            <option value="NY & NJ">NY & NJ</option>
                                                                                                            <option value="UPSTATE NY">UPSTATE NY</option>
                                                                                                            <option value="NEW ENGLAND">NEW ENGLAND</option>
                                                                                                            <option value="VERMONT NH">VERMONT NH</option>
                                                                                                            <option value="OHIO">OHIO</option>
                                                                                                            <option value="PENNSYLVANIA">PENNSYLVANIA</option>
                                                                                                            <option value="FLORIDA">FLORIDA</option>
                                                                                                            <option value="DISTRICT OF COLUMBIA">DISTRICT OF COLUMBIA</option>
                                                                                                            <option value="EAST SOUTH CENTRAL TN">EAST SOUTH CENTRAL TN</option>
                                                                                                            <option value="SOUTH ATLANTIC NC SC GA">SOUTH ATLANTIC NC SC GA</option>
                                                                                                            <option value="WEST NORTH CENTRAL MN">WEST NORTH CENTRAL MN</option>
                                                                                                            <option value="ILLINOIS">ILLINOIS</option>
                                                                                                            <option value="MOUNTAIN AZ">MOUNTAIN AZ</option>
                                                                                                            <option value="PACIFIC WA">PACIFIC WA</option>
                                                                                                            <option value="PUERTO RICO">PUERTO RICO</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label col-md-3">Territory Code <span class="required"> * </span> :</label>
                                                                                                        <div class="col-md-4">
                                                                                                            <select name="market_territory_code" id="market_territory_code" class="form-control" required>
                                                                                                            <option value="" selected="true" disabled="true">Select</option>
                                                                                                            <option value="TEXAS">TEXAS</option>
                                                                                                            <option value="CALIFORNIA">CALIFORNIA</option>
                                                                                                            <option value="NY & NJ">NY & NJ</option>
                                                                                                            <option value="UPST NY">UPST NY</option>
                                                                                                            <option value="NEW ENG">NEW ENG</option>
                                                                                                            <option value="VERMONT NH">VERMONT NH</option>
                                                                                                            <option value="OHIO">OHIO</option>
                                                                                                            <option value="PA">PA</option>
                                                                                                            <option value="FLORIDA">FLORIDA</option>
                                                                                                            <option value="DC">DC</option>
                                                                                                            <option value="ES CENT TN">ES CENT TN</option>
                                                                                                            <option value="S ATL">S ATL</option>
                                                                                                            <option value="WN CENT MN">WN CENT MN</option>
                                                                                                            <option value="ILLINOIS">ILLINOIS</option>
                                                                                                            <option value="MOUNT AZ">MOUNT AZ</option>
                                                                                                            <option value="PACIFIC WA">PACIFIC WA</option>
                                                                                                            <option value="PR">PR</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label col-md-3">Account Manager(ACM) :</label>
                                                                                                        <div class="col-md-4">
                                                                                                            <select name="market_ACM" id="market_ACM" class="form-control select2me">
                                                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                                                <?php foreach ($drop_down_acc_manager as $value) { ?>
                                                                                                                    <option value="<?php echo $value['user_id']; ?>"><?php echo $value['user_calling_name']; ?></option><?php } ?>
                                                                                                            </select>  
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label col-md-3">Assistant Manager (AM) :</label>
                                                                                                        <div class="col-md-4">
                                                                                                            <select name="market_assistant_manager" id="market_assistant_manager" class="form-control select2me">
                                                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                                                <?php foreach ($drop_down_assistant_manager as $value) { ?>
                                                                                                                    <option value="<?php echo $value['user_id']; ?>"><?php echo $value['user_calling_name']; ?></option><?php } ?>
                                                                                                            </select>  
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label col-md-3">Supervisor :</label>
                                                                                                        <div class="col-md-4">
                                                                                                            <select name="market_supervisor" id="market_supervisor" class="form-control select2me">
                                                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                                                <?php foreach ($drop_down_supervisor as $value) { ?>
                                                                                                                <option value="<?php echo $value['user_id']; ?>"><?php echo $value['user_calling_name']; ?></option><?php } ?>
                                                                                                            </select>  
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label col-md-3">Marketing Executive(ME) :</label>
                                                                                                        <div class="col-md-4">
                                                                                                            <select name="market_mark_exe" id="market_mark_exe" class="form-control select2me">
                                                                                                                <option value="" selected="true" disabled="true">SELECT</option>
                                                                                                                <?php foreach ($drop_down_ME as $value) { ?>
                                                                                                                <option value="<?php echo $value['user_id']; ?>"><?php echo $value['user_calling_name']; ?></option><?php } ?>
                                                                                                            </select>  
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <div class="form-group">
                                                                                                        <label class="control-label col-md-3">Market Type <span class="required"> * </span> :</label>
                                                                                                        <div class="col-md-4">
                                                                                                            <select name="market_type" id="market_type" class="form-control" required>
                                                                                                            <option value="" selected="true" disabled="true">Select</option>
                                                                                                            <option value="REMOTE">REMOTE</option>
                                                                                                            <option value="REPRESENTED">REPRESENTED</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="row">   
                                                                                                    <div class="col-md-12">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-3">Active Dealers : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-4">
                                                                                                                        <input type="number" name="market_active_dealers" id="market_active_dealers" class="form-control" required="">
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <!--/span-->
                                                                                            </div>
                                                                                            <!--/row-->
                                                                                            
                                                                                            <div class="row">   
                                                                                                    <div class="col-md-12">
                                                                                                            <div class="form-group">
                                                                                                                    <label class="control-label col-md-3">Inactive Dealers : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                                                                    <div class="col-md-4">
                                                                                                                        <input type="number" name="market_inactive_dealers" id="market_inactive_dealers" class="form-control" required="">
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
                                                                                                                                <a href="market_allocation_structure" class="btn default" style="text-decoration:none;" >Cancel</a>
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