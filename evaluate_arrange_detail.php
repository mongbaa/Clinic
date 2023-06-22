<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myedit_arrange_detail">
 <?php echo $arrange_detail; ?> 
</button>
 

 
<?php 
include "config.inc.php";
$sql_a   = " SELECT a.* FROM  ";
$sql_a  .= " ( SELECT * FROM tbl_arrange where arrange_id = $arrange_id ) as a ";
$query_a = $conn->query($sql_a);
$result_a = $query_a->fetch_assoc();

?>

<form name="<?php echo $result['detail_id']; ?>" method="POST" action="arrange_edit_q.php">

<input name="arrange_id" type="hidden" value="<?php echo $result_a['arrange_id']; ?>" />

<div class="modal fade" id="myedit_arrange_detail">
  <div class="modal-dialog">
    <div class="modal-content  ">
      <div class="modal-header bg-danger">
        <h4 class="modal-title"> แก้ไขข้อมูล รายละเอียด </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <input name="arrange_detail" type="text" value="<?php echo $result_a['arrange_detail']; ?>"  class="form-control" required>
      <input name="arrange_detail_old" type="hidden" value="<?php echo $result_a['arrange_detail']; ?>"  class="form-control" required>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="submit" class="btn btn-outline-danger"> แก้ไขข้อมูล </button>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-outline-danger"> OK </button>-->
      </div>
    </div>
    <!-- /.modal-content -->

  </div>
  <!-- /.modal-dialog -->

</div>
<!-- /.modal -->



</form>




