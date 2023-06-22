<?php 
   include "config.inc.php";

    class nameStudent {
        private static $conn;
        private static $memo = [];

        public function __construct($conn) {
            static::$conn = $conn;
        }
    
        public static function get_student_name($studentID)
        {  


            if (is_null(static::$conn)) {
                static::$conn = $GLOBALS['conn'];
            }

            // guard
            if (empty($studentID)) { return ""; }

            // check memo
            if (array_key_exists($studentID, static::$memo)) {
                return static::$memo[$studentID];
            }
       

            // query
            $sql   =  " SELECT * FROM tbl_student where student_id IN ('{$studentID}') ";
            $query = static::$conn->query($sql);
            $result = $query->fetch_assoc();

            $student_name = "".$result["student_name"] . " " . $result["student_lastname"];
            // memo
            static::$memo[$studentID] = $student_name;

            // return
            return $student_name;

        }
    }


  
?>
