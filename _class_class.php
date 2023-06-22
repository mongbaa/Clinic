<?php 
   include "config.inc.php";

    class nameClass {
        private static $conn;
        private static $memo = [];

        public function __construct($conn) {
            static::$conn = $conn;
        }
    
        public static function get_class_name($classID)
        {  


            if (is_null(static::$conn)) {
                static::$conn = $GLOBALS['conn'];
            }

            // guard
            if (empty($classID)) { return ""; }


            // check memo
            if (array_key_exists($classID, static::$memo)) {
                return static::$memo[$classID];
            }
       

            // query
            $sql   =  " SELECT * FROM tbl_class where class_id  ='{$classID}' ";
            $query = static::$conn->query($sql);
            $result = $query->fetch_assoc();

            $class_name = $result["class_name"];
            // memo
            static::$memo[$classID] = $class_name;

            // return
            return $class_name;

        }
    }


  
?>
