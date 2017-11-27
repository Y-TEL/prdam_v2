<?php
/**
 * Description of User
 *
 * @author Jaliya
 */
session_start();
require_once '../../includes/views/define_include.php';
require_once '../../classes/marketing/file_upload.php';

$loginManager = new LoginManager();
$logerHD = new LoggerHD();

if (!$loginManager->confirm_member()) {
    header('Location: ../../index.php');
}

$page = new Page();
$page->setIcon("iconfa-home");
$page->setHeader("Call Disposition");
$page->setTag_line("upload_files");
$page->setMenu_active("file_upload");
$page->setMenu_group("file_upload");


date_default_timezone_set('America/New_York');
@$today = date('d-m-Y');

$drop_downs = new DropDownlist();

$getAllGraphicsMainCategory = $drop_downs->getAllGraphicsMainCategory();
$getAllGraphicsSubCategory = $drop_downs->getAllGraphicsSubCategory();
$getAllGraphicsBusinessName = $drop_downs->getAllGraphicsBusinessName();
$getAllGraphicsPaperSize = $drop_downs->getAllGraphicsPaperSize();
$getAllCarrier = $drop_downs->getAllCarrier();
$getAllSLUsers = $drop_downs->getAllSLUsers();

@$success = $_GET["success"];
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
            $(document).ready(function () {
                $("#uploadGdrive").validate({
                    rules:
                            {
                                folderName: "required",
                                subCategory: "required",
                                businessName: "required",
                                name: "required",
                                carrier: "required",
                                designedBy: "required",
                               act_phone_no: {
                                    required: true,
                                    number: false,
                                    minlength: 10,
                                    maxlength: 15
                                },
                                
                            },
                    messages:
                            {
                                folderName: "required",
                                subCategory: "required",
                                businessName: "required",
                                 name: "required",
                                 carrier: "required",
                                 designedBy: "required",
                                act_phone_no: {
                                    required: "Enter Telephone No.",
                                    number: "Enter number.",
                                    minlength: $.validator.format("Please enter 10 characters."),
                                    maxlength: $.validator.format("Please enter 10 characters."),
                                },
                               
                            },
               
                });
                
                 $( "#datepicker" ).datepicker();
            });
            
        jQuery(document).ready(function () {
             jQuery("body").on("change", "#folderName", function(e) {
                 
                jQuery("#size").val(''); 
                jQuery("#paper_size").val(''); 
                jQuery("#resolution").val(''); 
                
                var main_category = jQuery("#folderName").val(); 
                if(main_category=="1" || main_category=="6" || main_category=="8"){
                     jQuery("#display_size").show();
                     jQuery("#display_paper_size").hide();
                     jQuery("#display_res").hide();
                     
                 }
                 
                if(main_category=="3" || main_category=="5"){
                     jQuery("#display_size").hide();
                     jQuery("#display_paper_size").show();
                     jQuery("#display_res").hide();
                 }
                 
                if(main_category=="2" || main_category=="4" || main_category=="7"){
                     jQuery("#display_size").hide();
                     jQuery("#display_paper_size").hide();
                     jQuery("#display_res").show();
                 }
        
        
            });
        });
            
        </script>
    <script>
            setTimeout(function () {
                jQuery('.alert-success').fadeOut('slow');

            }, 4000);

        </script>
        <style>
            .errors{background-color: #d9534f;
                    display: inline;
                    padding: .2em .6em .3em;
                    font-size: 14px;
                    font-weight: 600;
                    line-height: 1;
                    color: #fff;
                    text-align: center;
                    white-space: nowrap;
                    vertical-align: baseline;
                    border-radius: .25em;		}
            </style>

        </head>
        <!-- END HEAD -->

        <!-- BEGIN BODY -->
        <body class="page-header-fixed page-footer-fixed page-quick-sidebar-over-content">
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
                <div class="page-content" style="min-height: 950px;">

                    <!-- BEGIN PAGE HEADER-->
                    <div id="">
                          <?php if (isset($success) AND $success = "1") { ?>
                              <div class="alert alert-success">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              Successfully Uploded  
                          </div>
                    <?php } ?>
                    </div>
                    <!-- END PAGE HEADER-->
                    <!-- BEGIN PAGE CONTENT-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabbable tabbable-custom boxless tabbable-reversed">

                                <div class="tab-pane active" id="tab_2">
                                    <div class="portlet box green">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-gift"></i>File Upload
                                            </div>

                                        </div>
                                        <div class="portlet-body form">
                                            <!-- BEGIN FORM-->


                                            <form id="uploadGdrive" class="form-horizontal" name="uploadGdrive" action="file_upload_action.php" method="post" enctype="multipart/form-data"> 
                                                <div class="form-body">
                                                    <div class="row">   
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Main Category : <span style="font-size:14px; color:#D90000;">*</span></label>
                                                                <div class="col-md-5">
                                                                    <select name="folderName" class="select2_category form-control" id="folderName">
                                                                        <option value="" selected="true" disabled="">--- Select ---</option>
                                                                        <?php
                                                                        foreach ($getAllGraphicsMainCategory as $values) {
                                                                            ?>
                                                                            <option value="<?php echo $values['category_id']; ?>"><?php echo $values['category_name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->
                                                    <input type="hidden" name="folderDesc" value="sample" placeholder="Pictures of my cat">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Sub Category : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                <div class="col-md-5">
                                                                    <select name="subCategory" class="select2_category form-control" id="subCategory">
                                                                        <option value="" selected="true" disabled="">--- Select ---</option>
                                                                        <?php
                                                                        foreach ($getAllGraphicsSubCategory as $values) {
                                                                            ?>
                                                                            <option value="<?php echo $values['sub_category_id']; ?>"><?php echo $values['sub_category_name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Date : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                <div class="col-md-5">
                                                                    <div class="input-group date" id="datepicker" data-date-format="mm-dd-yyyy">
                                                                        <input type="text" class="form-control valid" id="datepicker" readonly="" name="uploadDate" value="01-05-2016" aria-required="true" aria-invalid="false">
                                                                        <span class="input-group-btn">
                                                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Business Name   : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                <div class="col-md-5">
                                                                    <select name="businessName" class="select2_category form-control" id="businessName">
                                                                        <option value="" selected="true" disabled="">--- Select ---</option>
                                                                        <?php
                                                                        foreach ($getAllGraphicsBusinessName as $values) {
                                                                            ?>
                                                                            <option value="<?php echo $values['business_id']; ?>"><?php echo $values['business_name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    </div>
                                                    <!--/row-->

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Name : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                <div class="col-md-5">
                                                                    <input type="text" name="name" id="name" class="form-control" value=""/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Carrier : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                <div class="col-md-5">
                                                                    <select name="carrier" class="select2_category form-control" id="carrier">
                                                                        <option value="" selected="true" disabled="">--- Select ---</option>
                                                                        <?php
                                                                        foreach ($getAllCarrier as $values) {
                                                                            ?>
                                                                            <option value="<?php echo $values['carrier_id']; ?>"><?php echo $values['carrier_name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Designed by : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                <div class="col-md-5">
                                                                    <select name="designedBy" class="select2_category form-control" id="designedBy">
                                                                        <option value="" selected="true" disabled="">--- Select ---</option>
                                                                        <?php
                                                                        foreach ($getAllSLUsers as $values) {
                                                                            ?>
                                                                            <option value="<?php echo $values['user_id']; ?>"><?php echo $values['user_first_name'] . " " . $values['user_last_name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->
                                                    
                                                    <div class="row" id="display_size" style="display: none">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Size : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                <div class="col-md-5">
                                                                    <input type="text" name="size" id="size" class="form-control" value=""/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->
                                                       <div class="row" id="display_res" style="display: none">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Resolution : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                <div class="col-md-5">
                                                                    <input type="text" name="resolution" id="resolution" class="form-control" value=""/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->
                                                    
                                                    <div class="row" id="display_paper_size" style="display: none">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Paper Size : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                <div class="col-md-5">
                                                                    <select name="paper_size" class="select2_category form-control" id="designedBy">
                                                                        <option value="" selected="true" disabled="">--- Select ---</option>
                                                                        <?php
                                                                        foreach ($getAllGraphicsPaperSize as $values) {
                                                                            ?>
                                                                            <option value="<?php echo $values['paper_size_id']; ?>"><?php echo $values['paper_size_name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!--/row-->
                                                    
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-2">Attach File : <span style="font-size:14px; color:#D90000;" >*</span></label>
                                                                <div class="col-md-5">
                                                                    <input type="file" name="Filedata" required>
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
                                                                </div>
                                                            </div>
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

<script type="text/javascript">

    $('#counter').text('200 characters left');
    $('#act_comments').keyup(function () {
        var max = 200;
        var len = $(this).val().length;
        if (len >= max) {
            $('#counter').addClass('errors');
            $('#counter').text(' you have reached the limit');

        } else {
            var ch = max - len;
            $('#counter').removeClass('errors');
            $('#counter').text(ch + ' characters left');
        }
    });
</script>

<?php
//Clear all the Message Session Variables...
if (isset($_SESSION['returnmessage'])) {
    unset($_SESSION['returnmessage']);
}
?>