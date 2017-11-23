<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

date_default_timezone_set('America/New_York');

class Market {

   private $db;

    public function __construct() {

    try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addMarket($market_name,$market_RM,$market_region,$market_territory,$market_territory_code,$market_ACM,$market_assistant_manager,$market_supervisor,$market_mark_exe,$market_type,$market_active_dealers,$market_inactive_dealers){
              
        $query = "INSERT INTO ".RDAMS_DEALER_MARKET." (market_name,market_RM,market_region,market_territory,market_territory_code,market_ACM,market_AM,market_supervisor,market_ME,market_type,market_active_dealers,market_inactive_dealers) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $market_name);
        $stmt->bindParam(2, $market_RM);
        $stmt->bindParam(3, $market_region);
        $stmt->bindParam(4, $market_territory);
        $stmt->bindParam(5, $market_territory_code);
        $stmt->bindParam(6, $market_ACM);
        $stmt->bindParam(7, $market_assistant_manager);
        $stmt->bindParam(8, $market_supervisor);
        $stmt->bindParam(9, $market_mark_exe);
        $stmt->bindParam(10, $market_type);
        $stmt->bindParam(11, $market_active_dealers);
        $stmt->bindParam(12, $market_inactive_dealers);
        
        $stmt->execute();
       
        $results = $stmt->rowCount();
        
        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    
    public function getAllRegionalManagerAmSup(){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE." "
                . "LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)"
                . "WHERE user_active='1' AND (user_des_id=12 OR user_des_id=42 OR user_des_id=18 OR user_des_id=22) ORDER BY user_des_id  ASC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();

        $rows = $stmt->fetchAll();
        return $rows;
    } 
    
    public function viewMarketList() {
        
        $query = "SELECT * FROM ".RDAMS_DEALER_MARKET." "
                . "LEFT  JOIN ".RDAMS_EMPLOYEE." ON (".RDAMS_DEALER_MARKET.".market_ME = ".RDAMS_EMPLOYEE.".user_id)"
                . "LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)"
                . "WHERE market_active=1 ORDER BY market_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    public function selectDealerRM($RM){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $RM);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function selectDealerACM($ACM){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $ACM);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function selectDealerAM($AM){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $AM);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function selectDealerSup($SUP){
        
        $query = "SELECT * FROM ".RDAMS_EMPLOYEE."
                 LEFT  JOIN ".RDAMS_EMP_JOB_HISTORY." ON  (".RDAMS_EMPLOYEE.".user_id = ".RDAMS_EMP_JOB_HISTORY.".emp_id)
                 WHERE user_id=?";
        		     
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $SUP);

        $stmt->execute();

        $rows = $stmt->fetch();
        return $rows;
    }
    
    public function viewSelectedMarket($id){
        
      $query = "SELECT * FROM ".RDAMS_DEALER_MARKET." WHERE market_id=? ";
        
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

   public function updateMarket($market_name,$market_RM,$market_region,$market_territory,$market_territory_code,$market_ACM,$market_assistant_manager,$market_supervisor,$market_mark_exe,$market_type,$market_active_dealers,$market_inactive_dealers,$id){

        $query = "UPDATE ".RDAMS_DEALER_MARKET." SET market_name=?,market_RM=?,market_region=?,market_territory=?,market_territory_code=?,market_ACM=?,market_AM=?,market_supervisor=?,market_ME=?,market_type=?,market_active_dealers=?,market_inactive_dealers=? WHERE market_id=?";
		
        $stmt = $this->db->prepare($query);
		
        $stmt->bindParam(1, $market_name);
        $stmt->bindParam(2, $market_RM);
        $stmt->bindParam(3, $market_region);
        $stmt->bindParam(4, $market_territory);
        $stmt->bindParam(5, $market_territory_code);
        $stmt->bindParam(6, $market_ACM);
        $stmt->bindParam(7, $market_assistant_manager);
        $stmt->bindParam(8, $market_supervisor);
        $stmt->bindParam(9, $market_mark_exe);
        $stmt->bindParam(10, $market_type);
        $stmt->bindParam(11, $market_active_dealers);
        $stmt->bindParam(12, $market_inactive_dealers);
        $stmt->bindParam(13, $id); 
        
        $stmt->execute();
        
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
    
    public function DeleteMarket($iid) {

        $query = "UPDATE ".RDAMS_DEALER_MARKET." SET market_active=0 WHERE market_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();
        
        $results = $stmt->rowCount();
    }
   
}
?>
