<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

date_default_timezone_set('America/New_York');

class DealerMarket {

   private $db;

    public function __construct() {

    try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addMarket($market_name){
              
        $query = "INSERT INTO ".RDAMS_DEALER_MARKET." (market_name) VALUES (?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $market_name);
        
        $stmt->execute();
       
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Create (Market - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Market='.$market_name.':-::-:)]'.'|-|');

        $results = $stmt->rowCount();
        
        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    
    public function viewDealerMarketList() {
        
        $query = "SELECT * FROM ".RDAMS_DEALER_MARKET." WHERE market_active=1 ORDER BY market_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
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

   public function updateMarket($market_name,$id){

        $query = "UPDATE ".RDAMS_DEALER_MARKET." SET market_name=? WHERE market_id=?";
		
        $stmt = $this->db->prepare($query);
		
        $stmt->bindParam(1, $market_name);
        $stmt->bindParam(2, $id); 
        
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Update (Market - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Market Name='.$market_name.':-::-:)]'.'|-|');

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
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Delete (Market - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Market ID='.$iid.':-::-:)]'.'|-|');

        $results = $stmt->rowCount();
    }
   
}
?>
