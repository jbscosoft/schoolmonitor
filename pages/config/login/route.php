<?php
error_reporting(E_ALL ^ E_NOTICE);

include "config/login/view.php";
//nclude "focus.php";

if (isset($_REQUEST['this'])){
  $signing = base64_decode($_REQUEST['this']);
  switch($signing){
    case "usethistologin":
    auth();
    break;
    case "usethistoregister":
    register();
    break;
   }
}