<?php
session_start();
 require_once '../../includes/views/define_include.php';
 require_once '../../classes/marketing/file_upload.php';


$id = $_POST["id"];

$file_upload = new gDriveUpload();
$graphic_details = $file_upload->viewSelectedGraphicDetails($id);
$imgLocation = "http://rdams.com/api1/upload/".$graphic_details["main_category"]."/".$graphic_details["file_name"];
?>
<div class="form-body">
    <div class="row">   
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-6"><b>Main Category</b></label>
                <div class="col-md-6">
                  <?php echo $graphic_details['category_name']; ?>
                </div>
            </div>
        </div>
        
           <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-6"><b>Sub Category</b></label>
               <div class="col-md-6">
                  <?php echo $graphic_details['sub_category_name']; ?>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->
    <input type="hidden" name="folderDesc" value="sample" placeholder="Pictures of my cat">


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-6"><b>Date</b></label>
                <div class="col-md-6">
                 <?php echo $graphic_details['date']; ?>
                </div>
            </div>
        </div>
    <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-6"><b>Business Name</b> </label>
                <div class="col-md-6">
                  <?php echo $graphic_details['business_name']; ?>
                </div>
            </div>
        </div>
        
    </div>
    <!--/row-->
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-6"><b>Name</b></label>
               <div class="col-md-6">
                   <?php echo $graphic_details['name']; ?>
                </div>
            </div>
        </div>
        <!--/span-->
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-6"><b>Carrier</b> </label>
                <div class="col-md-6">
                   <?php echo $graphic_details['carrier_name']; ?>
                </div>
            </div>
        </div>
    </div>
    <!--/row-->

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-6"><b>Designed by</b> </label>
                <div class="col-md-6">
                  <?php echo $graphic_details['user_first_name']." ".$graphic_details['user_last_name']; ?>
                </div>
            </div>
        </div>
        <!--/span-->
    </div>
    <br />
    <div>
      <img src="<?php echo $imgLocation; ?>" alt="logo" class="logo-default" height="100%" width="100%">
    </div>
    
    <div class="modal-footer">
             <a class="btn green" href="download?file=<?php echo $imgLocation; ?>"><i class="fa fa-download"></i> Download</a>
             <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>