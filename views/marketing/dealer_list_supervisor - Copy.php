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

$dealer = new Dealer();
$user_id = $_SESSION['user_id'];    
$dealer_list = $dealer->viewSupervisorDealerList($user_id);
$distributor_list = $dealer->viewSupervisorDistrubutorList($user_id);
$mom_pop_list = $dealer->viewSupervisorMomPopList($user_id);   


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
                                                    Dealer </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_1_2" data-toggle="tab" aria-expanded="false">
                                                    Distributor </a>
                                            </li>
                                            <li class="">
                                                <a href="#tab_1_3" data-toggle="tab" aria-expanded="false">
                                                    Mom & Pop </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!-- ############ DEALER TABLE VIEW ############ -->
                                            <div class="tab-pane fade active in" id="tab_1_1">
                                                <p>
                                                <div class="portlet-body">
                                                    <table class="table display table-striped table-hover table-bordered">
                                                        <thead>
                                                            <tr class="warning">
                                                                <th>
                                                                    NO
                                                                </th>
                                                                <th>
                                                                    Dealer Code 
                                                                </th>
                                                                <th>
                                                                    Store Name   
                                                                </th>
                                                                <th>
                                                                    Email  
                                                                </th>
                                                                <th>
                                                                    First Name  
                                                                </th>
                                                                <th>
                                                                    ME 
                                                                </th>
                                                                <th>
                                                                    Status   
                                                                </th>
                                                                <th>Option
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($dealer_list as $data) {
                                                                ?>   
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_code']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_store_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_email']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_fname']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['user_calling_name']; ?>
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
                                                                    </td>    
                                                                   
                                                                </tr>
                                                                <?php
                                                                 $i++;
                                                                 }
                                                                ?>
                                                        </tbody> 
                                                    </table>
                                                </div>
                                                </p>
                                            </div>
                                            <!-- ############ END ############ -->
                                            <div class="tab-pane fade" id="tab_1_2">

                                                <div class="portlet-body">
                                                    <table class="table display table-striped table-hover table-bordered" id="sample_editable_2">
                                                        <thead>
                                                            <tr class="warning">
                                                                <th>
                                                                    NO
                                                                </th>
                                                                <th>
                                                                    Dealer Code 
                                                                </th>
                                                                <th>
                                                                    Store Name   
                                                                </th>
                                                                <th>
                                                                    Email  
                                                                </th>
                                                                <th>
                                                                    First Name  
                                                                </th>
                                                                <th>
                                                                    ME   
                                                                </th>
                                                                <th>
                                                                    Status   
                                                                </th>
                                                                <th>
                                                                    Option
                                                                </th>
                                                                
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($distributor_list as $data) {
                                                                ?>   
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_code']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_store_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_email']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_fname']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['user_calling_name']; ?>
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
                                            <div class="tab-pane fade" id="tab_1_3">
                                                <div class="portlet-body">
                                                    <table class="table display table-striped table-hover table-bordered" id="sample_editable_2">
                                                        <thead>
                                                            <tr class="warning">
                                                                <th>
                                                                    NO
                                                                </th>
                                                                <th>
                                                                    Dealer Code 
                                                                </th>
                                                                <th>
                                                                    Store Name   
                                                                </th>
                                                                <th>
                                                                    Email  
                                                                </th>
                                                                <th>
                                                                    First Name  
                                                                </th>
                                                                <th>
                                                                    ME   
                                                                </th>
                                                                <th>
                                                                    Status   
                                                                </th>
                                                                <th>
                                                                    Option
                                                                </th>
                                                                
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($mom_pop_list as $data) {
                                                                ?>   
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $i; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_code']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_store_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_email']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['dealer_fname']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $data['user_calling_name']; ?>
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