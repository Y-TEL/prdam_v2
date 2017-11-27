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
$page->setHeader("dealer_supervisor_Page");
$page->setTag_line("dealer_supervisor_list");
$page->setMenu_active("dealer_supervisor_view");
$page->setMenu_group("Dealers_page");
########### END NAVIGATION SETUP #############

date_default_timezone_set('America/New_York');
@$today = date('Y-m-d');

$dealer = new Dealer();
$user_id = $_SESSION['user_id'];  
$market  = $_SESSION['user_market']; 
$dealer_list = $dealer->viewSupervisorDealerList($user_id);

$dealer_list_no_ME = $dealer->viewSupervisorDealerListWithoutME($market);
$resultDealers = count($dealer_list_no_ME);

//$distributor_list = $dealer->viewSupervisorDistrubutorList($user_id);
//$mom_pop_list = $dealer->viewSupervisorMomPopList($user_id);   

$drop_downs = new DropDownlist();
$drop_down_team_members = $drop_downs->getMyTeamMembers($user_id);
$resultME = count($drop_down_team_members);


if (isset($_POST['edit'])) {

    $dealer_new_ME = $_POST['new_no_dealer_ME'];
    $dealer_count   = $_POST['dealer_count'];    
    //$msg = $dealer->updateDealerNoME($new_no_dealer_ME,$market,$dealer_count);
    
    $b = 1;
    foreach ($dealer_list_no_ME as $data) {
    $dealer_code   = $_POST['dealer_code_'.$b];
    
    if($dealer_count>=$b){
    $msg_2 = $dealer->updateDealerME($dealer_new_ME,$dealer_code);
    }
    $b++;
    }
     
    if ($msg_2=1) { 
        header('Location: dealer_list_supervisor?id='.$msg_2);
    } 
}

if (isset($_POST['add'])) {

    $a = 1;
    foreach ($dealer_list as $data_1) {
    $dealer_new_ME = $_POST['new_dealer_ME'];
    $dealer_code   = $_POST['dealer_code_'.$a];
    if(isset($_POST['checkbox_'.$a])){ $checkbox = $_POST['checkbox_'.$a]; }else{ $checkbox = "";}
    
    if(($checkbox==1)&($dealer_new_ME!='')){
    $msg_1 = $dealer->updateDealerME($dealer_new_ME,$dealer_code);
    }
    $a++;
    }
     
    if ($msg_1=1) { 
        header('Location: dealer_list_supervisor?id='.$msg_1);
    } 
}

if (isset($_POST['update'])) {

    $c = 1;
    foreach ($dealer_list as $data_2) {
    if(isset($_POST['dealer_new_ME_'.$c])){ $dealer_new_ME = $_POST['dealer_new_ME_'.$c]; }else{ $dealer_new_ME = "";}
    $dealer_code   = $_POST['dealer_code_'.$c];
    if($dealer_new_ME!=''){
    $msg = $dealer->updateDealerME($dealer_new_ME,$dealer_code);
    }
    $c++;
    }
     
    if ($msg=1) { 
        header('Location: dealer_list_supervisor?id='.$msg);
    } 
}

