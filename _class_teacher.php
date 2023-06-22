<?php 
   include "config.inc.php";

    class nameTeacher {
        private static $conn;
        private static $memo = [];

        public function __construct($conn) {
            static::$conn = $conn;
        }
    
        public static function get_teacher_name($teacherID)
        {  


            if (is_null(static::$conn)) {
                static::$conn = $GLOBALS['conn'];
            }

            // guard
            if (empty($teacherID)) { return ""; }

            // check memo
            if (array_key_exists($teacherID, static::$memo)) {
                return static::$memo[$teacherID];
            }
       

            // query
            $sql   =  " SELECT * FROM tbl_teacher where teacher_id IN ('{$teacherID}') ";
            $query = static::$conn->query($sql);
            $result = $query->fetch_assoc();

            $teacher_name = "อ.".$result["teacher_name"] . " " . $result["teacher_surname"];
            // memo
            static::$memo[$teacherID] = $teacher_name;

            // return
            return $teacher_name;

        }
    }


  
?>
