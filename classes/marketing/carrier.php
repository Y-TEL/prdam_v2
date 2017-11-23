<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

class Carrier {

    private $db;

    public function __construct() {

        try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addNewCarrier($carrier_name,$desc,$carrier_image){
             
        $query = "INSERT INTO ".RDAMS_CARRIER_DETAILS." (carrier_name,carrier_desc,carrier_image) VALUES (?,?,?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $carrier_name); 
        $stmt->bindParam(2, $desc);
        $stmt->bindParam(3, $carrier_image);
        
        $stmt->execute();

        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    

    public function viewCarrierList() {
        
        $query = "SELECT * FROM ".RDAMS_CARRIER_DETAILS." WHERE carrier_active=1 ORDER BY carrier_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
          
        $rows = $stmt->fetchAll();
        return $rows;
    }
    
    
    public function viewSelectedCarrier($id) {
        
      $query = "SELECT * FROM ".RDAMS_CARRIER_DETAILS." WHERE carrier_id='$id' ";
        
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

    public function UpdateCarrier($carrier_name,$desc,$carrier_image,$id){

        $query = "UPDATE ".RDAMS_CARRIER_DETAILS." SET carrier_name=?,carrier_desc=?,carrier_image=? WHERE carrier_id=?";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $carrier_name);
        $stmt->bindParam(2, $desc);
        $stmt->bindParam(3, $carrier_image);
	$stmt->bindParam(4, $id);

        $stmt->execute();
        
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
	
    public function DeleteCarrier($iid) {

        $query = "UPDATE ".RDAMS_CARRIER_DETAILS." SET carrier_active=0 WHERE carrier_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();

        $results = $stmt->rowCount();

    }	       
}

?>
