<div class="container">

  <div class="row">

    <a class ="btn btn-medium btn-success pull-right" style='margin-bottom: 10px' href="#addPersonModal" data-toggle="modal">
      <i class="icon-plus-sign"></i>&nbsp;Add Linked Person</a>
  </div>

  <div class="row">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Type</th>
          <th>Contact Number</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php foreach ($casepeople as $row) : ?>
          <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row->firstname . ' ' . $row->middlename . ' ' . $row->lastname ?></td>
            <td><?php echo $this->Case_model->select_strtype($row->participation)->typeName . ' (' . $this->Case_model->select_strtype($row->side)->typeName . ')' ?></td>
            <td>
              <?php
              if ($row->contacthome != null) {
                echo $row->contacthome . ' (Home) ; ';
              }
              ?>
              <?php
              if ($row->contactoffice != null) {
                echo $row->contactoffice . ' (Office) ; ';
              }
              ?>
              <?php
              if ($row->contactmobile != null) {
                echo $row->contactmobile . ' (Mobile)';
              }
              ?>
            </td>
            <td> 
              <a class ="btn btn-success" href="#editPersonModal<?php echo $row->personID; ?>" data-toggle="modal"> <i class="icon-edit"></i> </a>
              <?php if ($row->participation != 6) { ?>
                <a class ="btn btn-danger" href="#deletePersonModal<?php echo $row->personID; ?>" data-toggle="modal"> <i class="icon-remove"></i> </a>
              <?php } ?>
            </td>
            <?php $i++; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- <div class="row">                                                                  NOT YET WORKING

      <a class ="btn btn-medium btn-link" style='margin-bottom: 10px' href="#viewLinkedPerson" data-toggle="modal">View Linked Person</a>

  </div> -->

  <!--START OF ADD LINKED PERSON modal -->
  <div class="row">
    <div class="modal fade" id="addPersonModal">
      <div class="modal-dialog-evidence">
        <div class="modal-content">
          <?php echo form_open(base_url() . "people/addlinkedpeople/" . $case->caseID, array('class' => 'form-horizontal')); ?>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Add Linked Person</h4>
          </div>
          <div class="modal-body">

            <div class="col-sm-2 control-group">
              <div class="controls">
                <center> <h5><b>Name<span class="glyphicon glyphicon-asterisk"></span></b></h5> </center>
              </div>
            </div>

            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'First', 'id' => 'partyFirstName', 'name' => 'partyFirstName', 'type' => 'text', 'class' => 'form-control')); ?>
              </div> 
            </div>

            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'Middle', 'id' => 'partyMiddleName', 'name' => 'partyMiddleName', 'type' => 'text', 'class' => 'form-control')); ?>
              </div>   
            </div>

            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'Last', 'id' => 'partyLastName', 'name' => 'partyLastName', 'type' => 'text', 'class' => 'form-control')); ?>   
              </div>   
            </div>
            <br><br>

            <div class="col-sm-2 control-group">
              <div class="controls">
                <center> <h5><b>Address</b></h5> </center>
              </div>
            </div>

            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'House', 'id' => 'partyAddressHouseNo', 'name' => 'partyAddressHouseNo', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)')); ?>      </div>
            </div>

            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'Street', 'id' => 'partyAddressStreet', 'name' => 'partyAddressStreet', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)')); ?>
              </div>
            </div>

            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'Town', 'id' => 'partyAddressTown', 'name' => 'partyAddressTown', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)')); ?>
              </div>
            </div>

            <br><br>
            <div class="col-sm-2 control-group">
              <div class="controls">
              </div>
            </div>
            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'District', 'id' => 'partyAddressDistrict', 'name' => 'partyAddressDistrict', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)')); ?>
              </div>
            </div>

            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'Postal Code', 'id' => 'partyAddressPostalCode', 'name' => 'partyAddressPostalCode', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)')); ?>
              </div>
            </div>

            <br><br>

            <div class="col-sm-2 control-group">
              <div class="controls">
                <center> <h5><b>Contact Number</b></h5> </center>
              </div>
            </div>

            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'Home', 'id' => 'partyCNHome', 'name' => 'partyCNHome', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)')); ?>
              </div>
            </div>

            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'Office', 'id' => 'partyCNOffice', 'name' => 'partyCNOffice', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)')); ?>
              </div>
            </div>

            <div class="col-sm-3 control-group">
              <div class="controls">
                <?php echo form_input(array('placeholder' => 'Mobile', 'id' => 'partyCNMobile', 'name' => 'partyCNMobile', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)')); ?>
              </div>
            </div>

            <br><br>

            <div class="col-sm-2 control-group">
              <div class="controls">
                <center><b><h5><b>Participation<span class="glyphicon glyphicon-asterisk"></span></b></h5></b></center>
              </div>
            </div>

            <div class="col-sm-9 control-group">
              <div class="controls">
                <select id="partyParticipation" name="partyParticipation" class="form-control">
                  <option></option>
                  <option value='5'>Sheriff</option>
                  <option value='6'>Public Prosecutor</option>
                  <option value='7'>Private Prosecutor</option>
                  <option value='8'>Counsel for Accused</option>
                  <option value='9'>Judge</option>
                  <option value='10'>Clerk of Court</option>
                  <option value='11'>Other Court Officer</option>
                </select>
              </div>   
            </div>

            <br><br>

          </div>
          <div class="modal-footer">
            <input class="btn btn-success" type="submit" aria-hidden="true" value="Add Person">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
  <!--END OF ADD LINKED PERSON modal -->

  <!--START OF VIEW LINKED PERSON modal -->
  <div class="row">
    <?php foreach ($casepeople as $row) : ?>
      <div class="modal fade" id="viewLinkedPerson<?php echo $row->personID; ?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Linked Person</h4>
            </div>
            <div class="modal-body">

              <table class="table table-striped">
                <tr>
                  <th>Name:</th>
                  <td><?php echo "$row->firstname $row->middlename $row->lastname"; ?></td>
                </tr>
                <tr>
                  <th>Address:</th>
                  <td>
                    <?php echo $row->addrhouse . ' ' . $row->addrstreet . ' St., ' . $row->addrtown ?>
                    <?php
                    if ($row->addrdistrict != '')
                      echo ' | District ' . $row->addrdistrict;

                    if ($row->addrpostalcode != '')
                      echo ' (' . $row->addrpostalcode . ')';
                    ?>
                  </td>
                </tr>
                <tr>
                  <th>Contact Number:</th>
                  <td>
                    <?php
                    if ($row->contacthome != null) {
                      echo $row->contacthome . ' (Home) | ';
                    }
                    if ($row->contactoffice != null) {
                      echo $row->contactoffice . ' (Office) | ';
                    }
                    if ($row->contactmobile != null) {
                      echo $row->contactmobile;
                    }
                    ?>
                  </td>
                </tr>
                <tr>
                  <th>Participation:</th>
                  <td>
                    <?php echo $this->Case_model->select_strtype($row->participation)->typeName . ' (' . $this->Case_model->select_strtype($row->side)->typeName . ')' ?>
                  </td>
                </tr>
              </table>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    <?php endforeach; ?>
  </div>
  <!--END OF VIEW LINKED PEOPLE modal -->

  <!--START OF DELETE LINKED PERSON modal -->
  <div class="row">
    <?php foreach ($casepeople as $row) : ?>
      <div class="modal fade" id="deletePersonModal<?php echo $row->personID; ?>">
        <div class="modal-dialog">
          <div class="modal-content">
            <?php echo form_open(base_url() . "people/delete/$case->caseID/$row->personID", array('class' => 'form-horizontal')); ?>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Delete Linked Person</h4>
            </div>
            <div class="modal-body">

              <h2>
                Are you sure you want to delete <?php echo "$row->firstname $row->lastname"; ?>?
              </h2>

            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-danger" value="Delete">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close(); ?>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    <?php endforeach; ?>
  </div>
  <!--END OF DELETE LINKED PEOPLE modal -->

  <!-- START OF EDIT LINKED PERSON modal-->
  <div class="row">
    <?php foreach ($casepeople as $row) : ?>
      <div class="modal fade" id="editPersonModal<?php echo $row->personID; ?>">
        <div class="modal-dialog-evidence">
          <div class="modal-content">
            <?php echo form_open(base_url() . "people/edit/$row->personID", array('class' => 'form-horizontal')); ?>
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Edit Linked Person Information</h4>
            </div>
            <div class="modal-body">

              <div class="col-sm-2 control-group">
                <div class="controls">
                  <center> <h5><b>Name<span class="glyphicon glyphicon-asterisk"></span></b></h5> </center>
                </div>
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'First', 'id' => 'partyFirstName', 'name' => 'partyFirstName', 'type' => 'text', 'class' => 'form-control', 'value' => $row->firstname)); ?>
                </div> 
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'Middle', 'id' => 'partyMiddleName', 'name' => 'partyMiddleName', 'type' => 'text', 'class' => 'form-control', 'value' => $row->middlename)); ?>
                </div>   
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'Last', 'id' => 'partyLastName', 'name' => 'partyLastName', 'type' => 'text', 'class' => 'form-control', 'value' => $row->lastname)); ?>   
                </div>   
              </div>
              <br><br>

              <div class="col-sm-2 control-group">
                <div class="controls">
                  <center> <h5><b>Address</b></h5> </center>
                </div>
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'House', 'id' => 'partyAddressHouseNo', 'name' => 'partyAddressHouseNo', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)', 'value' => $row->addrhouse)); ?>      </div>
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'Street', 'id' => 'partyAddressStreet', 'name' => 'partyAddressStreet', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)', 'value' => $row->addrstreet)); ?>
                </div>
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'Town', 'id' => 'partyAddressTown', 'name' => 'partyAddressTown', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)', 'value' => $row->addrtown)); ?>
                </div>
              </div>

              <br><br>
              <div class="col-sm-2 control-group">
                <div class="controls">
                </div>
              </div>
              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'District', 'id' => 'partyAddressDistrict', 'name' => 'partyAddressDistrict', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)', 'value' => $row->addrdistrict)); ?>
                </div>
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'Postal Code', 'id' => 'partyAddressPostalCode', 'name' => 'partyAddressPostalCode', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)', 'value' => $row->addrpostalcode)); ?>
                </div>
              </div>

              <br><br>

              <div class="col-sm-2 control-group">
                <div class="controls">
                  <center> <h5><b>Contact Number</b></h5> </center>
                </div>
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'Home', 'id' => 'partyCNHome', 'name' => 'partyCNHome', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)', 'value' => $row->contacthome)); ?>
                </div>
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'Office', 'id' => 'partyCNOffice', 'name' => 'partyCNOffice', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)', 'value' => $row->contactoffice)); ?>
                </div>
              </div>

              <div class="col-sm-3 control-group">
                <div class="controls">
                  <?php echo form_input(array('placeholder' => 'Mobile', 'id' => 'partyCNMobile', 'name' => 'partyCNMobile', 'type' => 'text', 'class' => 'form-control', 'onkeyup' => 'saveThis(this.id)', 'value' => $row->contactmobile)); ?>
                </div>
              </div>

              <br><br>

              <div class="col-sm-2 control-group">
                <div class="controls">
                  <center><b><h5><b>Participation<span class="glyphicon glyphicon-asterisk"></span></b></h5></b></center>
                </div>
              </div>

              <div class="col-sm-9 control-group">
                <div class="controls">
                  <h5><?php echo $this->Case_model->select_strtype($row->participation)->typeName; ?></h5>
                </div>   
              </div>

              <br><br>

            </div>
            <div class="modal-footer">
              <input class="btn btn-success" type="submit" aria-hidden="true" value="Save">
              <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <!-- END OF EDIT LINKED PERSON modal-->

</div>
