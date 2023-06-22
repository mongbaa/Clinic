<?php 
if(!empty($_SESSION['loginname'])){

//if($_SESSION['loginname'] == "mongkol.th") {


    $form_code = "2301uHnKI";
    $assessor = $_SESSION['loginname'];

    include "config.inc_dent_form.php";
    
      $tbl        = "tbl_".$form_code;
      $sql_dent_form  = " SELECT * ";
      $sql_dent_form .= " FROM  {$tbl} ";
      $sql_dent_form .= " WHERE assessor = '$assessor' ";
      $query_dent_form = $conn_dent_form->query($sql_dent_form);
      if($result_dent_form = $query_dent_form->fetch_assoc()){



      }else{

      
            $REMOTE_ADDR = $_SERVER['REMOTE_ADDR']; 
            $REMOTE_ADDR_substr = substr($REMOTE_ADDR, 0,6);

            if( $REMOTE_ADDR_substr == "10.151"){ 
                $url = "http://10.151.127.78/dent_form/form_view_eclinic.php?form_code={$form_code}&assessor={$assessor}";
              }else{ 
                $url = "http://10.0.1.98/dent_form/form_view_eclinic.php?form_code={$form_code}&assessor={$assessor}";
              } 

      ?>

        <style>
            iframe:focus {
            outline: none;
            }

            iframe[seamless] {
            display: block;
            }
        </style>



              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                      <!-- Modal content-->
                      <div class="modal-content">
                          <div class="modal-header">
                          <h4 class="modal-title"> ขอความร่วมมือประเมินความพึงพอใจการใช้งานระบบ E-clinic </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <iframe src="<?php echo $url;?>" title="ระบบประเมินความพึงพอใจ" width="100%" height="500" style="border:none;"></iframe>
                        </div>
                        <div class="modal-footer justify-content-between">
                            
                            <button type="button" class="btn btn-outline-danger btn-lg btn-block" data-dismiss="modal">ปิดการประเมินความพึงพอใจ</button>
                            <!-- <button type="button" class="btn btn-outline-danger"> OK </button>-->
                          </div>
                      </div>
                  </div>
              </div>

    


              <!-- jQuery -->
          <script src="plugins/jquery/jquery.min.js"></script>
          <script>
          $(document).ready(function(){
            // Show the Modal on load
            $("#myModal").modal("show");
              
            // Hide the Modal
            $("#myBtn").click(function(){
              $("#myModal").modal("hide");
            });
          });
          </script>


  <?php   
  } 
  //}
  }
  ?>