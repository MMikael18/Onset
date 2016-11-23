<?php
// USER INPUT
class Links extends aApiBackend{

    function start (){
        if (!isset($_SESSION['USER'])) {            
           header("Location:../login");
        }
    }

    public function index($p) {}

    public function setLink($p) {

        $title = "Google";
        $url = "www.google.fi";
        $decs = "lorem decs";

        $userid = $_SESSION['USER']['id'];
        $q =   "INSERT INTO pages (title,url,description) VALUES ('".$title."','".$url."','".$desc."');
                SET @page_id = LAST_INSERT_ID();
                INSERT INTO user_to_pages (userid,pageid) VALUES(".$userid.", @page_id);";

        try{
            $conn = $this->getDataDB("onset");
            //$hash = password_hash($password, PASSWORD_DEFAULT);
            $conn->exec($q);
            //echo json_encode($links);
        }catch(PDOException $e)
        {
            echo json_encode(array("Error" => $e->getMessage()));
        }
    }

    public function getLinks($p) {

        //$userid = $_SESSION['USER']['id'];
        $q = "SELECT * FROM pages";
        try{
            $conn = $this->getDataDB("onset");
            $STH = $conn->query($q);
            # setting the fetch mode
            $STH->setFetchMode(PDO::FETCH_OBJ);
            $rows = $STH->fetchAll();

            echo json_encode($rows);

        }catch(PDOException $e)
        {
            //trigger_error("{" . $e->getMessage(). "}", E_USER_NOTICE);
            echo json_encode(array("Error" => $e->getMessage()));  
        }
    }

}