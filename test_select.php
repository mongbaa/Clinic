
<script src="plugins/jquery/jquery.min.js"></script>


<select multiple id="e1" style="width:300px">
        <option value="AL">Alabama</option>     //AJAX created
        <option value="Am">Amalapuram</option>  //AJAX created
        <option value="An">Anakapalli</option>  //AJAX created
        <option value="Ak">Akkayapalem</option> //AJAX created
        <option value="WY">Wyoming</option>     //AJAX created
    </select>
    <input type="checkbox" id="checkbox" >Select All


    <script>                                   
$(document).ready(function() {
    $("#checkbox").click(function(){
      if($("#checkbox").is(':checked') ){ //select all
        $("#e1").find('option').prop("selected",true);
        $("#e1").trigger('change');
      } else { //deselect all
        $("#e1").find('option').prop("selected",false);
        $("#e1").trigger('change');
      }
  });
});
</script>