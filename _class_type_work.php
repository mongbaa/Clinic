<?php 
   include "config.inc.php";

    class nameType_work {
        private static $conn;
        private static $memo = [];

        public function __construct($conn) {
            static::$conn = $conn;
        }
    
        public static function get_type_work_name($type_workID)
        {  


            if (is_null(static::$conn)) {
                static::$conn = $GLOBALS['conn'];
            }

            // guard
            if (empty($type_workID)) { return ""; }

            // check memo
            if (array_key_exists($type_workID, static::$memo)) {
                return static::$memo[$type_workID];
            }
       

            // query
            $sql   =  " SELECT * FROM tbl_type_work where type_work_id IN ('{$type_workID}') ";
            $query = static::$conn->query($sql);
            $result = $query->fetch_assoc();

            $type_work_name = $result["type_work_name"];
            // memo
            static::$memo[$type_workID] = $type_work_name;

            // return
            return $type_work_name;

        }
    }


  
?>
