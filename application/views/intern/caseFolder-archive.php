<div id="content" class="col-lg-10 col-sm-11">
    <!-- CASE FOLDER -->

    <!-- https://github.com/sathomas/responsive-tabs -->
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h2>
                    <?php echo "$case->caseName ($case->caseNum)"; ?>
                    <div style='display: inline-block; margin-left:10px;' class="hide">
                        <?php if ($case->difficultyLevel >= 7 && $case->difficultyLevel <= 10) { ?>
                            <label class='label label-danger'> Difficulty Level: <?php echo $case->difficultyLevel ?></label>
                        <?php } ?>
                        <?php if ($case->difficultyLevel >= 4 && $case->difficultyLevel <= 6) { ?>
                            <label class='label label-warning'> Difficulty Level: <?php echo $case->difficultyLevel ?></label>
                        <?php } ?>
                        <?php if ($case->difficultyLevel >= 1 && $case->difficultyLevel <= 3) { ?>
                            <label class='label label-primary'>Difficulty Level: <?php echo $case->difficultyLevel ?></label>
                        <?php } ?>
                    </div>
                </h2>

                <!-- start: Tabs -->
                <ul class="nav casetabs tab-menu nav-tabs">
                    <li <?php if (isset($_GET['tid']) && $_GET['tid'] == 'research') echo 'class="active"'; ?> >
                        <a href="#research" data-toggle="tab">Research</a>
                    </li>
                    <li <?php if (isset($_GET['tid']) && $_GET['tid'] == 'minutes') echo 'class="active"'; ?> >
                        <a href="#minutes" data-toggle="tab">Minutes</a>
                    </li>
                    <li <?php if (isset($_GET['tid']) && $_GET['tid'] == 'events') echo 'class="active"'; ?> >
                        <a href="#events" data-toggle="tab">Events</a>
                    </li>
                    <li <?php if (isset($_GET['tid']) && $_GET['tid'] == 'linkedpeople') echo 'class="active"'; ?> >
                        <a href="#linkedPeople" data-toggle="tab">People</a>
                    </li>
                    <li <?php if (isset($_GET['tid']) && $_GET['tid'] == 'documents') echo 'class="active"'; ?> >
                        <a href="#documents" data-toggle="tab">Legal Documents</a>
                    </li>
                    <li <?php if (isset($_GET['tid']) && $_GET['tid'] == 'evidence') echo 'class="active"'; ?> >
                        <a href="#evidence" data-toggle="tab">Evidence</a>
                    </li>
                    <li <?php if (isset($_GET['tid']) && $_GET['tid'] == 'actionplan') echo 'class="active"'; ?>>
                        <a href="#actionPlan" data-toggle="tab">Action Plan</a>
                    </li>
                    <li <?php if (!isset($_GET['tid'])) echo 'class="active"'; ?>>
                        <a href="#general" id='tidgeneral-archive' data-toggle="tab">General</a>
                    </li>
                </ul>
                <!-- end: Tabs -->

            </div>
            <div class="box-content" id="boxcontent">
                <?php if ($case->status != 6) { ?>
                    <div class="row">
                        <div class="pull-right">
                            <a class ="btn btn-medium btn-info" style='margin-bottom: 10px' href="#applyToReopenModal2" data-toggle="modal">
                                &nbsp;Apply to Reopen
                            </a>
                            &nbsp;&nbsp;
                        </div>
                    </div>
                <?php } ?>

                <?php if ($case->status == 5) { ?>
                    <div class="row" style="background-color:#CCD5C8;" id="viewAssessment">
                        <h5 style="margin-left:15px;">This case is closed. View assessment <a class ="" style='margin-bottom: 10px; color:black;' href="#viewAssessmentModal" data-toggle="modal">here</a>. </h5>
                    </div>
                    <br>
                <?php } ?>
                <?php if ($case->status == 6) { ?>
                    <div class="row" style="background-color:#CCD5C8;" id="appliedForReopening">
                        <h5 style="margin-left:15px;">This case was applied for re-opening. To view the details, click <a class ="" style='margin-bottom: 10px' href="#viewApplyToReopenModal" data-toggle="modal" style="color:black;">here</a>. </h5>
                    </div>
                    <br>
                <?php } ?>

                <br>

                <!-- start: Tab contents -->
                <div id="myTabContent" class="tab-content" style='padding: 10px;'>
                    <div class="tab-pane <?php if (!isset($_GET['tid'])) echo 'active'; ?>" id="general">
                        <?php $this->load->view('intern/caseFolder-archive/general'); ?>
                    </div>
                    <div class="tab-pane <?php if (isset($_GET['tid']) && $_GET['tid'] == 'actionplan') echo 'active'; ?>" id="actionPlan">
                        <?php $this->load->view('intern/caseFolder-archive/actionPlan'); ?>
                    </div>
                    <div class="tab-pane <?php if (isset($_GET['tid']) && $_GET['tid'] == 'evidence') echo 'active'; ?>" id="evidence">
                        <?php $this->load->view('intern/caseFolder-archive/evidence'); ?>
                    </div>
                    <div class="tab-pane <?php if (isset($_GET['tid']) && $_GET['tid'] == 'linkedpeople') echo 'active'; ?>" id="linkedPeople">
                        <?php $this->load->view('intern/caseFolder-archive/linkedPeople'); ?>
                    </div>
                    <div class="tab-pane <?php if (isset($_GET['tid']) && $_GET['tid'] == 'documents') echo 'active'; ?>" id="documents">
                        <?php $this->load->view('intern/caseFolder-archive/documents'); ?>
                    </div>
                    <div class="tab-pane <?php if (isset($_GET['tid']) && $_GET['tid'] == 'events') echo 'active'; ?>" id="events">
                        <?php $this->load->view('intern/caseFolder-archive/events'); ?>
                    </div>
                    <div class="tab-pane <?php if (isset($_GET['tid']) && $_GET['tid'] == 'minutes') echo 'active'; ?>" id="minutes">
                        <?php $this->load->view('intern/caseFolder-archive/minutes'); ?>
                    </div>
                    <div class="tab-pane <?php if (isset($_GET['tid']) && $_GET['tid'] == 'research') echo 'active'; ?>" id="research">
                        <?php $this->load->view('intern/caseFolder-archive/research'); ?>
                    </div>
                </div>
                <!-- end: Tab contents -->

            </div>
        </div>
    </div><!--/col-->

    <!-- START OF VIEWASSESSMENTMODAL -->
    <div class="row">
        <div class="modal fade" id="viewAssessmentModal">
            <div class="modal-dialog-assessment">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Case Assessment</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-sm-5">

                                <div class="col-sm-3 control-group">
                                    <div class="controls">
                                        <center> <h5> <b> Case Title: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5><?php echo $case->caseName ?></h5>
                                    </div>
                                </div>

                                <br><br>

                                <div class="col-sm-3 control-group">
                                    <div class="controls">
                                        <center> <h5> <b>Offense: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php
                                            $count = 1;
                                            foreach ($caseoffense as $row) {
                                                if ($count > 1) {
                                                    echo ', ';
                                                }
                                                echo $row->offenseName;
                                                $count++;
                                            }
                                            ?>
                                        </h5>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-5">

                                <div class="col-sm-4 control-group">
                                    <div class="controls">
                                        <center> <h5> <b>Client's Stand: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-6 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php echo $caseclient[0]->typeName; ?>
                                        </h5>
                                    </div>
                                </div>

                                <br><br>

                                <div class="col-sm-4 control-group">
                                    <div class="controls">
                                        <center> <h5><b> Court's Verdict:</b> </h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-6 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php echo $case->closedecision; ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div style="overflow:scroll; height:400px; border-width:4px;">

                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>
                                        <b>Strategy</b>
                                        <br><br>
                                        <p><?php echo $case->strategy ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Strengths</b>
                                        <br><br>
                                        <p><?php echo $case->strength ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Weaknesses</b>
                                        <br><br>
                                        <p><?php echo $case->weakness ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Opportunities</b>
                                        <br><br>
                                        <p><?php echo $case->opportunity ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Threats</b>
                                        <br><br>
                                        <p><?php echo $case->threat ?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <!-- END OF VIEWASSESSMENTMODAL -->

    <!-- START OF APPLYTOREOPENMODAL NA KELANGAN PARA AYOS-->
    <div class="row hide">
        <?php echo form_open(base_url(), 'cases/caseApplytoreopen'); ?>
        <div class="modal fade" id="applyToReopenModal">
            <div class="modal-dialog-applyToReopen">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Apply to Reopen Modal</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-sm-5">

                                <div class="col-sm-4 control-group">
                                    <div class="controls">
                                        <center> <h5> <b> Case Title: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5><?php echo $case->caseName ?></h5>
                                    </div>
                                </div>

                                <br><br>

                                <div class="col-sm-4 control-group">
                                    <div class="controls">
                                        <center> <h5> <b>Offense: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php
                                            $count = 1;
                                            foreach ($caseoffense as $row) {
                                                if ($count > 1) {
                                                    echo ', ';
                                                }
                                                echo $row->offenseName;
                                                $count++;
                                            }
                                            ?>
                                        </h5>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-5">

                                <div class="col-sm-5 control-group">
                                    <div class="controls">
                                        <center> <h5> <b>Client's Stand: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php echo $caseclient[0]->typeName ?>
                                        </h5>
                                    </div>
                                </div>

                                <br><br>

                                <div class="col-sm-5 control-group">
                                    <div class="controls">
                                        <center> <h5><b> Court's Verdict:</b> </h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php echo $case->closedecision; ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <br><br>

                        <div class="row">
                            <div class="col-sm-4 control-group">
                                <div class="controls">
                                    <center> <h5><b> Reason for Reopening:</b> </h5> </center>
                                </div>
                            </div>

                            <div class="col-sm-5 control-group">
                                <div class="controls">
                                    <select class="form-control" name="reasonForReopening">
                                        <option>Court's Order</option>
                                        <option>Client's Decision</option>
                                    </select>
                                </div>
                            </div>

                            <br><br>

                            <div class="col-sm-4 control-group">
                                <div class="controls">

                                </div>
                            </div>

                            <div class="col-sm-6 control-group">
                                <div class="controls">
                                    <?php echo form_textarea(array('class' => 'form-control', 'name' => 'notes', 'style' => 'width:100%; height:50px;')); ?>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">
                        <input type="hidden" name="cid" value="<?php echo $case->caseID ?>">
                        <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-success'), 'Submit'); ?>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->            
        </div><!-- /.modal-dialog -->
        <?php echo form_close(); ?>
    </div><!-- /.modal -->
    <!-- END OF APPLYTOREOPENMODAL NA KELANGAN PARA AYOS-->

    <!-- START OF APPLYTOREOPENMODAL NA AYOS TALAGA-->
    <div class="row">
        <?php echo form_open(base_url() . "cases/caseApplytoreopen/$case->caseID"); ?>
        <div class="modal fade" id="applyToReopenModal2">
            <div class="modal-dialog-applyToReopen">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Apply to Reopen Modal</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-sm-5">

                                <div class="col-sm-4 control-group">
                                    <div class="controls">
                                        <center> <h5> <b> Case Title: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5><?php echo $case->caseName ?></h5>
                                    </div>
                                </div>

                                <br><br>

                                <div class="col-sm-4 control-group">
                                    <div class="controls">
                                        <center> <h5> <b>Offense: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php
                                            $count = 1;
                                            foreach ($caseoffense as $row) {
                                                if ($count > 1) {
                                                    echo ', ';
                                                }
                                                echo $row->offenseName;
                                                $count++;
                                            }
                                            ?>
                                        </h5>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-5">

                                <div class="col-sm-5 control-group">
                                    <div class="controls">
                                        <center> <h5> <b>Client's Stand: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php echo $caseclient[0]->typeName ?>
                                        </h5>
                                    </div>
                                </div>

                                <br><br>

                                <div class="col-sm-5 control-group">
                                    <div class="controls">
                                        <center> <h5><b> Court's Verdict:</b> </h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php echo $case->closedecision; ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <br><br>

                        <div class="row">
                            <div class="col-sm-4 control-group">
                                <div class="controls">
                                    <center> <h5><b> Reason for Reopening:</b> </h5> </center>
                                </div>
                            </div>

                            <div class="col-sm-5 control-group">
                                <div class="controls">
                                    <select class="form-control" name="reasonForReopening">
                                        <option>Court's Order</option>
                                        <option>Client's Decision</option>
                                    </select>
                                </div>
                            </div>

                            <br><br>

                            <div class="col-sm-4 control-group">
                                <div class="controls">

                                </div>
                            </div>

                            <div class="col-sm-6 control-group">
                                <div class="controls">
                                    <?php echo form_textarea(array('class' => 'form-control', 'name' => 'notes', 'style' => 'width:100%; height:50px;')); ?>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">
                        <input type="hidden" name="cid" value="<?php echo $case->caseID ?>">
                        <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-success'), 'Submit'); ?>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->            
        </div><!-- /.modal-dialog -->
        <?php echo form_close(); ?>
    </div><!-- /.modal -->
    <!-- END OF APPLYTOREOPENMODAL NA AYOS TALAGA-->

    <!-- START OF VIEWAPPLYTOREOPENMODAL -->
    <div class="row">
        <div class="modal fade" id="viewApplyToReopenModal">
            <div class="modal-dialog-applyToReopen">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">View Reason for Reopening</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="col-sm-4 control-group">
                                    <div class="controls">
                                        <center> <h5> <b> Case Title: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5><?php echo $case->caseName ?></h5>
                                    </div>
                                </div>

                                <br><br>

                                <div class="col-sm-4 control-group">
                                    <div class="controls">
                                        <center> <h5> <b>Offense: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php
                                            $count = 1;
                                            foreach ($caseoffense as $row) {
                                                if ($count > 1) {
                                                    echo ', ';
                                                }
                                                echo $row->offenseName;
                                                $count++;
                                            }
                                            ?>
                                        </h5>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-5">

                                <div class="col-sm-5 control-group">
                                    <div class="controls">
                                        <center> <h5> <b>Client's Stand: </b></h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5>
                                            <?php echo $caseclient[0]->typeName ?>
                                        </h5>
                                    </div>
                                </div>

                                <br><br>

                                <div class="col-sm-5 control-group">
                                    <div class="controls">
                                        <center> <h5><b> Court's Verdict:</b> </h5> </center>
                                    </div>
                                </div>

                                <div class="col-sm-7 control-group">
                                    <div class="controls">
                                        <h5><?php echo $case->closedecision; ?></h5>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <br><br>

                        <div class="row">
                            <div class="col-sm-4 control-group">
                                <div class="controls">
                                    <center> <h5><b> Reason for Reopening:</b> </h5> </center>
                                </div>
                            </div>

                            <div class="col-sm-5 control-group">
                                <div class="controls">
                                    <center>
                                        <h5>
                                            <?php echo $case->reopenreason; ?>
                                        </h5>
                                    </center>
                                </div>
                            </div>

                            <br><br>

                            <div class="col-sm-4 control-group">
                                <div class="controls">

                                </div>
                            </div>

                            <div class="col-sm-6 control-group">
                                <div class="controls">
                                    <center> <h5></h5> </center>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- END OF APPLYTOREOPENMODAL -->
</div>
<!-- CASE FOLDER -->
