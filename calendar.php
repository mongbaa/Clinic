<?php include "header.php"; ?>

<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

<!-- fullCalendar -->
<link rel="stylesheet" href="plugins/fullcalendar/main.min.css">
<link rel="stylesheet" href="plugins/fullcalendar-daygrid/main.min.css">
<link rel="stylesheet" href="plugins/fullcalendar-timegrid/main.min.css">
<link rel="stylesheet" href="plugins/fullcalendar-bootstrap/main.min.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="plugins/toastr/toastr.min.css">


<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">


<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">



<section class="content">
  <div class="container-fluid">
    <br>
    <div class="row">



      <div class="col-md-2">
        <form name="form_s" method="GET" action="<?php echo $_SERVER['PHP_SELF'] ?>">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">teacher</h3>
            </div>
            <div class="card-body">


              <?php
              if (isset($_GET['teacher_id'])) {
                $teacher_id = $_GET['teacher_id'];
                $teacher_id_implode = implode(', ', $teacher_id);
                $teacher_id_arrary = explode(",", $teacher_id_implode);
              } else {
                $teacher_id = 1;
                $teacher_id_implode = "";
                $teacher_id_arrary = array("1s");
              }
              ?>


              <div class="col-sm-12">
                <label> <input type="checkbox" id="checkbox_teacher_id3"> Select All teacher </label>
                <script src="plugins/jquery/jquery.min.js"></script>
                <script>
                  $(document).ready(function() {
                    $("#checkbox_teacher_id3").click(function() {
                      if ($("#checkbox_teacher_id3").is(
                          ':checked')) { //select all
                        $("#eteacher").find('option').prop("selected", true);
                        $("#eteacher").trigger('change');
                      } else { //deselect all
                        $("#eteacher").find('option').prop("selected", false);
                        $("#eteacher").trigger('change');
                      }
                    });
                  });
                </script>
                <div class="form-group">
                  <div class="select2-purple">
                    <select name="teacher_id[]" id="eteacher" class="select2" multiple="multiple" data-placeholder=" teacher  " data-dropdown-css-class="select2-purple" style="width: 100%;">

                      <?PHP
                      include "config.inc.php";
                      $sql_teacher = " SELECT * FROM tbl_teacher where teacher_status = 1 ORDER BY teacher_id ASC    ";
                      $query_teacher = $conn->query($sql_teacher);
                      while ($result_teacher = $query_teacher->fetch_assoc()) {
                      ?>
                        <option value="<?php echo $result_teacher['teacher_id']; ?>" <?php if (in_array($result_teacher['teacher_id'], $teacher_id_arrary)) {
                                                                                  echo "selected=\"selected\"";
                                                                                } ?>>
                         <?php echo nameType_work::get_type_work_name($result_teacher['type_work_id']); ?>  อ.<?php echo $result_teacher['teacher_name'];?>  <?php echo $result_teacher['teacher_surname'];?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-block bg-gradient-primary"> <i class="fas fa-search"></i> เลือก</button>

            </div>
          </div>
        </form>
      </div>
      <!-- /.col -->









      <div class="col-md-10">
        <div class="card card-primary">
          <div class="card-body p-0">
            <div id="external-events"></div>
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->




    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<?php include "footer.php"; ?>

<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>

<!-- fullCalendar 2.2.5 -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/fullcalendar/main.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function() {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function() {

        // create an Event Object (https://fullcalendar.io/docs/event-object)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0 //  original position after the drag
        })

      })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      themeSystem: 'bootstrap',
      //Random default events
      events: [
        /*    
        <?php

        if (!empty($teacher_id_implode)) {
          $sql_teacher_id = " where teacher_id in ($teacher_id_implode)";
        } else {
          $sql_teacher_id = " where teacher_id in (9999)";
        }



            include "config.inc.php";
            $sql_arrange = " SELECT a.* , d.* ,  o.* ";
            $sql_arrange .= " FROM (SELECT * FROM tbl_arrange $sql_teacher_id) AS a ";
            $sql_arrange .= " INNER JOIN tbl_detail as d ON d.detail_id = a.detail_id ";
            $sql_arrange .= " INNER JOIN tbl_order as o ON o.order_id = d.order_id";
            
            $query_arrange = $conn->query($sql_arrange);
            while ($row_arrange = $query_arrange->fetch_assoc()){


            $arrange_date = $row_arrange['arrange_date'];
            $strDate = explode("-", $arrange_date);
            $y = $strDate[0];
            $m = $strDate[1];
            $d = $strDate[2];
            $mm = $m - 1;
  
              if( $row_arrange['arrange_check_eval'] == 0){ 
  
                  $color = "#ff0000"; //แดง
                  
              }else{
  
                  $color = "#0f8500"; //เขียว
  
              }

        ?>*/ 
        

        {
          title: '<?php echo $row_arrange['student_id']; ?> <?php echo nameStudent::get_student_name($row_arrange['student_id']); ?> (<?php echo $row_arrange['detail_id']; ?>)',
          start: new Date(<?php echo $y; ?>, <?php echo $mm; ?>, <?php echo $d; ?>),
          backgroundColor: '<?php echo $color;?>',
          borderColor: '#ffffff', 
          url: 'evaluate.php?detail_id=<?php echo $row_arrange['detail_id']; ?>&plan_id=<?php echo $row_arrange['plan_id']; ?>&arrange_date=<?php echo $row_arrange['arrange_date']; ?>&arrange_id=<?php echo $row_arrange['arrange_id']; ?>',
          allDay: true
        },


        /*<?php } ?>*/



   


        

        {
          title: 'Click for Google',
          start: new Date(2020, m, 28),
          end: new Date(2020, m, 29),
          url: 'https://www.google.com/',
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor: '#3c8dbc' //Primary (light-blue)
        }
      ],
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar !!!
      drop: function(info) {
        // is the "remove after drop" checkbox checked?
        if (checkbox.checked) {
          // if so, remove the element from the "Draggable Events" list
          info.draggedEl.parentNode.removeChild(info.draggedEl);
        }
      }
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    // Color chooser button
    $('#color-chooser > li > a').click(function(e) {
      e.preventDefault()
      // Save color
      currColor = $(this).css('color')
      // Add color effect to button
      $('#add-new-event').css({
        'background-color': currColor,
        'border-color': currColor
      })
    })
    $('#add-new-event').click(function(e) {
      e.preventDefault()
      // Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      // Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color': currColor,
        'color': '#fff'
      }).addClass('external-event')
      event.text(val)
      $('#external-events').prepend(event)

      // Add draggable funtionality
      ini_events(event)

      // Remove event from text input
      $('#new-event').val('')
    })
  })
</script>

<script>
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
      'placeholder': 'dd/mm/yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
      'placeholder': 'mm/dd/yyyy'
    })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
      format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
            .endOf('month')
          ]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function() {
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>



<script>
  $(document).ready(function() {
    $("#myModal").modal('show');
  });
</script>
</body>

</html>