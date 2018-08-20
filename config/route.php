<?php
  error_reporting(E_ALL ^ E_NOTICE);

  include "../config/view.php";
  include_once '../config/login/login-func.php';
  include "focus.php";

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
    case "programmes": // This code acts for viewing of all the programmes
      programme();
      break;
    case "add_programme": // Caters for adding a new programme
      add_programme();
      break;
    case "updateProgramme": // This case is for updating programme
      $id = $_GET['id'];
      $name = $_POST['pname'];
      $category = $_POST['category'];
      $duration = $_POST['duration'];
      $gradLoad = $_POST['gradLoad'];
      $code = $_POST['code'];      
      update_programme($id,$name,$category,$duration,$gradLoad,$code);
      break;
    case "deleteProgramme": // Delete a programme
      $id = $_GET['id'];   
      delete_programme($id);
      break;
    case "insertProgramme": // For inserting a programme
      $name = $_POST['pname'];
      $category = $_POST['category'];
      $duration = $_POST['duration'];
      $gradLoad = $_POST['gradLoad'];
      $code = $_POST['code'];  
      insert_programme($name,$category,$duration,$gradLoad,$code);
      break;
    case "program_data": // This case is for viewing a particular program information
      $id = $_GET['id'];
      programData($id);
      break;
    case "view_courses": // Course units HTML
      view_course();
      break;
    case "add_course": // This case is for adding a course unit
      add_course();
      break;
    case "update_course": // This case is for updating a course unit
      update_course();
      break;      
    case "colleges": // Colleges Page HTML
      colleges();
      break;      
    case "insertCollege": // For inserting a College
      $shortname = $_POST['shortname'];
      $fullname = $_POST['fullname'];
      insert_college($shortname,$fullname);
      break;    
    case "college_data": // This case is for viewing a particular College information
      $id = $_GET['id'];
      collegeData($id);
      break; 
    case "updateCollege": // This case is for updating a college
      $id = $_GET['id'];
      $shortname = $_POST['shortname'];
      $fullname = $_POST['fullname'];    
      update_college($id,$shortname,$fullname);
      break;  
    case "deleteCollege": // Delete a programme
      $id = $_GET['id'];   
      delete_college($id);
      break;                 
    case "departments": // Departments Page HTML
      departments();
      break;      
    case "lecturers": // Lecturers Page HTML
      lecturers();
      break;        
   }
}

if (isset($_REQUEST['view'])){
  $id = $_REQUEST['view'];
  view_user($id);
}

if (isset($_REQUEST['view_student'])){
  $id = $_REQUEST['view_student'];
  view_std($id);
}