<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

class Campaign {

    private $db;

    public function __construct() {

        try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addNewCampaign($cam_title,$cam_date,$cam_time_sl,$USTime){
             
        $query = "INSERT INTO ".RDAMS_CAMPAIGN." (camp_title,camp_date,camp_time_sl,camp_time_us) VALUES (?,?,?,?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $cam_title); 
        $stmt->bindParam(2, $cam_date);
        $stmt->bindParam(3, $cam_time_sl);
        $stmt->bindParam(4, $USTime);
        
        $stmt->execute();

        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    

    public function viewCampaignList() {
        
        $query = "SELECT * FROM ".RDAMS_CAMPAIGN." WHERE camp_active=1 ORDER BY camp_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
		  
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    
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
  
}

?>
