<?php 
   include "config.inc.php";
   
    class nameDetail {
        private static $conn;
        private static $memo = [];

        public function __construct($conn) {
            static::$conn = $conn;
        }
    
        public static function get_detail_name($detailID)
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
            

            $sql   =  " SELECT  d.*, p.*, t.*   FROM ";
            $sql  .=  " (SELECT * FROM tbl_detail WHERE  detail_id = '{$detailID}') as d ";
            $sql  .=  " INNER JOIN  tbl_plan as p  ON  p.plan_id = d.plan_id";
            $sql  .=  " INNER JOIN  tbl_type_work as t  ON  t.type_work_id = p.type_work_id";
            $query = static::$conn->query($sql);
            $result = $query->fetch_assoc();



              if (!empty($result['detail_surface'])) { 
                $detail_surface = " surface: ".$result['detail_surface'];
              }else{
                $detail_surface = "";
              }

              if (!empty($result['detail_root'])) { 
                $detail_root = " Root: ".$result['detail_root'];
              }else{
                $detail_root = "";
              }

              

              if (!empty($result['class_id'])) { 
                $class_id = " Class: ".nameClass::get_class_name($result['class_id']);
              }else{
                $class_id = "";
              }


              

               if (!empty($result['detail_tooth'])) {        
                $array_detail_tooth = (array)json_decode($result['detail_tooth']);
                $toothh ="";
                  foreach ($array_detail_tooth as $id => $value) {
                  $toothh .= $value.", ";
                  } 
               
                  $tooth = " Tooth : ".substr($toothh, 0 ,-2);

                }else{

                  $tooth = "";
                }
           
          


            $detail_name = "<B>".$result["type_work_name"]."</B> ".$result["plan_name"]." ".$detail_surface." ".$detail_root." ".$class_id.$tooth;







            // memo
            static::$memo[$detailID] = $detail_name;

            // return
            return $detail_name;

        }
    }


  
?>
