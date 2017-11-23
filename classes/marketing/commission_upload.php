<?php

/**
 * UPLOAD COMMISSION CSV
 *
 * @author Jaliya
 */

class commissionFileUpload {

    private $db;

    public function __construct() {

        try {
            $this->db = new Connection();
            $this->db = $this->db->dbConnect();
        } catch (PDOException $e) {
            die('ERROR:' . $e->getMessage());
        }
    }

    public function uploadCommissionReport($commission_report){
        
    // get the csv file and open it up
    $file = $commission_report['tmp_name']; 
    $handle = fopen($file,"r"); 
    
    // unset the first line like this       
    fgets($handle);

    // created loop here
    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        
    date_default_timezone_set('America/New_York');
    $purchase_date = date('Y-m-d', strtotime($data[4]));   
    $date_activated = date('Y-m-d', strtotime($data[7]));  
    
    if($data[0]!=""){    
    $query = "INSERT INTO ".RDAMS_COMMISIONS." (dealer_id,
                dealer_name,
                sim_no,
                market,
                purchase_date,
                sold_price,
                plan,
                date_activated,
                pin_no,
                item_description,
                item_name,
                category_name,
                commision,
                commision_type) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
				
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $data[0]); 
        $stmt->bindParam(2, $data[1]);
        $stmt->bindParam(3, $data[2]);
        $stmt->bindParam(4, $data[3]);
        $stmt->bindParam(5, $purchase_date); 
        $stmt->bindParam(6, $data[5]);
        $stmt->bindParam(7, $data[6]);
        $stmt->bindParam(8, $date_activated);
        $stmt->bindParam(9, $data[8]);
        $stmt->bindParam(10, $data[9]);
        $stmt->bindParam(11, $data[10]);
        $stmt->bindParam(12, $data[11]);
        $stmt->bindParam(13, $data[12]);
        $stmt->bindParam(14, $data[13]);

        $stmt->execute();
        }       
    }
        fclose($handle);
        return $success=1;
    } 
    
   /*
    public function uploadCommissionReport1($commission_report){
        
    // get the csv file and open it up
    $file = $commission_report['tmp_name']; 
    $handle = fopen($file,"r"); 

$continue = true;
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && $continue) {
    // check for valid email (presuming it's in column 1)
    $continue = filter_var($data[0], FILTER_VALIDATE_EMAIL);
}
fclose($handle);

if($continue){
    // using LOAD DATA will be a lot quicker than individual queries!
    $query = "LOAD DATA INFILE '/full/path/to/test.csv'";
}
    }
    * 
    */
}
?>
