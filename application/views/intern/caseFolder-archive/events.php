<link href='<?= base_url() ?>assets/css/fullcalendar.css' rel='stylesheet' />
<link href='<?= base_url() ?>assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='<?= base_url() ?>assets/js/jquery.min.js'></script>
<script src='<?= base_url() ?>assets/js/jquery-ui.custom.min.js'></script>
<script src='<?= base_url() ?>assets/js/fullcalendar.min.js'></script>

<script>

    $(document).ready(function() {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        var calendar = $('#calendar').fullCalendar({
            editable: false,
            disableDragging: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            //Shows appoinments
            events: "<?php echo base_url() ?>calendar/userschedules/" + <?php echo $this->session->userdata('userid') ?>,
            selectable: false,
            selectHelper: true,
            //Shows Add Appointment modal
            select: function(start, end, allDay) {
                var dateChosen = $.fullCalendar.formatDate(start, "yyyy-MM-dd");
                var timeStart = $.fullCalendar.formatDate(start, "hh:mm TT");
                var timeEnd = $.fullCalendar.formatDate(end, "hh:mm TT");
                document.getElementById("newappt_date").value = dateChosen;
                document.getElementById('newappt_starttime').value = timeStart;
                document.getElementById('newappt_endtime').value = timeEnd;
                $('#addAppointmentModal').modal('show');
                calendar.fullCalendar('unselect');

                //Add Appointment function
                $('#btnaddappointment').click(function() {
                    var caseid = $('select[name="newappt_case"]').val();
                    var title = $('#newappt_title').val();
                    var dateSelected = $('#newappt_date').val();
                    var startSelected = $('#newappt_starttime').val();
                    var endSelected = $('#newappt_endtime').val();
                    var type = $('input[name="newappt_type"]:checked').val();
                    var place = $('#newappt_place').val();

                    var fullCalendarStart_FC = $.fullCalendar.parseDate(dateSelected + ' ' + startSelected);
                    var fullCalendarEnd_FC = $.fullCalendar.parseDate(dateSelected + ' ' + endSelected);

                    var fullCalendarStart = $.fullCalendar.formatDate(fullCalendarStart_FC, "yyyy-MM-dd HH:mm");
                    var fullCalendarEnd = $.fullCalendar.formatDate(fullCalendarEnd_FC, "yyyy-MM-dd HH:mm");

                });
                //
            },
            editable: true,
                    eventClick: function(calEvent, jsEvent, view) {
                        $('#viewAppointmentModal').modal('show');
                            $('#editapptdiv').addClass('hide');
                            $('#deleteapptdiv').addClass('hide');
                            $('#cantattendapptdiv').addClass('hide');
                            $('#doneapptdiv').addClass('hide');

                            $('#actionEventsDiv').removeClass('hide');
                            $('#actionEventTopDiv').removeClass('hide');
                            $('#viewapptdiv').removeClass('hide');
                            

                        //For view div
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() ?>calendar/view/" + calEvent.id,
                            success: function(result) {
                                $('#viewapptdiv').html(result);
                            }
                        });

                        //For done div
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() ?>calendar/view_done/" + calEvent.id + '/calendar',
                            success: function(result) {
                                $('#doneapptdiv').html(result);
                            }
                        });

                        //For edit div
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() ?>calendar/view_edit/" + calEvent.id,
                            success: function(result) {
                                $('#editapptdiv').html(result);
                            }
                        });

                        //For cant attend div
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() ?>calendar/view_cantattend/" + calEvent.id + '/calendar',
                            success: function(result) {
                                $('#cantattendapptdiv').html(result);
                            }
                        });

                        //For delete attend div
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() ?>calendar/view_delete/" + calEvent.id,
                            success: function(result) {
                                $('#deleteapptdiv').html(result);
                            }
                        });

                        //For footer div
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() ?>calendar/view_modalfooter/" + calEvent.id,
                            success: function(result) {
                                $('#modalfooterdiv').html(result);
                            }
                        });
                    }
        });
    });
</script>

<style>
    #calendar {
        width: 580px;
        margin: 0 auto;
    }
</style>

