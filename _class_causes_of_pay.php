<?php 
   include "config.inc.php";

    class nameCauses_of_pay {
        private static $conn;
        private static $memo = [];

        public function __construct($conn) {
            static::$conn = $conn;
        }
    
        public static function get_causes_of_pay_name($causes_of_payID)
        {  

            if (is_null(static::$conn)) {
                static::$conn = $GLOBALS['conn'];
            }

            // guard
            if (empty($causes_of_payID)) { return ""; }

            // check memo
            if (array_key_exists($causes_of_payID, static::$memo)) {
                return static::$memo[$causes_of_payID];
            }
        
            // query
            $sql   =  " SELECT * FROM tbl_causes_of_pay where causes_of_pay_id IN ('{$causes_of_payID}') ";
            $query = static::$conn->query($sql);
            $result = $query->fetch_assoc();

            $causes_of_pay_name = $result["causes_of_pay_detail"];
            // memo
            static::$memo[$causes_of_payID] = $causes_of_pay_name;

            // return
            return $causes_of_pay_name;

        }
    }


  
?>
