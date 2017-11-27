<?php
##############################################
## @DESCRIPTION : DEALER LIST 
## @AUTHOR      : JALIYA LAMAHEWA
## @MODULE      : MARKETING
##############################################

session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer.php';

########### AUTHENTICATION CHECK #############
$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}
########### END ##############################
########### PAGE NAVIGATION SETUP ############
$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Other_Add_Page");
$page->setTag_line("User_View");
$page->setMenu_active("dealer_detail_add");
$page->setMenu_group("Dealers_page");
########### END NAVIGATION SETUP #############

date_default_timezone_set('America/New_York');
@$today = date('Y-m-d');

if(isset($_SESSION['image'])){unset($_SESSION['image']);}

$dealer = new Dealer();

 if (isset($_SESSION['user_permissions']['Dealer_view_all']) && ($_SESSION['user_permissions']['Dealer_view_all'] == '1')){

$dealer_list = $dealer->viewDealerList();
//$distributor_list = $dealer->viewDistrubutorList();
//$mom_pop_list = $dealer->viewMomPopList();

} else {
$user_id = $_SESSION['user_id'];    
$dealer_list = $dealer->viewMyDealerList($user_id);
//$distributor_list = $dealer->viewMyDistrubutorList($user_id);
//$mom_pop_list = $dealer->viewMyMomPopList($user_id);   
}
 
if (isset($_GET['id'])) {
    $add = $_GET['id'];
    if ($add = 1) {
        // : RETURN MESSAGE.
        $returnmessage = array();
        array_push($returnmessage, array("type" => "success")); //succes | warning | error | information
        array_push($returnmessage, array("message" => SUCCESS));
        $_SESSION['returnmessage'] = $returnmessage;
    } else {
        // : RETURN MESSAGE.
        $returnmessage = array();
        array_push($returnmessage, array("type" => "error"));  //succes | warning | error | information
        array_push($returnmessage, array("message" => ERROR));
        $_SESSION['returnmessage'] = $returnmessage;
    }
}

if (isset($_GET['iid'])) {
    $update = $_GET['iid'];
    if ($update = 1) {
        // : RETURN MESSAGE.
        $returnmessage = array();
        array_push($returnmessage, array("type" => "information"));  //succes | warning | error | information
        array_push($returnmessage, array("message" => UPDATE));
        $_SESSION['returnmessage'] = $returnmessage;
    } else {
        // : RETURN MESSAGE.
        $returnmessage = array();
        array_push($returnmessage, array("type" => "stop"));  //succes | warning | error | information
        array_push($returnmessage, array("message" => ERROR));
        $_SESSION['returnmessage'] = $returnmessage;
    }
}

if (isset($_GET['iiid'])) {
    $delete = $_GET['iiid'];
    if ($delete = 1) {
        // : RETURN MESSAGE.
        $returnmessage = array();
        array_push($returnmessage, array("type" => "information"));  //succes | warning | error | information
        array_push($returnmessage, array("message" => DELETE));
        $_SESSION['returnmessage'] = $returnmessage;
    } else {
        // : RETURN MESSAGE.
        $returnmessage = array();
        array_push($returnmessage, array("type" => "error"));  //succes | warning | error | information
        array_push($returnmessage, array("message" => ERROR));
        $_SESSION['returnmessage'] = $returnmessage;
    }
}
?>
<!DOCTYPE html>

<html lang="en">
<script type="text/javascript">
    
function myFunction() {
window.location.href = 'dealer_list_exp_excel.php';
}
</script>

<head>

    <!-- class head -->
    <?php require("../../includes/views/head_1.php") ?>
    <!-- class head -->

    <style>
        .fixed-width{width:90px;text-align: center}

    </style>

    <script src="//code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            $('table.display').DataTable();
        });
    </script>

