<?php
/**
 * Description of User
 *
 * @author Nirushika
 */
session_start();

require_once '../../includes/views/define_include.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Conference Bridge");
$page->setTag_line("Conference_Bridge_Page");
$page->setMenu_active("View_Conference_Bridge");
$page->setMenu_group("Marketing_Department");
?>
<!DOCTYPE html>

<html lang="en">

<head>
<!-- class head -->
<?php require("../../includes/views/head_1.php") ?>
<!-- class head -->
<link href="<?php echo SITEURL ?>/assets/admin/pages/css/pricing-table.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo SITEURL ?>/assets/admin/pages/css/timeline-old.css" rel="stylesheet" type="text/css"/>

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
                        <h3 class="page-title">
			CONFERENCE BRIDGE
			</h3>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
                                        <div class="col-md-6">
                                        <div id="myCarousel" class="carousel image-carousel slide">
                                            <img src="<?php echo SITEURL ?>/assets/admin/pages/media/gallery/poly.jpg" class="img-responsive" alt="">
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="timeline">
						<li class="timeline-blue">
							<div class="timeline-time">
								<span class="time">
								Call.. </span>
							</div>
							<div class="timeline-icon">
								<i class="fa fa-rss"></i>
							</div>
							<div class="timeline-body">
								<h2>It Is Easy..</h2>
								<div class="timeline-content">
									Please make sure that all calls are done through these numbers. Further if you want to create your own conference call numbers kindly go to the following link and just sign up, all you need is an email id for this.
								</div>
								<div class="timeline-footer">
                                                                    <a href="https://www.freeconferencecall.com/" class="nav-link" target="_blank">
									https://www.freeconferencecall.com/ 
									</a>
								</div>
							</div>
						</li>
                                                <li class="timeline-green timeline-noline">
							<div class="timeline-time">
								
							</div>
							<div class="timeline-icon">
								<i class="fa fa-comments"></i>
							</div>
							<div class="timeline-body">
                                                            <h2>DIAL IN NO</h2>
								<div class="timeline-content">
                                                                    <h1>712-775-7031</h1>								
                                                                </div>
								
							</div>
						</li>
					</ul>
                                        </div>
                                        
					<!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								
							</div>
							<div class="tools">
								
							</div>
						</div>
						<div class="portlet-body">
							<div class="row margin-bottom-40">
								<!-- Pricing -->
								<div class="col-md-6">
									<div class="pricing hover-effect">
										<div class="pricing-head">
                                                                                    <h3 style="height: 85px;">MVNO Call (All staff)</h3>
                                                                                        <h1>PIN - 954521</h1>
										</div>
                                                                               
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="pricing hover-effect">
										<div class="pricing-head">
											<h3 style="height: 85px;">Dealer Training/External Brand Training</h3>
											<h1>PIN - 602279364</h1>
										</div>
									</div>
								</div>
								<!--//End Pricing -->
							</div>
						</div>
					</div>
					<!-- END INLINE NOTIFICATIONS PORTLET-->
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
