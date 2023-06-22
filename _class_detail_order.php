<?php 
   include "config.inc.php";
   
    class nameDetail_order {
        private static $conn;
        private static $memo = [];

        public function __construct($conn) {
            static::$conn = $conn;
        }
    
        public static function get_detail_order_name($detailID)
        {  

            if (is_null(static::$conn)) {
                static::$conn = $GLOBALS['conn'];
            }

            // guard
            if (empty($detailID)) { return ""; }

            // check memo
            if (array_key_exists($detailID, static::$memo)) {
                return static::$memo[$detailID];
            }
       
            // query
            

            $sql   =  " SELECT  d.*, o.*   FROM ";
            $sql  .=  " (SELECT * FROM tbl_detail WHERE  detail_id = '{$detailID}') as d ";
            $sql  .=  " INNER JOIN  tbl_order as o  ON  o.order_id = d.order_id";
            $query = static::$conn->query($sql);
            $result = $query->fetch_assoc();

             $student_id = $result["student_id"];

            // memo
            static::$memo[$detailID] = $student_id;

            // return
            return $student_id;

        }
    }


  
?>
