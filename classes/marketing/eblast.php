<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

class Eblast {

    private $db;

    public function __construct() {

        try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addNewEblast($cam_title,$eblast_product,$eblast_respond,$eblast_dealer,$eblast_agent,$eblast_date,$eblast_time_sl,$USTime,$dealer_satisfaction,$created_date){
           
        $query = "INSERT INTO ".RDAMS_EBLAST." (eblast_camp_id,eblast_product,eblast_respond,eblast_dealer,eblast_agent_id,eblast_date,eblast_time_sl,eblast_time_us,eblast_dealer_satis,eblast_entered_date) VALUES (?,?,?,?,?,?,?,?,?,?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $cam_title); 
        $stmt->bindParam(2, $eblast_product);
        $stmt->bindParam(3, $eblast_respond); 
        $stmt->bindParam(4, $eblast_dealer);
        $stmt->bindParam(5, $eblast_agent);
        $stmt->bindParam(6, $eblast_date);
        $stmt->bindParam(7, $eblast_time_sl);
        $stmt->bindParam(8, $USTime);
        $stmt->bindParam(9, $dealer_satisfaction);
        $stmt->bindParam(10, $created_date);
        
        $stmt->execute();

        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    

    public function viewEblastList() {
        
        $query = "SELECT * FROM ".RDAMS_EBLAST." "
                . "LEFT  JOIN ".RDAMS_CAMPAIGN." ON (".RDAMS_EBLAST.".eblast_camp_id = ".RDAMS_CAMPAIGN.".camp_id)"
                . "LEFT  JOIN ".RDAMS_EMPLOYEE." ON (".RDAMS_EBLAST.".eblast_agent_id = ".RDAMS_EMPLOYEE.".user_id)"
                . "WHERE eblast_active=1 ORDER BY eblast_id DESC";
        		     
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
          
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    
    public function viewSelectedEblast($id) {
        
      $query = "SELECT * FROM ".RDAMS_EBLAST." "
              . "LEFT  JOIN ".RDAMS_CAMPAIGN." ON (".RDAMS_EBLAST.".eblast_camp_id = ".RDAMS_CAMPAIGN.".camp_id)"
              . "LEFT  JOIN ".RDAMS_EMPLOYEE." ON (".RDAMS_EBLAST.".eblast_agent_id = ".RDAMS_EMPLOYEE.".user_id)"
              . "WHERE eblast_id='$id' ";
        
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

    public function UpdateEblast($cam_title,$eblast_product,$eblast_respond,$eblast_dealer,$eblast_date,$eblast_time_sl,$USTime,$dealer_satisfaction,$id){

        $query = "UPDATE ".RDAMS_EBLAST." SET eblast_camp_id=?,eblast_product=?,eblast_respond=?,eblast_dealer=?,eblast_date=?,eblast_time_sl=?,eblast_time_us=?,eblast_dealer_satis=? WHERE eblast_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $cam_title); 
        $stmt->bindParam(2, $eblast_product);
        $stmt->bindParam(3, $eblast_respond); 
        $stmt->bindParam(4, $eblast_dealer);
        $stmt->bindParam(5, $eblast_date);
        $stmt->bindParam(6, $eblast_time_sl);
        $stmt->bindParam(7, $USTime);
        $stmt->bindParam(8, $dealer_satisfaction);
	$stmt->bindParam(9, $id);

        $stmt->execute();
        
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
        
    }
	
	public function DeleteEblast($iid) {

        $query = "UPDATE ".RDAMS_EBLAST." SET eblast_active=0 WHERE eblast_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();

        $results = $stmt->rowCount();
    }	       
  
}

?>
