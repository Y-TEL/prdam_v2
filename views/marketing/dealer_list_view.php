<?php
##############################################
## @DESCRIPTION : DEALER LIST 
## @AUTHOR      : JALIYA LAMAHEWA
## @MODULE      : MARKETING
##############################################
session_start();
require_once '../../includes/views/define_include.php';
require '../../classes/marketing/dealer.php';

/*if(!in_array($user_ip,$allowed_ips)){
  header("Location: ../HR/leave_apply");
}*/
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

$drop_downs = new DropDownlist();
$drop_down_customer_type     = $drop_downs->getAllCustomerTypes();
$drop_down_area_manager      = $drop_downs->getAllAreaManagers();
$drop_down_regional_manager  = $drop_downs->getAllRegionalManager();
$drop_down_market            = $drop_downs->getAllMarket();
$drop_down_states            = $drop_downs->getAllUSAStates();
$drop_down_sales_rep         = $drop_downs->getAllSalesRep();
$drop_down_usa_rep           = $drop_downs->getAllUSARep();
$drop_down_us_mar_user       = $drop_downs->getAllMarketingUser();


$dealer = new Dealer();

/*if(isset($_SESSION['user_permissions']['Dealer_view_all']) && ($_SESSION['user_permissions']['Dealer_view_all'] == '1')){
    $dealer_list = $dealer->viewDealerList();
//$distributor_list = $dealer->viewDistrubutorList();
//$mom_pop_list = $dealer->viewMomPopList();
} else {
    $user_id = $_SESSION['user_id'];    
    $dealer_list = $dealer->viewMyDealerList($user_id);
//$distributor_list = $dealer->viewMyDistrubutorList($user_id);
//$mom_pop_list = $dealer->viewMyMomPopList($user_id);   
}*/

    $records_per_page = 100;
    $starting_position = 0;
    if(isset($_REQUEST["page_no"]) && !isset($_POST['search']))
    {
      $starting_position=(($_REQUEST["page_no"]-1)*$records_per_page);
    }

    if(!isset($_REQUEST["page_no"]))
    {
      $_REQUEST["page_no"]=1;
    }

    if(isset($_REQUEST['search'])){
      
$dealer_list = $dealer->searchDealer($_REQUEST['search'],$_REQUEST['dealer_type'],$_REQUEST['dealer_mark_exe'],$_REQUEST['dealer_reg_manager'],$_REQUEST['dealer_market'],$_REQUEST['user_status'],$_REQUEST['paperwork'],$records_per_page,$starting_position);
      $total_records = $dealer->totalSearchDealers($_REQUEST['search'],$_REQUEST['dealer_type'],$_REQUEST['dealer_mark_exe'],$_REQUEST['dealer_reg_manager'],$_REQUEST['dealer_market'],$_REQUEST['user_status'],$_REQUEST['paperwork']);   

      //$total_records = $total_records[0];
     //print_r($total_records);
     //exit;
      //$total_records = count($total_records);
    }else{
      $dealer_list = $dealer->viewDealerList($records_per_page,$starting_position);
      $total_records = $dealer->totalDealers();   
      $total_records = $total_records[0];
      //$total_records = count($total_records);
    }

   if(isset($_GET['id'])) {
    $add = $_GET['id'];
    if($add == 1) {
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

    if(isset($_GET['iid'])) {
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

    if(isset($_GET['iiid'])) {
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

    /// SHORTEN STRING
    function shorten_string($string, $amount)
    {
       if(strlen($string) > $amount)
       {
         $string = trim(substr($string, 0, $amount))."..";
       }
       return $string;
    }
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <script type="text/javascript">
    function myFunction() {
      window.location.href = 'dealer_list_exp_excel.php';
    }
  </script>
   <!-- BEGIN PAGE LEVEL STYLES -->
        <link rel="stylesheet" type="text/css" href="<?php echo SITEURL ?>/assets/global/plugins/select2/select2.css"/>
        <!-- BEGIN THEME STYLES -->
  <head>
    <!-- class head -->
    <?php require("../../includes/views/head_1.php") ?>
    <!-- class head -->
    <style>
      .fixed-width{
        width:90px;text-align: center;
      }

      #loading {
        background:url(loading1.gif) no-repeat center center;
        height: 100px;
        width: 100px;
        position: fixed;
        padding-top: 50%;
        left: 55%;
        top: 20%;
        margin: -25px 0 0 -25px;
        z-index: 1000;
      }

      .table{
        opacity: 0.2;
      }

      .red{
        background-color: #ffeaea !important;
      }

      .tooltip.top .tooltip-inner {
        background-color:#FFFFE1;
        border: 1px solid #525246;
        color: black;
      }
      .tooltip.top .tooltip-arrow {
        border-top-color:#FFFFE1;
      }

      .table-responsive {
         overflow: visible;
      }

      .pager1{
        margin-top: -10px !important;
      }
    </style>
       

    <script src="//code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script>
      $(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
      });
    </script>
    <script>
      $(window).load(function() {
        // Animate loader off screen      
        $("#loading").fadeOut("slow");
        $(".table").animate({
          'opacity': 1
        });
      });
      
      $(document).ready(function () {  
       
        /* $('table.display').DataTable({
          "ordering": false,
          'iDisplayLength': 100
        }); */

        $('body').on('click', '.dealer-active', function(e) { 
          e.preventDefault(); 
          
          var dealer_code = $(this).attr('href');

          bootbox.confirm({
            message: "<h4>Confirm to Activate or Deactivate dealer</h4>",
            closeButton: false,
            buttons: {
              confirm: {
                label: 'Activate',
                className: 'btn-primary'
              },
              cancel: {
                label: 'Deactivate',
                className: 'btn-danger'
              }
            },
            callback: function(result) {
              if(result){                         
                var status = 1; 
                var button = "<a href="+dealer_code+" class='btn btn-xs btn-primary dealer-active'>Active</a>";
              }else{
                var status = 2;
                var button = "<a href="+dealer_code+" class='btn btn-xs btn-danger dealer-active'>Inactive</a>";
              }
              
              $.ajax({
                url: 'ajax_activate_dealer.php',
                type: 'POST',
                data: {status:status,code:dealer_code},
              })
              .success(function(data) {
                //var button = "<a class='btn btn-xs btn-danger dealer-active'>Deactive</a>";
                if(status==1){
                   $("a[href='"+dealer_code+"']").parent().parent().removeClass('red');
                   $("a[href='"+dealer_code+"']").parent().removeClass('red');
                }else{
                   $("a[href='"+dealer_code+"']").parent().parent().addClass('red');
                   $("a[href='"+dealer_code+"']").parent().addClass('red');
                }

                $("a[href='"+dealer_code+"']").parent().html(button);

                // alert(data);
                // var cache = $('.trainingModal[href='+delete_id+']').closest('li');
                // cache.animate({backgroundColor: 
                // "#ffebe6"},500).fadeOut(300, function(){ 
                // cache.remove(); 
                //  });

                        })                       
                    }
               });

               //  var status = $(this).text();
               //  $("#activeChangeModal .modal-body").html();
               //  $('#activeChangeModal').modal('show');
               //      var destination = $("#destination").val();
               //      $.ajax
               //      ({ 
               //        url: "/travel-details",
               //        cache: false,
               //        type: 'post',
               //        headers: {
               //          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               //      },
               //      data : {start:start,destination:destination},
               //      success: function(data)
               //      {  
               //         $("#travelDetailModal .modal-body").html(data);
               //         $("#travelDetailModal .modal-body").append('hi');
               //         $('#travelDetailModal').modal('show');
               //     }
               //  });
             });  
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
            <div class="portlet light">            
              <div class="portlet-title">
               <div class="caption uppercase font-blue-madison bold">
                <i class="icon-users font-blue-madison bold"></i> Dealer List
              </div>
              <div class="actions">
               <?php if(isset($_SESSION['user_permissions']['dealer_add']) && ($_SESSION['user_permissions']['dealer_add'] == '1')){ ?>
               <a class="btn blue btn-sm active" href="dealer_detail_add">New Dealer</a>
               <?php } ?>
             </div>
           </div>				

           <div class="portlet-body">
             <div id="loading"></div>
    <!--      <div class="table-toolbar">
     <div class="row">
    
      <div class="col-md-6">
       <div class="btn-group pull-left">
                        <button class="btn dropdown-toggle" onClick="myFunction()" data-toggle="dropdown">Export to Excel 
         </button>
       </div>
     </div>
                </div>
              </div> -->
  <?php
  /*echo "<div class='pull-right'><ul class='pager'>";
            $total_no_of_pages=ceil($total_records/$records_per_page);
            //echo $total_no_of_pages;
            $current_page=1;
      //$self = $_SERVER['PHP_SELF'];
      $self = "dealer_list_view.php";
            if(isset($_GET["page_no"]))
            {
               $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
               $previous =$current_page-1;
               echo "<li><a href='".$self."?page_no=1'>First</a>&nbsp;&nbsp;</li>";
               echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a>&nbsp;&nbsp;</li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                    echo "<li class='active'><a href='".$self."?page_no=".$i."' style='color:#666;text-decoration:none;background-color:#eee'>".$i."</a>&nbsp;&nbsp;</li>";
                }
                else if($i>4 && $i<$total_no_of_pages-2)
                {
                 

                }else{
                   echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a>&nbsp;&nbsp;</li>";
                }
            }
   if($current_page!=$total_no_of_pages)
   {
        $next=$current_page+1;
        echo "<li><a href='".$self."?page_no=".$next."'>Next</a>&nbsp;&nbsp;</li>";
        echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a>&nbsp;&nbsp;</li>";
   }
  echo"</ul></div>";
  echo "<div class='clear'></div>"; */
  //echo $_REQUEST['search'];
   $url = "search=".@$_REQUEST['search']."&dealer_type=".@$_REQUEST['dealer_type']."&dealer_mark_exe=".@$_REQUEST['dealer_mark_exe']."&dealer_reg_manager=".@$_REQUEST['dealer_reg_manager']."&dealer_market=".@$_REQUEST['dealer_market']."&user_status=".@$_REQUEST['user_status']."&paperwork=".@$_REQUEST['paperwork'];
  ?>
<form action="" method="post">
<div class="row">  
<div class="col-md-12 col-lg-12 col-sm-2">  
    <div class="col-md-3">
     <h4 class="help-block"> Dealer Type : </h4>
     <select name="dealer_type" class="form-control search" id="dealer-type">
      <option value="" selected="true">--- Any ---</option>
        <?php
        foreach ($drop_down_customer_type as $values) {
          if ($values['cus_type_id'] != 3) {
             if($values['cus_type_id']==@$_REQUEST['dealer_type']){
                $selected = 'selected';
              }else{
                $selected = '';
              }
        ?>
        <option value="<?php echo $values['cus_type_id']; ?>" <?php echo $selected; ?>><?php echo $values['cus_type_name']; ?></option>
        <?php
         }
        }
        ?>
      </select>
    </div>
                                
    <div class="col-md-3">
        <h4 class="help-block"> Marketing Executive : </h4>
        <select name="dealer_mark_exe" id="dealer_mark_exe" class="form-control select2me">
            <option value="0" selected="true">--- Any ---</option>
            <?php foreach ($drop_down_us_mar_user as $value) { 
                if($value['user_id']==@$_REQUEST['dealer_mark_exe']){
                  $selected = 'selected';
                }else{
                  $selected = '';
                }
            ?>
            <option value="<?php echo $value['user_id']; ?>" <?php echo $selected; ?>><?php echo $value['user_calling_name']; ?></option><?php } ?>
        </select> 
    </div>

    <div class="col-md-3">
      <h4 class="help-block"> Regional Manager : </h4>
      <select name="dealer_reg_manager" id="dealer_reg_manager" class="form-control select2me">
          <option value="0" selected="true">--- Any ---</option>
          <?php foreach ($drop_down_regional_manager as $value) {
              if($value['user_id']==@$_REQUEST['dealer_reg_manager']){
                $selected = 'selected';
              }else{
                $selected = '';
              }
           ?>
          <option value="<?php echo $value['user_id']; ?>" <?php echo $selected; ?>><?php echo $value['user_calling_name']; ?></option><?php } ?>
      </select> 
    </div>

    <div class="col-md-3">
      <h4 class="help-block">Market : </h4>
        <select name="dealer_market" id="dealer_market" class="form-control select2me">
          <option value="0" selected="true">--- Any ---</option>
          <?php foreach ($drop_down_market as $value) {
              if($value['market_id']==@$_REQUEST['dealer_market']){
                $selected = 'selected';
              }else{
                $selected = '';
              }
           ?>
          <option value="<?php echo $value['market_id']; ?>" <?php echo $selected; ?>>
             <?php echo $value['market_name']; ?>
          </option>
          <?php } ?>
        </select>
    </div>
  </div>
</div>
<br>
   <div class="row">      
   <div class="col-md-12 col-lg-12 col-sm-2">                   
      <div class="col-md-3">
         <h4 class="help-block"> Status : </h4>
         <select name="user_status" class="form-control search" id="user-status">
          <option value="-1" selected="true">--- Any ---</option>
          <option value="1" 
            <?php echo isset($_REQUEST['user_status']) && $_REQUEST['user_status']==1 ? 'selected' : ''?> 
            >Active
          </option>
          <option value="0" 
            <?php echo isset($_REQUEST['user_status']) && $_REQUEST['user_status']==0 ? 'selected' : ''?>
            >Inactive
          </option>
          </select>
      </div>
                                                               
      <div class="col-md-3">
         <h4 class="help-block"> Paperwork : </h4>
         <select name="paperwork" class="form-control search" id="paperwork">
          <!-- <option value="-1" selected="true">--- Any ---</option> -->
          <option value="1" selected="true"
           <?php echo isset($_REQUEST['paperwork']) && $_REQUEST['paperwork']==1 ? 'selected' : ''?> >Approved</option>
          <!-- <option value="0"
          <?php echo isset($_REQUEST['paperwork']) && $_REQUEST['paperwork']==0 ? 'selected' : ''?>>Pending</option> -->
          </select>
      </div>
                                
      <div class="col-md-4">
          <h4 class="help-block"> Search : </h4>
          <input type="text" name="search" class="form-control" value="<?php echo isset($_REQUEST['search']) ? $_REQUEST['search']:''  ?>">
      </div>
                                
      <div class="col-md-2">
          <h4 class="help-block">.</h4>
          <button class="btn btn-block default" type="submit" name="search_btn">Search</button> 
      </div>
</div>
</div>
</form>
                 
                        

<!--       <div class='col-md-6 col-sm-12' style="margin-top: 10px">
    Showing <?php echo $starting_position+1; ?> to <?php echo $starting_position+100>$total_records?$total_records:$starting_position+100; ?> of <?php echo $total_records; ?> entries
</div>
<div class='form-horizontal form-inline pull-right'>
<form action="" method="post">
   <input type="text" name="search" class="form-control input-sm input-inline" value="<?php echo isset($_REQUEST['search']) ? $_REQUEST['search']:''  ?>">
   <button class="btn btn-sm default" type="submit" name="search_btn">Search</button> 
</form>
</div>   -->

      <br /><br />
          <table class="table display table-striped table-hover table-bordered">
            <thead>
              <tr>

                <th width="120">
                  Dealer Code 
                </th>
                <th width="90">
                  BL Code
                </th>
                <th width="130">
                  Dealer Type 
                </th>
                <th width="280">
                  Store Name   
                </th>
                <th>
                  ME
                </th>

                <th>
                  RM   
                </th>
                <th>
                  Market
                </th>
                <th>
                  Paperwork   
                </th>
                <th>
                  Status 
                </th>
                <th>Action
                </th>
               </tr>
               </thead>
                <tbody>
                                                              <?php
                                                              $i = 1;
                                                              foreach ($dealer_list as $data) {
                                                                $ME= $data['dealer_marketing_exe'];
                                                                $value = $dealer->selectDealerME($ME);
                                                                
                                                                $rep= $data['dealer_sales_rep_id'];
                                                                $values = $dealer->selectDealerRep($rep);
                                                                
                                                                $RM= $data['dealer_regional_manager'];
                                                                $valuess = $dealer->selectDealerRM($RM);
                                                                ?>   
                                                                <tr <?php echo $data['dealer_status']==1 ?'':' class="red"' ?>>

                                                                  <td>
                                                                    <?php echo $data['dealer_code']; ?>
                                                                  </td>
                                                                  <td>
                                                                    <?php echo $data['dealer_bl_code']; ?>
                                                                  </td>

                                                                  <td>
                                                                    <?php echo $data['cus_type_name']; ?>
                                                                  </td>
                                                                  <td width="280">
 <a data-toggle="tooltip" title="<?php echo strtoUpper($data['dealer_store_name']); ?>" href="../dealer_profile/index?id=<?php echo $data['dealer_code'] ?>&<?php echo $url ?>&page_no=<?php echo @$_REQUEST['page_no']; ?>"><?php echo strtoUpper(shorten_string($data['dealer_store_name'], 23)); ?></a>
                                                                  </td>
                                                                  <td>
                                                                    <?php echo ucwords(strtolower($value['user_calling_name'])); ?>
                                                                  </td>
                                                                  <td>
                                                                    <?php echo ucwords($valuess['user_calling_name']); ?>
                                                                  </td> 
                                                                  <td>
                                                                   <span data-toggle="tooltip" title="<?php echo strtoUpper($data['d_market']); ?>"><?php echo strtoUpper(shorten_string($data['d_market'],10)); ?></span>
                                                                 </td>
                                                                 <td>
                                                                  <span class="label label-success">Approved</span>
                                                            <!--            <?php if($data['dealer_active']== 1){ ?> 
                                                                       <span class="label label-success">Approved</span>
                                                                       <?php }else if($data['dealer_active']== 0){ ?> 
                                                                       <span class="label label-danger">Blocked</span>
                                                                       <?php }else if($data['dealer_active']== 2){ ?> 
                                                                       <span class="label label-info">Pending 
                                                                        <?php if(($_SESSION['user_id']=="47")||($_SESSION['user_id']=="49")||($_SESSION['user_name']=="paperwork@jayscomm.com")){ ?>    
                                                                        <a title="Verify" href="dealer_verify.php?id=<?php echo $data['dealer_id']; ?>" class="btn btn-xs yellow btn-editable"> 
                                                                            <li class="glyphicon glyphicon-check"></li></a>
                                                                            <?php } ?>
                                                                        </span>
                                                                        <?php } else { ?> 
                                                                        <?php }?> -->
                                                                      </td>
                                                                      <td class="active_status">
                                                                        <?php if($data['dealer_status']==1){ ?> 
                                                                        <a href="<?php echo $data['dealer_code']; ?>" class="btn btn-xs btn-primary dealer-active">Active</a>
                                                                        <?php } else { ?> 
                                                                        <a href="<?php echo $data['dealer_code']; ?>" class="btn btn-xs btn-danger dealer-active">Inactive</a>
                                                                        <?php } ?>  
                                                                      </td>

                                                                      <td width="80">
                                                                        <div class="btn-group">
                                                                          <a class="btn btn-xs btn-default dropdown-toggle exchange1" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
                                                                            <span class="hidden-480">
                                                                              Action </span>
                                                                              <i class="fa fa-angle-down"></i>
                                                                            </a>
                                                                            <ul class="dropdown-menu dropdown-menu-dark pull-right" role="menu">
                                                                              <li>
                                                                                <a href="../dealer_profile/index?id=<?php echo $data['dealer_code']; ?>&<?php echo $url ?>&page_no=<?php echo @$_REQUEST['page_no']; ?>">
                                                                                  <i class="icon-grid"></i>  Dealer Profile </a>
                                                                                </li>
                                                                                <li>

                                                                                 <a title="action" class="editJobModal" href="../dealer_profile/profile?id=<?php echo $data['dealer_code']; ?>&<?php echo $url ?>&page_no=<?php echo @$_REQUEST['page_no']; ?>" data-item-id="" data-toggle="modal"><i class="icon-user"></i> Dealer Details</a>  
                                                                               </li>

                                                                               <li>
                                                                                <a href="dealer_edit.php?id=<?php echo $data['dealer_code']; ?>&<?php echo $url ?>&page_no=<?php echo @$_REQUEST['page_no']; ?>">
                                                                                  <i class="icon-settings"></i>  Edit Details </a>
                                                                                </li>

                                                                         
                                                                                        </td> 

                                                                                      </tr>
                                                                                      <?php
                                                                                      $i++;
                                                                                    }
                                                                                    ?>
                                                                                  </tbody> 
                                                                                </table>
                                                                            <?php

  echo "<div class='pull-right pager1'><ul class='pager'>";
            $total_no_of_pages=ceil($total_records/$records_per_page);
            //echo $total_no_of_pages;
            $current_page=1;
      //$self = $_SERVER['PHP_SELF'];
      $self = "dealer_list_view.php";
    /*  $url = $_REQUEST['search'],$_REQUEST['dealer_type'],$_REQUEST['dealer_mark_exe'],$_REQUEST['dealer_reg_manager'],$_REQUEST['dealer_market'],$_REQUEST['user_status'],$_REQUEST['paperwork']*/


            if(isset($_GET["page_no"]))
            {
               $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
               $previous =$current_page-1;
               echo "<li><a href='".$self."?page_no=1&$url'>First</a>&nbsp;&nbsp;</li>";
               echo "<li><a href='".$self."?page_no=".$previous."&$url'>Previous</a>&nbsp;&nbsp;</li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                    echo "<li class='active'><a href='".$self."?page_no=".$i."&$url' style='color:#666;text-decoration:none;background-color:#eee'>".$i."</a>&nbsp;&nbsp;</li>";
                }
                else if($i>4 && $i<$total_no_of_pages-2)
                {
                 

                }else{
                   echo "<li><a href='".$self."?page_no=".$i."&$url'>".$i."</a>&nbsp;&nbsp;</li>";
                }
            }
   if($current_page!=$total_no_of_pages)
   {
        $next=$current_page+1;
        echo "<li><a href='".$self."?page_no=".$next."&$url'>Next</a>&nbsp;&nbsp;</li>";
        echo "<li><a href='".$self."?page_no=".$total_no_of_pages."&$url'>Last</a>&nbsp;&nbsp;</li>";
   }
  echo"</ul></div>";
  ?>
  <br>  <br>  <br>

                                                                              </div>


                                                                            </div>

                                                                            <!-- END EXAMPLE TABLE PORTLET-->
                                                                          </div>
 
                                                                        </div>
                                                                        <!-- END PAGE CONTENT -->
                                                                        <!-- load travel detail modal -->
                                                                        <div class="modal fade" id="activeChangeModal" role="dialog">
                                                                          <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                              <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                <h4 class="modal-title font-blue-madison bold">Travel Details</h4>
                                                                              </div>
                                                                              <div class="modal-body">
                                                                                <form action="#" class="form-horizontal noteform">
                                                                                  <div class="form-group">
                                                                                    <label class="control-label col-md-3">Note</label>
                                                                                    <!-- primary, info, success, warning, danger and default -->
                                                                                    
                                                                                    <input type="checkbox" name="my-checkbox" data-on-color="primary" data-on-text="Active" data-off-color="danger" data-off-text="Inactive" data-handle-width="100" >
                                                                                    
                                                                                  </div>
                                                                                  <input type="hidden" id="note-id" name="note-id" value="">
                                                                                </form>
                                                                              </div>
                                                                              <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                <button type="button" class="btn blue" id="submit-note">Save</button>
                                                                              </div>
                                                                            </div>
                                                                          </div>
                                                                        </div>
  <!-- end modal --
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
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js" type="text/javascript"></script>
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

                                        $("[name='my-checkbox']").bootstrapSwitch();  
                                      });
                                    </script> 


                                    <?php
//Clear all the Message Session Variables...
                                    if (isset($_SESSION['returnmessage'])) {
                                      unset($_SESSION['returnmessage']);
                                    }
                                    ?>