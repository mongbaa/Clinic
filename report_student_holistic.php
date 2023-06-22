<?PHP
                  // สร้าง array 2 มิติ
                  $holistic_array = array();
                  include "config.inc.php";
                  $sql_form_holistic   =  " SELECT * FROM tbl_form_holistic ";
                  $query_form_holistic = $conn->query($sql_form_holistic);
                  while ($result_form_holistic = $query_form_holistic->fetch_assoc()) {

                    $holistic_array[] = array(
                      'name' => $result_form_holistic['form_holistic_name'],
                      'field' => $result_form_holistic['form_holistic_field'],
                      'detail' => $result_form_holistic['form_holistic_detail']
                    );
                  }

                  // var_dump($holistic_array);

                  ?>
                  Holistic

                  <?php


                  ?>
                  <table id="example333" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="8%">วันที่</th>
                        <th width="8%">เวลา</th>
                        <th Width="12%">ผู้ประเมิน</th>

                        <?php
                        foreach ($holistic_array as $values => $data) {
                        ?>
                          <th>
                            <div align="center"><?php echo $data['name']; ?></div>
                          </th>
                        <?php } ?>
                      </tr>
                    </thead>

                    <?PHP
                    include "config.inc.php";
                    //  $sql_holistic   =  " SELECT * FROM tbl_holistic  ";
                    $sql_holistic = " SELECT h.*, th.* ";
                    $sql_holistic  .=  " FROM (SELECT * FROM tbl_holistic WHERE student_id = '$student_id') as h ";
                    $sql_holistic  .=  " INNER JOIN (SELECT * FROM tbl_teacher WHERE type_work_id = $type_work_id) as th  ON  h.teacher_id = th.teacher_id";

                    $query_holistic = $conn->query($sql_holistic);
                    while ($result_holistic = $query_holistic->fetch_assoc()) {
                    ?>
                      <tbody>
                        <tr>
                          <td><?php echo set_format_date($result_holistic['holistic_date']); ?></td>
                          <td><?php echo $result_holistic['holistic_time']; ?>
                            (<?php echo $result_holistic['holistic_time_type']; ?>)</td>
                          <td><?php echo nameTeacher::get_teacher_name($result_holistic['teacher_id']); ?>
                          </td>
                          <?php
                          foreach ($holistic_array as $values => $data) {
                            $field_holistic =  $data['field'];
                          ?>
                            <td>
                              <div align="center">
                                <?php echo $result_holistic["{$field_holistic}"]; ?></div>
                            </td>
                          <?php } ?>
                        </tr>
                      <tbody>
                      <?php } ?>
                  </table>