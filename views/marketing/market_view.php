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
$market_list = $markets->viewDealerMarketList();
$result = count($market_list);

if(isset($_GET['id'])){
$add = $_GET['id'];
 if ($add=1) {
	       // : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"success"));	//succes | warning | error | information
			array_push($returnmessage , array("message"=>SUCCESS));
			$_SESSION['returnmessage'] = $returnmessage; 
 }else {
			// : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"error"));		//succes | warning | error | information
			array_push($returnmessage , array("message"=>ERROR));
			$_SESSION['returnmessage'] = $returnmessage;
 }
}

if(isset($_GET['iid'])){
$update = $_GET['iid'];
 if ($update=1) {
	       // : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"information"));		//succes | warning | error | information
			array_push($returnmessage , array("message"=>UPDATE));
			$_SESSION['returnmessage'] = $returnmessage;
		  }
	   else
		  {
			// : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"stop"));		//succes | warning | error | information
			array_push($returnmessage , array("message"=>ERROR));
			$_SESSION['returnmessage'] = $returnmessage;
		  }
}

if(isset($_GET['iiid'])){
$delete = $_GET['iiid'];
 if ($delete=1) {
	       // : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"information"));		//succes | warning | error | information
			array_push($returnmessage , array("message"=>DELETE));
			$_SESSION['returnmessage'] = $returnmessage;
		  }
	   else
		  {
			// : RETURN MESSAGE.
			$returnmessage = array();
			array_push($returnmessage, array("type"=>"error"));		//succes | warning | error | information
			array_push($returnmessage , array("message"=>ERROR));
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

<script>
 /**   var UIConfirmations = function () {

     $i=1;
     while($i<=$result){
    var handleSample = function () {
       
        $('#bs_confirmation_demo_1').on('confirmed.bs.confirmation', function () {
            
		var market = document.getElementById('bs_confirmation_demo_1').value;
		
		$.ajax({ 
                    success: function(data) { 
                      window.location = '<?php echo SITEURL ?>/views/marketing/market_edit.php?iid='+market;
                    },
                });
            
        });

        $('#bs_confirmation_demo_1').on('canceled.bs.confirmation', function () {
            //alert('You canceled delete function');
        });   
    
    }
    }$i++;

    return {
        //main function to initiate the module
        init: function () {
           handleSample();
        }
    };

}(); **/
</script>
</head>


<!-- BEGIN HEADER -->
<div>
   <?php require("../../includes/views/header_admin.php");?>
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
			
                        <div id="hide"><?php include ("../../includes/views/messager.php"); //Display  Messages for Entered Data  ?></div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box yellow">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit"></i>View Markets
							</div>
							<div class="tools">
								<a href="market_add" class="btn default" style="text-decoration:none; height: 30px;" >Add New</a>
                                                        </div>
						</div>
						<div class="portlet-body">
                                                        <!--/row-->
							<table class="table table-striped table-hover table-bordered" id="sample_editable_1">
							<thead>
							<tr>
								<th>
									 NO
								</th>
                                                                <th>
									 Market Name 
								</th>
								<th>
									 Edit
								</th>
								<th>
									 Delete
								</th>
							</tr>
							</thead>
                                                        
							<tbody>
                                                         <?php $i=1;
								foreach ($market_list as $data) { ?>   
							<tr>
                                                                <td>
									<?php echo $i; ?>
								</td>
                                                                <td>
									<?php echo $data['market_name'];  ?>
								</td>
								<td>
									<a title="Edit" href="market_edit?id=<?php echo $data['market_id'] ;?>"  style="text-decoration:none;">
									<img src="<?php echo SITEURL ?>/assets/admin/pages/img/edit.png" width="20" height="20" /> </a>
								</td>
								<td>
									<a title="Delete"  href="market_edit?iid=<?php echo $data['market_id'] ;?>" onclick="return confirm('Are you sure you want to delete?')" style="text-decoration:none;">
									<img src="<?php echo SITEURL ?>/assets/admin/pages/img/delete.png" width="20" height="20" /> </a>
<!--                                                                    <button class="btn btn-warning" data-toggle="confirmation" id="bs_confirmation_demo_<?php echo $i; ?>" value="<?php echo $data['market_id'] ;?>">Delete</button>-->
                                                                </td>
                                                                
							</tr>
							<?php $i++;} ?>
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
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo SITEURL ?>/assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script>
jQuery(document).ready(function() {       
    // initiate layout and plugins
    Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
UIConfirmations.init(); // init page demo
});
</script>
</body>

<!-- END BODY -->
</html>

<script>
/* Delete  Entered Data display message ======-------------------->>>>>>*/
$(document).ready(function() {
  $('#hide div').live('click',function() { 
    $(this).parent().parent().remove(); 
  });
});  

/* Delete upload display message ======-------------------->>>>>>*/
$(document).ready(function() {
  $('span#delete ').live('click',function() { 
    $(this).parent().parent().remove(); 
  });
});  
</script> 

<?php
//Clear all the Message Session Variables...
if(isset($_SESSION['returnmessage'])) { unset($_SESSION['returnmessage']);}
?>