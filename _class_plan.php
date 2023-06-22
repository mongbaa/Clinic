<?php 
   include "config.inc.php";

    class namePlan {
        private static $conn;
        private static $memo = [];

        public function __construct($conn) {
            static::$conn = $conn;
        }
    
        public static function get_plan_name($planID)
        {  


            if (is_null(static::$conn)) {
                static::$conn = $GLOBALS['conn'];
            }

            // guard
            if (empty($planID)) { return ""; }

            // check memo
            if (array_key_exists($planID, static::$memo)) {
                return static::$memo[$planID];
            }
       

            // query
            $sql   =  " SELECT * FROM tbl_plan where plan_id IN ('{$planID}') ";
            $query = static::$conn->query($sql);
            $result = $query->fetch_assoc();

            $plan_name = $result["plan_name"];
            // memo
            static::$memo[$planID] = $plan_name;

            // return
            return $plan_name;

        }
    }


  
?>
