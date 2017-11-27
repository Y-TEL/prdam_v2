<?php
##############################################
## @DESCRIPTION : DEALER ISSUES
## @AUTHOR      : NIRUSHIKA
## @MODULE      : MARKETING
##############################################

session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer_issue.php';

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
$page->setHeader("Dealer_Issue_Page");
$page->setTag_line("Dealer_Issue");
$page->setMenu_active("Dealer_Issue_view");
$page->setMenu_group("Marketing_Department");
########### END NAVIGATION SETUP #############

date_default_timezone_set('America/New_York');
@$today = date('Y-m-d');

$issue = new DealerIssue();

$pending_list  = $issue->viewPendingDealerList();
$resolved_list = $issue->viewResolvedDealerList();
$closed_list   = $issue->viewClosedDealerList();

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

<head>

<!-- class head -->
<?php require("../../includes/views/head_1.php") ?>
<!-- class head -->

<style>
    .fixed-width{width:90px;text-align: center}
</style>

<script src="//code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>/assets/global/scripts/js_validation/jquery-ui.min.js"></script>

<script>
    $(document).ready(function () {
        $('table.display').DataTable();
    });
</script>  

<script type="text/javascript">
    
function myFunctionPending() {
window.location.href = 'dealer_issue_exp_excel_pending.php';
}
function myFunctionResolved() {
window.location.href = 'dealer_issue_exp_excel_resolved.php';
}
function myFunctionClosed() {
window.location.href = 'dealer_issue_exp_excel_closed.php';
}

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
                                        <i class="fa fa-user"></i>View Dealer Issues
                                    </div>
                                    <div class="tools">
                                        <a href="dealer_issue_add" class="btn-default" style="text-decoration:none; height: 30px;" >
                                            <li class="glyphicon glyphicon-plus"></li> Add New</a>
                                    </div>
                                </div>				
                                <div class="portlet-body">
                                    <div class="tabbable-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab" aria-expanded="true">
                                                    Pending </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_1_2" data-toggle="tab" aria-expanded="false">
                                                    Resolved </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_1_3" data-toggle="tab" aria-expanded="false">
                                                    Closed </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!-- ############ DEALER TABLE VIEW ############ -->
                                            <div class="tab-pane fade active in" id="tab_1_1">
                                                <p>
                                                <div class="portlet-body">
                                                    <table class="table display table-striped table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    NO
                                                                </th>
                                                                <th>
                                                                    Date 
                                                                </th>
                                                                <th>
                                                                    Dealer Code    
                                                                </th>
                                                                <th>
                                                                    Issue Category  
                                                                </th>
                                                                <th>
                                                                    Note Taken By  
                                                                </th>
                                                                <th class="fixed-width">Option
                                                                </th>
                                                                
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            
                                                            $i = 1;
                                                            foreach ($pending_list as $data) {
                                                                ?>   
                                                                <tr <?php if((round(abs(strtotime(date('d-m-Y')) - strtotime($data['issue_date']))/86400))>30){ ?>class="danger" <?php }else if((round(abs(strtotime(date('d-m-Y')) - strtotime($data['issue_date']))/86400))>14){ ?>class="warning" <?php }else{} ?>>
                                                                    <td>
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['issue_date']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['issue_dealer_code']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['issue_category']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['user_calling_name']; ?>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <a title="View" href="dealer_issue_details.php?id=<?php echo $data['issue_id']; ?>&id_1=resolved"  class="btn btn-xs default btn-editable">
                                                                        <li class="glyphicon glyphicon-eye-open"></li></a>
                                                                            
                                                                        <?php if(($_SESSION['user_id']=="47")||($_SESSION['user_id']=="49")){ ?>
                                                                        <a title="Delete" href="dealer_issue_delete.php?iid=<?php echo $data['issue_id']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-xs red btn-editable"> 
                                                                        <li class="glyphicon glyphicon-remove"></li></a>
                                                                        <?php } ?>
                                                                    </td>    
                                                                </tr>
                                                                <?php
                                                                 $i++;
                                                                 }
                                                                ?>
                                                        </tbody> 
                                                    </table><button id="btnExport" onClick="myFunctionPending()" >Export to excel</button>
                                                </div>
                                                </p>
                                            </div>
                                            <!-- ############ END ############ -->
                                            <div class="tab-pane fade" id="tab_1_2">

                                                <div class="portlet-body">
                                                    <table class="table display table-striped table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    NO
                                                                </th>
                                                                <th>
                                                                    Date 
                                                                </th>
                                                                <th>
                                                                    Dealer Code    
                                                                </th>
                                                                <th>
                                                                    Issue Category  
                                                                </th>
                                                                <th>
                                                                    Note Taken By  
                                                                </th>
                                                                <th>
                                                                    Resolved By  
                                                                </th>
                                                                <th class="fixed-width">Option
                                                                </th>
                                                                
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($resolved_list as $data) {
                                                                ?>   
                                                            <tr>
                                                                    <td>
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['issue_date']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['issue_dealer_code']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['issue_category']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['user_calling_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['resolved_note_entered']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <a title="View" href="dealer_issue_details.php?id=<?php echo $data['issue_id']; ?>&id_1=closed"  class="btn btn-xs default btn-editable">
                                                                        <li class="glyphicon glyphicon-eye-open"></li></a>
                                                                            
                                                                        <?php if(($_SESSION['user_id']=="47")||($_SESSION['user_id']=="49")){ ?>
                                                                        <a title="Delete" href="dealer_issue_delete.php?iid=<?php echo $data['issue_id']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-xs red btn-editable"> 
                                                                        <li class="glyphicon glyphicon-remove"></li></a>
                                                                        <?php } ?>
                                                                    </td>    
                                                                </tr>
                                                                <?php
                                                                 $i++;
                                                                 }
                                                                ?>
                                                        </tbody>
                                                    </table><button id="btnExport" onClick="myFunctionResolved()" >Export to excel</button> 
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab_1_3">
                                                <div class="portlet-body">
                                                    <table class="table display table-striped table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    NO
                                                                </th>
                                                                <th>
                                                                    Date 
                                                                </th>
                                                                <th>
                                                                    Dealer Code    
                                                                </th>
                                                                <th>
                                                                    Issue Category  
                                                                </th>
                                                                <th>
                                                                    Note Taken By  
                                                                </th>
                                                                <th>
                                                                    Resolved By  
                                                                </th>
                                                                <th>
                                                                    Closed By  
                                                                </th>
                                                                <th class="fixed-width">Option
                                                                </th>
                                                                
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($closed_list as $data) {
                                                                ?>   
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['issue_date']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['issue_dealer_code']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['issue_category']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['user_calling_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['resolved_note_entered']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['closed_note_entered']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <a title="View" href="dealer_issue_details.php?id=<?php echo $data['issue_id']; ?>"  class="btn btn-xs default btn-editable">
                                                                        <li class="glyphicon glyphicon-eye-open"></li></a>
                                                                            
                                                                        <?php //if(($_SESSION['user_id']=="47")||($_SESSION['user_id']=="49")){ 
                                                                        if (isset($_SESSION['user_permissions']['Dealer_issue_delete']) && ($_SESSION['user_permissions']['Dealer_issue_delete'] == '1')){ ?>
                                                                        <a title="Delete" href="dealer_issue_delete.php?iid=<?php echo $data['issue_id']; ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-xs red btn-editable"> 
                                                                        <li class="glyphicon glyphicon-remove"></li></a>
                                                                        <?php } ?>
                                                                    </td>    
                                                                </tr>
                                                                <?php
                                                                 $i++;
                                                                 }
                                                                ?>
                                                        </tbody> 
                                                    </table><button id="btnExport" onClick="myFunctionClosed()" >Export to excel</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix margin-bottom-20">
                                        </div>
                                    </div>
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