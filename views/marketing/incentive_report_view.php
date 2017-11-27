<?php
session_start();
require_once '../../includes/views/define_include.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Incentive");
$page->setTag_line("Incentive Page");
$page->setMenu_active("Incentive_Report");
$page->setMenu_group("Marketing_Department");

date_default_timezone_set('America/New_York');
?>
<!DOCTYPE html>

<html lang="en">
<!-- BEGIN HEAD -->
<head>
<!-- class head -->
<?php require("../../includes/views/head_1.php") ?>
<!-- class head -->

<style>
.text-info {
    font-weight: 500;
}
.text-success {
    font-weight: 500;
}
</style>
    
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
                <div class="portlet box green">
			<!-- BEGIN PAGE HEADER-->
                        <div class="portlet-title">
                            <div class="caption">
                            INCENTIVE - AUGUST 2015
                            </div>
                        </div>
                        <div class="portlet-body">
			<!-- END PAGE HEADER-->
			<!-- BEGIN DASHBOARD STATS -->
                        <div style=" margin: 0% 5% 0% 5%;">
			
                        
                            <div class="row">
                                <div class="col-md-12">
				<h3 style="padding-bottom:30px;"><span class="caption-subject font-red-sunglo bold uppercase"></span>  </h3>
                                <div class="col-md-4">
                                    <h3 class="text-info"> 1) NAUSH&lsquo;S TEAM </h3>
                                    <h3 class="text-info"> 2) ALI&lsquo;S  TEAM </h3>
                                    <h3 class="text-info"> 3) JOHN IM&lsquo;S TEAM </h3>
                                    <h3 class="text-info"> 4) STEVE&lsquo;S TEAM </h3>
				</div>
                                
                                <div class="col-md-4">
                                    <h3 class="text-success">- &nbsp;&nbsp;  SHAMEER / ANISUR</h3>
                                    <h3 class="text-success">- &nbsp;&nbsp; JOHN RIVERA</h3>
                                    <h3 class="text-success">- &nbsp;&nbsp;  JOHN MENDIETA</h3>
                                    <h3 class="text-success">- &nbsp;&nbsp;  ABDUL / CHASTITY</h3>
				</div> 
                                <div class="col-md-4">
                                    <img class="news-block-img" src="<?php echo SITEURL ?>/assets/global/img/cash.jpg" alt="" width="100%" height="350px">
                                </div>
                                </div>
                            </div>
                            
                        

			<!-- END DASHBOARD STATS -->
                        </div>
			<div class="clearfix">
			</div>
                        </div>
                </div>
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