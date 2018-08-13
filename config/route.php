<?php
error_reporting(E_ALL ^ E_NOTICE);

include "../config/view.php";
include_once '../config/login/login-func.php';
//nclude "focus.php";

if (isset($_REQUEST['token'])){
  $signing = base64_decode($_REQUEST['token']);

  switch($signing){
    case "dashboard":
    dashboard();
    break;
    case "welcome":
    first_login_admin();
    break;
    case "enter_student":
    enter_student();
    break;
    case "view_students":
    view_students();
    break;
    case "schDetails":
    schoolDetails();
    break;
    case "viewUser":
    view_user();
    break;
    case "manageUsers":
    $inst_no = getfield('institute_instituteID',$mysqli);
    manageUsers($inst_no);
    break;
    case "updateInstDetails":
    $inst_no = getfield('institute_instituteID',$mysqli);
    updateinstituteDetails($inst_no);
    break;
    case "addUser":
    addUser();
    break;
    case "updateProfile":
    $id = getfield('id',$mysqli);
    updateProfile($id);
    break;
    default:
    pagenotfound();
    break;
    //this code acts for viewing of all the programmes
    case "programme":
    programme();
    break;
    //caters for adding a new programme
    case "add_programme":
    add_programme();
    break;
    //this ccase is for updating the programme
    case "updateProgramme":
    update_programme($upid);
    break;
    //this case is for viewing the course units
    case "view_course":
    view_course();
    break;
    //this case is for adding a course unit
    case "add_course":
    add_course();
    break;
    //this case is for updating a course unit
    case "update_course":
    update_course();
    break;
   }
}
if (isset($_REQUEST['view'])){
  $id = $_REQUEST['view'];
  view_user($id);
}
//this section is for editing the programme
if (isset($_REQUEST['edit_programme'])){
  $id = $_REQUEST['edit_programme'];
  edit_programme($id);
}
if (isset($_REQUEST['view_student'])){
  $id = $_REQUEST['view_student'];
  view_std($id);
}