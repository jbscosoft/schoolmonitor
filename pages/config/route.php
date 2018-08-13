<?php
error_reporting(E_ALL ^ E_NOTICE);

include "../config/view.php";
//nclude "focus.php";

if (isset($_REQUEST['token'])){
  $signing = base64_decode($_REQUEST['token']);

  switch($signing){
    case "student":
    students();
    break;
    case "schDetails":
    schoolDetails();
    break;
    case "manageUsers":
    manageUsers();
    break;
    case "addUser":
    addUser();
    break;
    default:
    pagenotfound();
    break;
    
   }
}