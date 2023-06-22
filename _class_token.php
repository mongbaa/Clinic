<?php 
   include "config.inc_estudent.php";

    class nameToken {
        private static $conn_estudent;
        private static $memo = [];

        public function __construct($conn_estudent) {
            static::$conn_estudent = $conn_estudent;
        }
    
        public static function get_token_line($tokenID)
        {  

            if (is_null(static::$conn_estudent)) {
                static::$conn_estudent = $GLOBALS['conn_estudent'];
            }

            // guard
            if (empty($tokenID)) { return ""; }

            // check memo
            if (array_key_exists($tokenID, static::$memo)) {
                return static::$memo[$tokenID];
            }
       
            // query
            $sql   =  " SELECT * FROM estudent.tbl_student where STUDENT_ID IN ('{$tokenID}') ";
            $query = static::$conn_estudent->query($sql);
            $result = $query->fetch_assoc();

            $token_line = $result['TOKEN_LINE'];

            
            // memo
            static::$memo[$tokenID] = $token_line;

            // return
            return $token_line;

        }
    }


  
?>