<div id="container">
  <div id="content-calendar">

    <!-- start: CALENDAR DIV -->
    <div class="row">
      <div class="col-lg-7" style='margin: 0 auto;'>
        <div class="box">
          <div class="box-header">
            <h2><i class="icon-calendar"></i>Calendar</h2>
          </div>              
          <div class="box-content">
            <br/>
            <div id='calendar' style="margin:1px;"></div>
          </div>
        </div>
       </div>

        <div class="col-lg-5">
        <div class="box">
          <div class="box-header">
            <h2><i class="icon-check"></i>Things To-Do</h2>
          </div>
          <div class="box-content">
            <table class="table table-striped table-bordered datatable">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Case Number</th>
                                <th></th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php foreach ($thingstodo as $row): ?>
                                <tr>
                                    <td class="center"><a href="#taskDetailsModal" data-toggle="modal" class="btn btn-link" style='font-size:11px; width:100px;'><?php echo $row->task ?></a>
                                    </td>
                                    <td class="center"><?php echo $this->Case_model->select_case($row->caseID)->caseNum ?></td>
                                    <td class="center">
                                        <?php if ($row->summary == NULL) { ?>
                                            <a class="btn btn-success" title="Done" href="#doneTaskModal" data-toggle="modal" onclick="doneclick(<?php echo $row->taskID ?>)">
                                                <i class="icon-ok"></i>  
                                            </a>
                                        <?php } else { ?>
                                            <label class='label label-default'>Completed</label>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table> 
          </div>
        </div>
        </div>


    </div>
    <!-- end: CALENDAR DIV -->

    <!-- START OF MODAL : ADD Appointment -->
    <?php echo form_open(base_url() . 'calendar/add/cases'); ?>
    <div class="row">
      <div class="modal fade" id="addAppointmentModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Add New Appointment</h4>
            </div>

            <div class="modal-body" style='height:465px ! important; overflow-y: scroll;'>
              <div class="col-sm-3 control-group">
                <div class="controls">
                    <center> <h5> <b> Case Title </b></h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group">
                <div class="controls">
                  <h5><?php echo "$case->caseName ($case->caseNum)" ?></h5>
                  <input type="hidden" name="newappt_case" value="<?= $case->caseID ?>"/>
                </div>
              </div>
                
                <br><br>
                
                <div class="col-sm-3 control-group">
                <div class="controls">
                    <center> <h5> <b> Client Name </b></h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group">
                <div class="controls">
                  <h5> (Client) </h5>
                  <input type="hidden" name="newappt_case" value="<?= $case->caseID ?>"/>
                </div>
              </div>

              <br><br><br>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <center> <h5> <b> Appointment </b></h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group">
                <div class="controls">
                  <?php echo form_input(array('class' => 'form-control', 'name' => 'newappt_title', 'id' => 'newappt_title')); ?>
                </div>
              </div>

              <br><br>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <center> <h5><b> Date</b> </h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group">
                <div class="controls">
                  <div class="input-group date">
                    <span class="input-group-addon"><i class="icon-calendar"></i></span>
                    <input type="text" class="form-control date-picker" id="newappt_date" name="newappt_date" data-date-format="yyyy-mm-dd" value="<?php echo $datenow; ?>">
                  </div>
                </div>
              </div>

              <br><br>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <center> <h5> <b>Time</b> </h5> </center>
                </div>
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <div class="input-group bootstrap-timepicker">
                    <span class="input-group-addon"><i class="icon-time"></i></span>
                    <input type="text" class="form-control timepicker" id="newappt_starttime" name="newappt_starttime" value="<?php echo $timenow; ?>">
                  </div>
                </div>
              </div>

              <div class="col-sm-1 control-group">
                <div class="controls">
                  <center> <h5> to </h5> </center>
                </div>
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <div class="input-group bootstrap-timepicker">
                    <span class="input-group-addon"><i class="icon-time"></i></span>
                    <input type="text" class="form-control timepicker" id="newappt_endtime" name="newappt_endtime" value="<?php echo $timenow; ?>">
                  </div>
                </div>
              </div>

              <br><br>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <center> <h5> <b>Location</b> </h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group form-inline">
                <div class="controls">
                  <div style='margin-bottom: -10px;'>
                    <label class="radio" for="appointmentLocation-0">
                      <input type="radio" name="newappt_type" id="appointmentLocation-0" value="Internal" checked="checked">
                      In the Clinic
                    </label> &nbsp;
                    <label class="radio">
                      <input type="radio" name="newappt_type" id="appointmentLocation-1" value="External">
                      Outside the Clinic
                    </label>
                  </div>
                  <br>
                  <?php echo form_input(array('class' => 'form-control', 'id' => 'newappt_place', 'name' => 'newappt_place', 'placeholder' => 'Exact Location')); ?>
                </div>
              </div>

              <br><br><br>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <center> <h5> <b>Attendees</b> </h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group">
                <div class="controls">
                  <div id='internsdiv' class="tbl-attendees">
                    <table class='table table-striped'>
                      <?php foreach ($caseinterns as $row) { ?>
                        <tr>
                          <td align='center'>
                            <input name='apptattendees[]' type='checkbox' class='case' name='case' value="<?php echo $row->personID ?>";
                            <?php if ($this->session->userdata('userid') == $row->personID) echo 'checked'; ?>
                                   />
                          </td>
                          <td><?php echo "$row->firstname $row->lastname" ?></td>
                        </tr>
                      <?php } ?>
                      <?php foreach ($caselawyers as $row) { ?>
                        <tr>
                          <td align='center'>
                            <input name='apptattendees[]' type='checkbox' class='case' name='case' value="<?php echo $row->personID ?>";
                            <?php if ($this->session->userdata('userid') == $row->personID) echo 'checked'; ?>
                                   />
                          </td>
                          <td><?php echo "$row->firstname $row->lastname" ?></td>
                        </tr>
                      <?php } ?>
                    </table>
                  </div>
                </div>
              </div>

              <br><br><br><br><br><br><br><br>

              <div class="col-sm-3 control-group">
                <div class="controls">
                    <center> <h5> <b>Action plan </b></h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group">
                <div class="controls">
                  <select id="actionplanforevent" name="actionplanforevent" class="form-control">
                    <?php foreach ($actionplanforevent as $action) : ?>
                      <option value="<?= $action->actionplanID ?>"> <?= $action->action ?> </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <br>
            </div>

            <div class="modal-footer">
                <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-success'), 'Add Appointment'); ?>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    </div>
    <?php echo form_close(); ?>
    <!-- END OF MODAL : ADD Appointment -->

    <!-- START OF MODAL : VIEW Appointment -->
    <div class="row">
      <div class="modal fade" id="viewAppointmentModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close btnapptclose" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Appointment
                <label id="actionEventTopDiv">
                  <a id="btneditapptshow"><i class="icon-pencil"></i></a>
                  <a id="btndeleteapptshow"><i class="icon-trash"></i></a>
                </label>
              </h4>
            </div>

            <div class="modal-body">
              <!-- VIEW START -->
              <div id='viewapptdiv'>
                <!-- controller calendar/view($sid) -->
              </div>
              <!-- VIEW END -->

              <!-- EDIT START -->
              <div id='editapptdiv' class='hide'>
                <!-- controller calendar/view_edit($sid) -->
              </div>
              <!-- EDIT END -->

              <!-- DONE START -->
              <div id='doneapptdiv' class='hide'>
                <!-- controller calendar/view_done($sid) -->
              </div>
              <!-- DONE END -->

              <!-- CANT ATTEND START -->
              <div id='cantattendapptdiv' class='hide'>
                <!-- controller calendar/view_cantattend($sid) -->
              </div>
              <!-- CANT ATTEND END -->

              <!-- DELETE START -->
              <div id='deleteapptdiv' class='hide'>
                <!-- controller calendar/view_delete($sid) -->
              </div>
              <!-- DELETE END -->
            </div>

            <div id="modalfooterdiv" class="modal-footer">
              <!-- controller calendar/view_modalfooter($sid) -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END OF MODAL : VIEW Appointment -->

    <!-- START OF MODAL : ADD Task -->
    <div class="row">

      <div class="modal fade" id="addTaskModal">
        <div class="modal-dialog">
          <?php echo form_open(base_url() . 'cases/addMyTask/' . $case->caseID); ?>
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Add New Task</h4>
            </div>
            <div class="modal-body">
                
              <div class="col-sm-4 control-group">
                <div class="controls">
                    <center> <h5> <b> Case Title </b></h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group">
                <div class="controls">
                  <h5><?php echo "$case->caseName ($case->caseNum)" ?></h5>
                  <input type="hidden" name="newappt_case" value="<?= $case->caseID ?>"/>
                </div>
              </div>
                
                <br><br><br>

              <div class="col-sm-4 control-group">
                <div class="controls">
                    <center> <h5> <b> Task </b></h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group">
                <div class="controls">
                  <?php echo form_input(array('class' => 'form-control', 'name' => 'task', 'type' => 'text')); ?>
                </div>
              </div>

              <br><br>

              <div class="col-sm-4 control-group">
                <div class="controls">
                    <center> <h5><b> Notes </b></h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group">
                <div class="controls">
                  <?php echo form_textarea(array('style' => 'height: 80px', 'name' => 'notes', 'type' => 'text', 'class' => 'form-control')); ?>
                </div>
              </div>

              <br><br><br><br><br>

              <div class="col-sm-4 control-group">
                <div class="controls">
                  <center> <h5><b> Due Date </b></h5> </center>
                </div>
              </div>

              <div class="col-sm-7 control-group">
                <div class="controls">
                  <div class="input-group date">
                    <span class="input-group-addon"><i class="icon-calendar"></i></span>
                    <input type="text" class="form-control date-picker" id="taskduedate" name="taskduedate" data-date-format="yyyy-mm-dd" value="<?php echo $datenow; ?>">
                  </div>
                </div>
              </div>

              <br><br>
              

            </div>
            <div class="modal-footer">
                 <input type="submit" class="btn btn-success">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <input type="hidden" name="assignedBy" value="<?php echo $this->session->userdata('userid') ?>">
              <input type="hidden" name="cid" value="<?php echo $case->caseID ?>">
             
            </div>
          </div><!-- /.modal-content -->
          <?php echo form_close(); ?>
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

    </div>
    <!-- END OF MODAL : ADD Task -->

    <!-- START OF MODAL : DONE Task -->
    <div class="row">

      <div class="modal fade" id="doneTaskModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Task</h4>
            </div>
            <div class="modal-body">
              <p>To confirm this action, please briefly discuss what you did for the task:</p>
              <div class="controls">
                <textarea id="limit" rows="6" style="width:100%"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success">Confirm</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

    </div>
    <!-- END OF MODAL : DONE Task -->

  </div>
</div>