if (isset($_GET['id'])) {
    // : RETURN MESSAGE.
        $returnmessage = array();
        array_push($returnmessage, array("type" => "information"));  //succes | warning | error | information
        array_push($returnmessage, array("message" => UPDATE));
        $_SESSION['returnmessage'] = $returnmessage;
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

    <script>
        $(document).ready(function () {
            $('table.display').DataTable();
        });
    </script>
    
    <script>
	$(document).ready(function(){ 
        
	$("#commentForm_1").validate({ //common validation start
            rules:  {
                        new_dealer_ME        : "required",
                        
                    },

           messages: {
                        new_dealer_ME        : "Select ME",
                        
                      }
        }); ///common validation end

        $value = <?php echo $resultDealers; ?>;
        $("#commentForm").validate({ //common validation start
            rules:  {
                        new_no_dealer_ME        : "required",
                        dealer_count            :  {  
                                                    required: true,
                                                    number: false,
                                                    maxlength:$value
                                                   },
                    },

           messages: {
                        new_no_dealer_ME        : "Select ME",
                        dealer_count            : {
                                                    required:"Enter Dealer Count",
                                                    number:"Enter number.",
                                                    //maxlength: $.validator.format("Please enter characters."),
                                                    }, 
                      }
        }); ///common validation end
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
                                        <i class="fa fa-user"></i>My Team Dealers
                                    </div>
                                    <div class="tools">
                                       
                                    </div>
                                </div>				
                                <div class="portlet-body">
                                    <div class="tabbable-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab" aria-expanded="true">
                                                   No Assigned ME </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_1_2" data-toggle="tab" aria-expanded="false">
                                                    Customize By ME </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_1_3" data-toggle="tab" aria-expanded="false">
                                                    Customize By Dealer </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!-- ############ DEALER TABLE VIEW ############ -->
                                            <div class="tab-pane fade active in" id="tab_1_1">
                                                <p>
                                                <div class="portlet-body">
                                                    <form id="commentForm" class="form-horizontal form-bordered" name ="update_ME" action="" method="post" enctype="multipart/form-data"> 
                                                     
                                                    <div class="row">
                                                            <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">Total dealer count : </label>
                                                                        <div class="col-md-6">
                                                                            <input type="text" name="total_dealer_count" id="total_dealer_count" class="form-control" value="<?php echo $resultDealers;?>" readonly="" />
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <!--/span-->
                                                            <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-4">My team ME count : </label>
                                                                        <div class="col-md-6">
                                                                            <input type="text" name="toatal_ME_count" id="toatal_ME_count" class="form-control" value="<?php echo $resultME;?>" readonly=""/>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <!--/span-->
                                                    </div>
                                                    <!--/row-->
                                                    <div class="row">
                                                            <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3">ME Name : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                        <div class="col-md-6">
                                                                                <select name="new_no_dealer_ME" id="new_no_dealer_ME" class="form-control">
                                                                                    <option value="" selected="true" disabled="true">Select</option>
                                                                                    <?php  foreach ($drop_down_team_members as $value) {?>
                                                                                    <option value="<?php echo $value['emp_id'];?>"><?php echo $value['user_calling_name'];?></option>
                                                                                    <?php }?>
                                                                                </select>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <!--/span-->
                                                            <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-4">Assigned dealer count : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                        <div class="col-md-6">
                                                                            <input type="number" name="dealer_count" id="dealer_count" class="form-control" value="" max="<?php echo $resultDealers;?>"/>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                            <!--/span-->
                                                    </div>
                                                    <!--/row-->
                                                    
                                                    <button type="submit" name="edit" class="btn btn-circle grey-cascade">Assign New ME</button>
                                                    
                                                   
                                                    <table class="table table-striped table-hover table-bordered" style=" margin-top:10px;">
							<thead>
							<tr>
								<th>
                                                                    No
								</th>
								<th>
                                                                    Dealer Code 
                                                                </th>
                                                                <th>
                                                                    Dealer Type 
                                                                </th>
                                                                <th>
                                                                    Store Name   
                                                                </th>
                                                                <th>
                                                                    Current ME   
                                                                </th>
							</tr>
							</thead>
							<tbody>
                                                        <?php
                                                        $b = 1;
                                                        foreach ($dealer_list_no_ME as $data) {
                                                        ?>
							<tr>
								<td>
                                                                    <?php echo $b; ?>
								</td>
								<td>
                                                                    <?php echo $data['dealer_code']; ?>
                                                                    <input type="hidden" name="dealer_code_<?php echo $b; ?>" id="dealer_code_<?php echo $b; ?>" class="form-control" value="<?php echo $data['dealer_code']; ?>">
                                                                </td>
                                                                <td>
                                                                    <?php echo $data['cus_type_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $data['dealer_store_name']; ?>
                                                                </td>

                                                                <td>
                                                                    <?php echo $data['user_calling_name']; ?>
                                                                </td>
							</tr>
                                                        <?php
                                                        $b++;
                                                        }
                                                        ?>
							</tbody>
							</table>
                                                        </form>                                                 
                                                    
                                                </div>
                                                </p>
                                            </div>
                                            <!-- ############ END ############ -->
                                            <div class="tab-pane fade" id="tab_1_2">           

                                                <div class="portlet-body">
                                                    <form id="commentForm_1" class="form-horizontal form-bordered" name ="update_by_me" action="" method="post" enctype="multipart/form-data"> 
                                                    <table class="table table-striped table-hover table-bordered">
                                                        <thead>
                                                            <tr class="warning">
                                                                <th>
                                                                    
                                                                </th>
                                                                <th>
                                                                    Dealer Code 
                                                                </th>
                                                                <th>
                                                                    Dealer Type 
                                                                </th>
                                                                <th>
                                                                    Store Name   
                                                                </th>
                                                                <th>
                                                                    Current ME   
                                                                </th>
                                                                
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $a = 1;
                                                            foreach ($dealer_list as $data_1) {
                                                            ?>   
                                                                <tr>
                                                                    <td>
                                                                        <div class="md-checkbox-inline">
                                                                            <div class="md-checkbox">
                                                                                <input type="checkbox" id="checkbox_<?php echo $a; ?>" name="checkbox_<?php echo $a; ?>" value="1" class="md-check">
                                                                                    <label for="checkbox_<?php echo $a; ?>">
                                                                                    <span></span>
                                                                                    <span class="check"></span>
                                                                                    <span class="box"></span>
                                                                                    </label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data_1['dealer_code']; ?>
                                                                        <input type="hidden" name="dealer_code_<?php echo $a; ?>" id="dealer_code_<?php echo $a; ?>" class="form-control" value="<?php echo $data_1['dealer_code']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data_1['cus_type_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data_1['dealer_store_name']; ?>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <?php echo $data_1['user_calling_name']; ?>
                                                                    </td>
                                                                    
                                                                </tr>
                                                            <?php
                                                            $a++;
                                                            }
                                                            ?>
                                                        </tbody> 
                                                    </table>
                                                    
                                                    <div class="row">   
                                                            <div class="col-md-12">
                                                                    <div class="form-group">
                                                                            <label class="control-label col-md-1">New ME </label>
                                                                            <div class="col-md-3">
                                                                                <select name="new_dealer_ME" id="new_dealer_ME" class="form-control">
                                                                                    <option value="" selected="true" disabled="true">Select</option>
                                                                                    <?php  foreach ($drop_down_team_members as $value) {?>
                                                                                    <option value="<?php echo $value['emp_id'];?>"><?php echo $value['user_calling_name'];?></option>
                                                                                    <?php }?>
                                                                                </select>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>  
                                                    
                                                    <button type="submit" name="add" class="btn green">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                            
                                            <div class="tab-pane fade" id="tab_1_3">
                                                <div class="portlet-body">
                                                    <form id="commentForm_2" class="form-horizontal form-bordered" name ="update_by_dealer" action="" method="post" enctype="multipart/form-data"> 
                                                    <table class="table table-striped table-hover table-bordered">
                                                        <thead>
                                                            <tr class="warning">
                                                                <th>
                                                                    NO
                                                                </th>
                                                                <th>
                                                                    Dealer Code 
                                                                </th>
                                                                <th>
                                                                    Dealer Type 
                                                                </th>
                                                                <th>
                                                                    Store Name   
                                                                </th>
                                                                <th>
                                                                    Current ME   
                                                                </th>
                                                                <th>
                                                                    New ME 
                                                                </th>
                                                                <th>
                                                                    Option
                                                                </th>
                                                                
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $c = 1;
                                                            foreach ($dealer_list as $data_2) {
                                                            ?>   
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $c; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data_2['dealer_code']; ?>
                                                                        <input type="hidden" name="dealer_code_<?php echo $c; ?>" id="dealer_code_<?php echo $c; ?>" class="form-control" value="<?php echo $data_2['dealer_code']; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data_2['cus_type_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data_2['dealer_store_name']; ?>
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <?php echo $data_2['user_calling_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                         <select name="dealer_new_ME_<?php echo $c; ?>" id="dealer_new_ME_<?php echo $c; ?>" class="form-control">
                                                                            <option value="" selected="true" disabled="true">Select</option>
                                                                            <?php  foreach ($drop_down_team_members as $value) {?>
                                                                            <option value="<?php echo $value['emp_id'];?>"><?php echo $value['user_calling_name'];?></option>
                                                                            <?php }?>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <button type="submit" name="update" class="btn green">Submit</button>
                                                                     </td>
                                                                     
                                                                </tr>
                                                            <?php
                                                            $c++;
                                                            }
                                                            ?>
                                                        </tbody> 
                                                    </table>
                                                    </form><!-- END FORM-->
                                                    
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
<?php require("../../includes/views/footer_admin.php"); ?>
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