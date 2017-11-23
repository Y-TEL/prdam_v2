<?php

/**
 * Description of User
 *
 * @author Nirushika
 */

date_default_timezone_set('America/New_York');

class Event {

   private $db;

    public function __construct() {

    try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function addEvent($event_name,$event_date,$event_time_us,$SLTime,$entered_by,$created_date,$created_time){
              
        $query = "INSERT INTO ".RDAMS_EVENTS." (event_name,event_date,event_time_usa,event_time_sl,event_entered_by,event_entered_date,event_entered_time) VALUES (?,?,?,?,?,?,?)";
				
        $stmt = $this->db->prepare($query);
        
         //echo var_export($stmt->errorInfo());
        
        $stmt->bindParam(1, $event_name);
        $stmt->bindParam(2, $event_date);
        $stmt->bindParam(3, $event_time_us);
        $stmt->bindParam(4, $SLTime);
        $stmt->bindParam(5, $entered_by);
        $stmt->bindParam(6, $created_date);
        $stmt->bindParam(7, $created_time);
        
        $stmt->execute();
       
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Create (Events - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Event='.$event_name.':-::-:)]'.'|-|');

        $results = $stmt->rowCount();
        
        if ($results > 0) {
            return $msg = "Successfully Added";
        } else {
            return $msg = "Something went wrong. Try again";
        }
    }
    
    public function viewEventsList() {
        
        $query = "SELECT * FROM ".RDAMS_EVENTS." WHERE event_active=1 ORDER BY event_id DESC";
        
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();
        
        $rows = $stmt->fetchAll();
        return $rows;
    }
    

    public function viewSelectedEvent($id){
        
      $query = "SELECT * FROM ".RDAMS_EVENTS." WHERE event_id=? ";
        
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

   public function updateEvent($event_name,$event_date,$event_time_us,$SLTime,$id){

        $query = "UPDATE ".RDAMS_EVENTS." SET event_name=?,event_date=?,event_time_usa=?,event_time_sl=? WHERE event_id=?";
		
        $stmt = $this->db->prepare($query);
		
        $stmt->bindParam(1, $event_name);
        $stmt->bindParam(2, $event_date);
        $stmt->bindParam(3, $event_time_us);
        $stmt->bindParam(4, $SLTime);
        $stmt->bindParam(5, $id); 
        
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Update (Events - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Event='.$event_name.':-::-:)]'.'|-|');

        //$stmt->debugDumpParams();
        $results = $stmt->rowCount();

        if ($results > 0) {
            return $msg = "Updated " . $results . " record";
        } else {
            return $rows = "";
        }
    }
    
    public function DeleteEvent($iid) {

        $query = "UPDATE ".RDAMS_EVENTS." SET event_active=0 WHERE event_id=?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $iid);
		
        $stmt->execute();
        
        $logerHD = new LoggerHD();
        $logerHD->WriteLog('|-|'.'['.date('Y-m-d h:i:s a').' -- Delete (Events - '.$_SESSION['first_name'].' :-: '.$_SESSION['user_name'].' :-: '.date('Y-m-d h:i:s').' :-: '.'Event ID='.$iid.':-::-:)]'.'|-|');

        $results = $stmt->rowCount();
    }
   
}
?>