</head>

        <!-- BEGIN HEADER -->
        <div>
            <?php require("../../includes/views/header_admin.php"); ?>
        </div>
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

                    <div id="hide"><?php include ("../../includes/views/messager.php"); //Display  Messages for Entered Data          ?></div>
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-user"></i>View Dealers
                                    </div>
                                    <div class="tools">
                                        <?php if(($_SESSION['user_id']=="47")||($_SESSION['user_id']=="49")||($_SESSION['user_name']=="paperwork@jayscomm.com")){ ?>
                                        <a href="dealer_detail_add" class="btn-default" style="text-decoration:none; height: 30px;" >
                                            <li class="glyphicon glyphicon-plus"></li> Add New</a>
                                        <?php } ?>
                                    </div>
                                </div>				
                                
                                                <div class="portlet-body">
                                                    <div class="table-toolbar">
								<div class="row">
									
									<div class="col-md-6">
										<div class="btn-group pull-left">
										<button class="btn dropdown-toggle" onClick="myFunction()" data-toggle="dropdown">Export to Excel 
										</button>
										</div>
									</div>
                                                                </div>
							</div>
                                                    
                                                    <table class="table display table-striped table-hover table-bordered">
                                                        <thead>
                                                            <tr class="warning">
                                                                <th>
                                                                    NO
                                                                </th>
                                                                <th>
                                                                    Dealer Type 
                                                                </th>
                                                                <th>
                                                                    Dealer Code 
                                                                </th>
                                                                <th>
                                                                    BL Code
                                                                </th>
                                                                <th>
                                                                    Store Name   
                                                                </th>
                                                                <th>
                                                                    ME  
                                                                </th>
                                                                <th>
                                                                    ACM   
                                                                </th>
                                                                <th>
                                                                    RM   
                                                                </th>
                                                                <th>
                                                                    Status   
                                                                </th>
                                                                <th class="fixed-width">Option
                                                                </th>
                                                                <th>Place Order
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($dealer_list as $data) {
                                                                $ME= $data['dealer_marketing_exe'];
                                                                $value = $dealer->selectDealerME($ME);
                                                                
                                                                $ACM= $data['dealer_area_manager'];
                                                                $values = $dealer->selectDealerACM($ACM);
                                                                
                                                                $RM= $data['dealer_regional_manager'];
                                                                $valuess = $dealer->selectDealerRM($RM);
                                                                ?>   
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['cus_type_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_code']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_bl_code']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_store_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $value['user_calling_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $values['user_calling_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $valuess['user_calling_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                         <?php if($data['dealer_active']== 1){ ?> 
                                                                            <span class="label label-success">Approved</span>
                                                                         <?php }else if($data['dealer_active']== 0){ ?> 
                                                                            <span class="label label-danger">Blocked</span>
                                                                        <?php }else if($data['dealer_active']== 2){ ?> 
                                                                            <span class="label label-sm label-info">Pending 
                                                                            <?php if(($_SESSION['user_id']=="47")||($_SESSION['user_id']=="49")||($_SESSION['user_name']=="paperwork@jayscomm.com")){ ?>    
                                                                            <a title="Verify" href="dealer_verify.php?id=<?php echo $data['dealer_id']; ?>" class="btn btn-xs yellow btn-editable"> 
                                                                            <li class="glyphicon glyphicon-check"></li></a>
                                                                            <?php } ?>
                                                                            </span>
                                                                        <?php }else{ ?> 
                                                                        <?php }?>
                                                                       
                                                                    </td>
                                                                    <td>
                                                                        <a title="View" href="dealer_detail_view.php?id=<?php echo $data['dealer_id']; ?>"  class="btn btn-xs default btn-editable">
                                                                            <li class="glyphicon glyphicon-eye-open"></li></a>
                                                                            
                                                                        <?php if(($_SESSION['user_id']=="47")||($_SESSION['user_id']=="49")||($_SESSION['user_name']=="paperwork@jayscomm.com")){ ?>
                                                                        <a title="Edit" href="dealer_edit.php?id=<?php echo $data['dealer_id']; ?>"  class="btn btn-xs default btn-editable"> 
                                                                            <li class="glyphicon glyphicon-edit"></li></a>

                                                                        <a title="Block" href="dealer_edit.php?iid=<?php echo $data['dealer_code']; ?>" onclick="return confirm('Are you sure you want to block this dealer?')" class="btn btn-xs red btn-editable"> 
                                                                            <li class="glyphicon glyphicon-off"></li></a>
                                                                        <?php } ?>
                                                                    </td>    
                                                                    <td>
                                                                        <a href="<?php echo SITEURL ?>/shipping/orders_add?id_1=<?php echo $data['dealer_bl_code']; ?>" class="btn btn-xs yellow">Add <i class="fa fa-link"></i>
									</a>
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <?php
                                                                 $i++;
                                                                 }
                                                                ?>
                                                        </tbody> 
                                                    </table>
                                                </div>
                                                
                                        
                            </div>

                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>

                    </div>
                    <!-- END PAGE CONTENT -->
                </div>
            </div>
            <!-- END CONTENT -->

        </div>
        <!-- END CONTAINER -->

        <!-- BEGIN FOOTER -->
        <?php require("../../includes/views/footer_admin_1.php"); ?>
        <!-- END FOOTER -->

    </body>

    <!-- END BODY -->
</html>

<script>

    /* Delete  Entered Data display message ======-------------------->>>>>>*/
    $(document).ready(function () {
        $('#hide div').live('click', function () {
            $(this).parent().parent().remove();
        });
    });

    /* Delete upload display message ======-------------------->>>>>>*/
    $(document).ready(function () {
        $('span#delete ').live('click', function () {
            $(this).parent().parent().remove();
        });
    });
</script> 

<?php
//Clear all the Message Session Variables...
if (isset($_SESSION['returnmessage'])) {
    unset($_SESSION['returnmessage']);
}
?>