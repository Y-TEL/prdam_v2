<?php

/**
 * UPLOAD FILES TO G-DRIVE
 *
 * @author Jaliya
 */

class gDriveUpload {

    private $db;

    public function __construct() {

        try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addUploadedFileDetails($main_category,$sub_category,$date,$business_name,$name,$carrier,$designed_by,$file_name,$file_name_id,$added_by,$size,$paper_size,$resolution){

        $query = "INSERT INTO ".RDAMS_GRAPHICS_UPLOADED_FILES." (main_category,
                sub_category,
                date,
                business_name,
                name,
                carrier,
                designed_by,
                file_name,
                file_name_id,
                added_by,
                size,
                paper_size,
                resolution) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
				
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $main_category); 
        $stmt->bindParam(2, $sub_category);
        $stmt->bindParam(3, $date);
        $stmt->bindParam(4, $business_name);
        $stmt->bindParam(5, $name); 
        $stmt->bindParam(6, $carrier);
        $stmt->bindParam(7, $designed_by);
        $stmt->bindParam(8, $file_name);
        $stmt->bindParam(9, $file_name_id);
        $stmt->bindParam(10, $added_by);
        $stmt->bindParam(11, $size);
        $stmt->bindParam(12, $paper_size);
        $stmt->bindParam(13, $resolution);
        
        $stmt->execute();

        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    

    public function viewMainCategoryName() {
        
        $query = "SELECT * FROM ".RDAMS_GRAPHICS_MAIN_CATEGORY." WHERE category_active=1 ORDER BY category_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
	  
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewUploadedFiles() {
        
        $query = "SELECT * FROM ".RDAMS_GRAPHICS_UPLOADED_FILES." WHERE active=1 ORDER BY file_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
	  
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function viewSelectedGraphicDetails($file_name_id) {
        
        $query = "SELECT * FROM ".RDAMS_GRAPHICS_UPLOADED_FILES."
             LEFT JOIN ".RDAMS_GRAPHICS_MAIN_CATEGORY." ON (".RDAMS_GRAPHICS_MAIN_CATEGORY.".category_id = ".RDAMS_GRAPHICS_UPLOADED_FILES.".main_category)
             LEFT JOIN ".RDAMS_GRAPHICS_SUB_CATEGORY." ON (".RDAMS_GRAPHICS_SUB_CATEGORY.".sub_category_id = ".RDAMS_GRAPHICS_UPLOADED_FILES.".sub_category)
             LEFT JOIN ".RDAMS_GRAPHICS_BUSINESS_NAME." ON (".RDAMS_GRAPHICS_BUSINESS_NAME.".business_id = ".RDAMS_GRAPHICS_UPLOADED_FILES.".business_name)             
             LEFT JOIN ".RDAMS_CARRIER_DETAILS." ON (".RDAMS_CARRIER_DETAILS.".carrier_id = ".RDAMS_GRAPHICS_UPLOADED_FILES.".carrier)
             LEFT JOIN ".RDAMS_EMPLOYEE." ON (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_GRAPHICS_UPLOADED_FILES.".designed_by)             
             WHERE active=1 AND file_name_id=?";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $file_name_id);
        $stmt->execute();
        //$stmt->debugDumpParams();
        //$results = $stmt->rowCount();
		  
        $rows = $stmt->fetch();
        return $rows;
    }
    
    /*
    public function viewSelectedCampaign($id) {
        
      $query = "SELECT * FROM ".RDAMS_CAMPAIGN." WHERE camp_id='$id' ";
        
        $stmt = $this->db->prepare($query);
   
        $stmt->bindParam(1, $id);
        $stmt->execute();
     
        $results = $stmt->rowCount();

        if ($results > 0) {
            $rows = $stmt->fetch();
            return $rows;
        } else {
            return $rows = "No records found";
        }
    }

    public function UpdateCampaign($cam_title,$cam_date,$cam_time_sl,$USTime,$id){

        $query = "UPDATE ".RDAMS_CAMPAIGN." SET camp_title=?,camp_date=?,camp_time_sl=?,camp_time_us=? WHERE camp_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $cam_title);
        $stmt->bindParam(2, $cam_date);
        $stmt->bindParam(3, $cam_time_sl);
        $stmt->bindParam(4, $USTime);
	$stmt->bindParam(5, $id);

        $stmt->execute();
        
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
	
	 public function DeleteCampaign($iid) {

        $query = "UPDATE ".RDAMS_CAMPAIGN." SET camp_active=0 WHERE camp_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();

        $results = $stmt->rowCount();
    }	       
  

     * }
     */
}
?>
