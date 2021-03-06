<?php

//people controller

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class People extends CI_Controller {

  function __construct() {
    parent:: __construct();
    $this->load->spark('markdown-extra/0.0.0');
  }

  function index() {
    $uid = $this->session->userdata('userid');
    if (empty($uid)) {
      $this->session->set_flashdata('session_error', TRUE);
      redirect('login/index');
    }
    $utype = $this->People_model->getuserfield('type', $uid);

    $data['image'] = $this->People_model->getuserfield('image', $uid);
    $data['name'] = $this->People_model->getuserfield('firstname', $uid) . ' ' . $this->People_model->getuserfield('lastname', $uid);

    $data['external'] = $this->People_model->select_external();
    $data['internal'] = $this->People_model->select_internal();

    $data['notifs'] = $this->Notification_model->select_notifs($uid);
    $data['notifcount'] = $this->Notification_model->select_count_unread($uid);

    $this->load->view('header');
    switch ($utype) {
      case 1 :
        $this->load->view('director/menubar', $data);
        $this->load->view('director/people', $data);
        break;
      case 2 :
        $this->load->view('assistant/menubar', $data);
        $this->load->view('assistant/people', $data);
        break;
      case 3 :
        $this->load->view('secretary/menubar', $data);
        $this->load->view('secretary/people', $data);
        break;
      case 4 :
        $this->load->view('lawyer/menubar', $data);
        $this->load->view('lawyer/people', $data);
        break;
      case 5 :
        $this->load->view('intern/menubar', $data);
        $this->load->view('intern/people', $data);
        break;
    }
    $this->load->view('footer');
  }

  function profile() {

    $uid = $this->session->userdata('userid');
    if (empty($uid)) {
      $this->session->set_flashdata('session_error', TRUE);
      redirect('login/index');
    }
    $utype = $this->People_model->getuserfield('type', $uid);

    $data['image'] = $this->People_model->getuserfield('image', $uid);
    $data['name'] = $this->People_model->getuserfield('firstname', $uid) . ' ' . $this->People_model->getuserfield('lastname', $uid);

    $data['notifs'] = $this->Notification_model->select_notifs($uid);
    $data['notifcount'] = $this->Notification_model->select_count_unread($uid);

    $data['person'] = $this->People_model->select_person($uid);
    $data['currentcasehandled'] = $this->People_model->count_currentcase($uid);

    $this->load->view('header');
    switch ($utype) {
      case 1 :
        $data['cases'] = $this->Case_model->select_caseaccepted();
        $this->load->view('director/menubar', $data);
        $this->load->view('director/profile', $data);
        break;
      case 2 :
        $this->load->view('assistant/menubar', $data);
        $this->load->view('assistant/profile', $data);
        break;
      case 3 :
        $this->load->view('secretary/menubar', $data);
        $this->load->view('secretary/profile', $data);
        break;
      case 4 :
        $data['cases'] = $this->Case_model->select_mycases($uid);
        $this->load->view('lawyer/menubar', $data);
        $this->load->view('lawyer/profile', $data);
        break;
      case 5 :
        $data['cases'] = $this->Case_model->select_mycases($uid);
        $this->load->view('intern/menubar', $data);
        $this->load->view('intern/profile', $data);
        break;
    }
    $this->load->view('footer');
  }

  function add($person) {
    $this->People_model->insert_person($person);
  }

  function edit($pid, $person) {
    $this->People_model->update_person($pid, $person);
  }

  function delete($pid) {
    $this->People_model->delete_person($pid);
  }

  function addlinkedpeople($cid) {

    $datetimenow = date("Y-m-d H:i:s", now());

    extract($_POST);
    $pid = 0;
    if ($pid == 0) { //dropdown from existing people is not set
      $person = array(
          'firstname' => $partyFirstName,
          'middlename' => $partyMiddleName,
          'lastname' => $partyLastName,
          'addrhouse' => $partyAddressHouseNo,
          'addrstreet' => $partyAddressStreet,
          'addrtown' => $partyAddressTown,
          'addrdistrict' => $partyAddressDistrict,
          'addrpostalcode' => $partyAddressPostalCode,
          'contacthome' => $partyCNHome,
          'contactoffice' => $partyCNOffice,
          'contactmobile' => $partyCNMobile
      );
      $this->add($person);
      $pid = $this->db->insert_id();
    } else {
      //$pid = $personID from dropdown
    }

    $data = array(
        'caseID' => $cid,
        'personID' => $pid,
        'participation' => $partyParticipation,
        'condition' => 'current',
        'datestart' => $datetimenow
    );
    $this->Case_model->insert_caseperson($data);
  }

  function editlinkedpeople($pid) {
    extract($_POST);

    $person = array(
        'firstname' => $partyFirstName,
        'middlename' => $partyMiddleName,
        'lastname' => $partyLastName,
        'addrhouse' => $partyAddressHouseNo,
        'addrstreet' => $partyAddressStreet,
        'addrtown' => $partyAddressTown,
        'addrdistrict' => $partyAddressDistrict,
        'addrpostalcode' => $partyAddressPostalCode,
        'contacthome' => $partyCNHome,
        'contactoffice' => $partyCNOffice,
        'contactmobile' => $partyCNMobile
    );

    $this->edit($pid, $person);
  }

  function deletelinkedpeople($cid, $pid) {
    $datetimenow = date("Y-m-d H:i:s", now());

    $changes = array(
        'condition' => 'expired',
        'dateend' => $datetimenow
    );
    $this->Case_model->update_caseperson($pid, $changes);
  }

  function newclient() {
    $uid = $this->session->userdata('userid');
    if (empty($uid)) {
      $this->session->set_flashdata('session_error', TRUE);
      redirect('login/index');
    }
    $utype = $this->People_model->getuserfield('type', $uid);

    $data['image'] = $this->People_model->getuserfield('image', $uid);
    $data['name'] = $this->People_model->getuserfield('firstname', $uid) . ' ' . $this->People_model->getuserfield('lastname', $uid);

    $data['notifs'] = $this->Notification_model->select_notifs($uid);
    $data['notifcount'] = $this->Notification_model->select_count_unread($uid);

    $this->load->view('header');
    $this->load->view('intern/menubar', $data);
    $this->load->view('intern/addnewclient-1');
    $this->load->view('footer');
  }

  function addnewclient() {
    extract($_POST);
    $data = array(
        'type' => 14, //14 = external
        'lastname' => $clientLastName,
        'firstname' => $clientFirstName,
        'middlename' => $clientMiddleName,
        'addrhouse' => $clientAddressHouseNo,
        'addrstreet' => $clientAddressStreet,
        'addrtown' => $clientAddressTown,
        'addrdistrict' => $clientAddressDistrict,
        'addrpostalcode' => $clientAddressPostalCode,
        'contacthome' => $clientCNHome,
        'contactoffice' => $clientCNOffice,
        'contactmobile' => $clientCNMobile,
        'emailaddr' => $clientEmail,
        'fbemailaddr' => $clientFb,
        'referredby' => $clientReferredBy,
        'rbcontact' => $rbContact,
        'sex' => $clientSex,
        'civilstatus' => $clientCivilStatus,
        'birthdate' => $clientBirthday,
        'birthplace' => $clientBirthPlace,
        'jobless' => $clientJobless,
        'salary' => $clientSalary,
        'occupation' => $clientOccupation,
        'organization' => $clientOrganization,
        'organizationaddr' => $clientOrganizationAddress
    );

    $this->add($data);

    $clientid = $this->db->insert_id();

    $clients = $this->session->userdata('clients');
    array_push($clients, $clientid);
    $this->session->set_userdata('clients', $clients);

    $data['clientlist'] = $this->People_model->externallist();
    $data['addedclients'] = $this->session->userdata('clients');
    $this->load->view('intern/createApplication/divclients', $data);
  }

  function changeopposing() {
    $data['addedclients'] = $this->session->userdata('clients');
    $data['addedopposing'] = $this->session->userdata('opposingparties');
    $data['opposingpartylist'] = $this->People_model->externallist();
    $this->load->view('intern/createApplication/divopposingparty', $data);
  }

  function addnewopposingparty() {
    extract($_POST);
    $data = array(
        'type' => 14, //14 = external
        'lastname' => $partyLastName,
        'firstname' => $partyFirstName,
        'middlename' => $partyMiddleName,
        'addrhouse' => $partyAddressHouseNo,
        'addrstreet' => $partyAddressStreet,
        'addrtown' => $partyAddressTown,
        'addrdistrict' => $partyAddressDistrict,
        'addrpostalcode' => $partyAddressPostalCode,
        'contacthome' => $partyCNHome,
        'contactoffice' => $partyCNOffice,
        'contactmobile' => $partyCNMobile
    );

    $this->add($data);

    $opposingID = $this->db->insert_id();

    $opposingparties = $this->session->userdata('opposingparties');
    array_push($opposingparties, $opposingID);
    $this->session->set_userdata('opposingparties', $opposingparties);

    $data['opposingpartylist'] = $this->People_model->externallist();
    $data['addedopposing'] = $this->session->userdata('opposingparties');
    $data['addedclients'] = $this->session->userdata('clients');
    $this->load->view('intern/createApplication/divopposingparty', $data);
  }

  function addexternal() {
    $data = array(
        'type' => 14, //external
        'lastname' => $this->input->post('lastname'),
        'firstname' => $this->input->post('firstname'),
        'middlename' => $this->input->post('middlename'),
        'addrhouse' => $this->input->post('addrhouse'),
        'addrstreet' => $this->input->post('addrstreet'),
        'addrtown' => $this->input->post('addrtown'),
        'addrdistrict' => $this->input->post('addrdistrict'),
        'addrpostalcode' => $this->input->post('addrpostalcode'),
        'contacthome' => $this->input->post('contacthome'),
        'contactoffice' => $this->input->post('contactoffice'),
        'contactmobile' => $this->input->post('contactmobile')
    );

    $this->add($data);

    $data['opposingpartylist'] = $this->People_model->opposingpartylist();
    $data['externals'] = $this->People_model->select_external();
    $data['lastname'] = $this->input->post('lastname');
    $data['firstname'] = $this->input->post('firstname');
    $data['middlename'] = $this->input->post('middlename');
    $data['use'] = $this->input->post('use');
    $data['clientid'] = $this->People_model->select_firstclient();

    $this->load->view('intern/createApplication/dropdowns', $data);
  }

  function attendanceLogs() {
    $uid = $this->session->userdata('userid');
    if (empty($uid)) {
      $this->session->set_flashdata('session_error', TRUE);
      redirect('login/index');
    }
    $datestring = "%F %j, %Y";
    $datestring2 = "%Y-%m-%d";
    $time = now();
    $datenow = mdate($datestring, $time);
    $datenowdd = mdate($datestring2, $time);
    extract($_POST);
    if (!isset($attendancelogdate)) {
      $data['residency'] = $this->People_model->select_all_residency();
    } else {
      $inputdate = $attendancelogdate;
      $data['residency'] = $this->People_model->select_residency($inputdate);
    }

    $data['datenow'] = $datenow;
    $data['datenowdd'] = $datenowdd;
    $data['image'] = $this->People_model->getuserfield('image', $uid);
    $data['name'] = $this->People_model->getuserfield('firstname', $uid) . ' ' . $this->People_model->getuserfield('lastname', $uid);

    $data['notifs'] = $this->Notification_model->select_notifs($uid);
    $data['notifcount'] = $this->Notification_model->select_count_unread($uid);

    $data['interns'] = $this->People_model->select_interns();

    $this->load->view('header');
    $this->load->view('secretary/menubar', $data);
    $this->load->view('secretary/attendanceLogs', $data);
    $this->load->view('footer');
  }

  function internmgt() {
    $uid = $this->session->userdata('userid');
    if (empty($uid)) {
      $this->session->set_flashdata('session_error', TRUE);
      redirect('login/index');
    }
    $datestring = "%F %j, %Y";
    $datestring2 = "%Y-%m-%d";
    $time = now();
    $datenow = mdate($datestring, $time);
    $datenowdd = mdate($datestring2, $time);

    $data['datenow'] = $datenow;
    $data['image'] = $this->People_model->getuserfield('image', $uid);
    $data['name'] = $this->People_model->getuserfield('firstname', $uid) . ' ' . $this->People_model->getuserfield('lastname', $uid);

    $data['notifs'] = $this->Notification_model->select_notifs($uid);
    $data['notifcount'] = $this->Notification_model->select_count_unread($uid);

    $data['residency'] = $this->People_model->select_residency('2014-07-06');

    $this->load->view('header');
    $this->load->view('secretary/menubar', $data);
    $this->load->view('secretary/internmgt', $data);
    $this->load->view('footer');
  }

  function insertResidency() {
    $error = 'blank';
    $x = $_POST['recordsAttendance'];
    $date = $_POST['residencydate'];
    for ($i = 1; $i <= $x; $i++) {

      $pid = $_POST['internname' . $i];
      $timein = $_POST['timestart' . $i];
      $timeout = $_POST['timeend' . $i];

      $available = $this->People_model->check_residency($pid, $date, $timein, $timeout);

      if ($available->Available) {
        $changes = array(
            'userID' => $pid,
            'date' => $date,
            'timeStarted' => $timein,
            'timeEnded' => $timeout,
        );
        $this->People_model->insert_residency($changes);
      } else {
        $error = "An intern was not logged properly. Please <a href='people/attendanceLogs'>try again.</a>";
      }
    }

    if ($error = 'blank') {
      redirect('people/attendanceLogs?recorded=yes');
    } else {
      echo $error;
    }
  }

  function showinterns() {
    $interns = $this->People_model->internlist();
    $count = 0;
    $arrinterns = array();

    foreach ($interns as $i) {
      $arrinterns[$count] = $i->personID;
      $count++;
    }

    // //var_dump($arrinterns);
    // $arr = array();
    // $arr[0] = "Mark Reed";
    // $arr[1] = "34";
    // $arr[2] = "Australia";

    echo json_encode($arrinterns);
    exit();
  }

  function showspecializedlawyers($offenseID) {
    $lawyers = $this->People_model->select_specialized($offenseID);
    $count = 0;
    $arrlawyers = array();

    foreach ($lawyers as $l) {
      $arrlawyers[$count] = $i->firstname . ' ' . $i->lastname . ' (' . $i->difficultyLevel . ')';
      $count++;
    }

    echo json_encode($arrlawyers);
    exit();
  }

  // function showname($id){
  //     $name = $this->People_model->getuserfield('firstname', $id) . ' ' . $this->People_model->getuserfield('lastname', $id);
  //     echo $name;
  // }
  function showname() {
    $id = $this->input->post('id');
    $name = $this->People_model->getuserfield('firstname', $id) . ' ' . $this->People_model->getuserfield('lastname', $id);
    echo json_encode($name);
    exit();
  }

}

?>
