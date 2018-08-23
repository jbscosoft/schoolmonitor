<?php

function msg_error($msgHeader, $msgContent) {
    echo "<div class='alert alert-danger alert-dismissible'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
   <h4>  <i class='icon fa fa-remove'></i> $msgHeader</h4>
    <p>$msgContent</p>
    </div>";
}
function msg_success($msgHeader, $msgContent) {
    echo "<div class='alert alert-success alert-dismissible'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
     <h4><i class='icon fa fa-check'></i>$msgHeader</h4>
    <p>$msgContent</p>
    </div>";
}
function new_institution($institute_name, $instNo, $usraccNo, $username, $password_hash, $email, $phone_no, $key, $timestamp) {
    //inserting | Institute Details
    include 'real-config.php';
    if ($mysqli->query("INSERT INTO institute (institute_name,pro_key,institute_no)VALUES ('" . $institute_name . "','" . $key . "','" . $instNo . "')")) {
        return true;
        if ($inst = $mysqli->prepare("SELECT id, institute_name FROM institute WHERE institute_no = ? LIMIT 1")) {
            $inst->bind_param('i', $instNo); // Bind "$username" to parameter.   // Execute the prepared query.
            if (!$inst->execute()) {
                //return false;
                echo "no1" . $mysqli->error;
            }
            $inst->store_result();
            //inserting | Super User Details
            $inst->bind_result($id, $institute_name);
            $inst->fetch();
            if ($inst->num_rows == 1) {
                // $query = ;
                // $query->bind_param("ssssi", $username,$password,$email,$phone1,$id);
                if ($mysqli->query("INSERT INTO users (username,dwp,email,phone1,institute_instituteID,entryDate,accNo)VALUES ('$username','$password_hash','$email','$phone_no','$id','$timestamp','$usraccNo')")) {
                    return true;
                } else {
                    return false;
                }
                //echo "User Insert 630yes";
                
            } else {
                return false;
            }
            // echo "Select ID yes";
            
        } else {
            return false;
        }
        // echo "Insert  yes";
        
    } else {
        //return false;
        echo "no6" . $mysqli->error;
    }
}
function viewUsers() {
    if ($inst = $mysqli->prepare("SELECT id, institute_name FROM institute WHERE institute_no = ? LIMIT 1")) {
        $inst->bind_param('i', $instNo); // Bind "$username" to parameter.   // Execute the prepared query.
        if (!$inst->execute()) {
            return false;
        }
    }
}
function check_serial($key) {
    include 'real-config.php';
    $query = "SELECT * FROM ethusiast WHERE s_key = '" . $key . "' AND s_status = 'A'";
    $query_run = mysqli_query($mysqli, $query);
    if (!$query_run) {
        echo "Query Run Error" . mysqli_error($mysqli);
    } else {
        $num_of_rows = mysqli_num_rows($query_run);
        if ($num_of_rows == 1) {
            $date = date('d/m/y');
            $mysqli->query("UPDATE `ethusiast` SET `s_status` = 'T', `i_date` = '$date' WHERE `ethusiast`.`s_key` = '" . $key . "'");
            return true;
        } else {
            return false;
        }
    }
}
function check_inst($inst_name) {
    include 'real-config.php';
    $query = "SELECT * FROM institute WHERE institute_name = '" . $inst_name . "'";
    $query_run = mysqli_query($mysqli, $query);
    if (!$query_run) {
        echo "Query Run Error" . mysqli_error($mysqli);
    } else {
        $num_of_rows = mysqli_num_rows($query_run);
        if ($num_of_rows == 1) {
            return true;
        } else {
            return false;
        }
    }
}

function check_program($program_code) {
    include 'real-config.php';
    $query = "SELECT * FROM programme WHERE code = '" . $program_code . "'";
    $query_run = mysqli_query($mysqli, $query);
    if (!$query_run) {
        echo "Query Run Error" . mysqli_error($mysqli);
    } else {
        $num_of_rows = mysqli_num_rows($query_run);
        if ($num_of_rows == 1) {
            return true;
        } else {
            return false;
        }
    }
}
function check_course($course) {
    include 'real-config.php';
    $query = "SELECT * FROM courseunit WHERE courseunitCode = '" . $course . "'";
    $query_run = mysqli_query($mysqli, $query);
    if (!$query_run) {
        echo "Query Run Error" . mysqli_error($mysqli);
    } else {
        $num_of_rows = mysqli_num_rows($query_run);
        if ($num_of_rows == 1) {
            return true;
        } else {
            return false;
        }
    }
}
function add_user() {
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone1 = $_POST['phone1'];
    $phone2 = $_POST['phone2'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hash = password_hash($password,PASSWORD_DEFAULT);
    $role = $_POST['group'];
    $accStatus = $_POST['accStatus'];
    $entryDate = date('Y/m/d H:i:s');
    $accNo = rand(500, 700);
    $accNumber = "USR" . $accNo;
    include 'config/real-config.php';
    $inst_id = getfield('institute_instituteID', $mysqli);
    // echo "lllllllllllllllll".$inst_id;
    if ($mysqli->query("INSERT INTO `users` (`accNo`, `username`,`gender`, `sname`, `fname`, `designation`, `dob`,`dwp`, `group`, `accStatus`, `entryDate`,`phone1`, `phone2`, `email`, `institute_instituteID`) VALUES (
        '" . $accNumber . "',
        '" . $username . "',
        '" . $gender . "',
        '" . $sname . "',
        '" . $fname . "',
        '" . $designation . "',
        '" . $dob . "',
        '" . $password_hash . "',
        '" . $role . "',
        '" . $accStatus . "',
        '" . $date . "',
        '" . $phone1 . "',
        '" . $phone2 . "',
        '" . $email . "',
        '" . $inst_id . "');")) {
        msg_success('Operation Successful', 'User Added');
    } else {
        msg_error('Operation Failed', 'An Error Occured');
        echo $mysqli->error;
    }
}
function register_student() {
    //Biodata
    $rand = rand(1000, 20000);
    $studentNo = $_POST['student_no'];
    $admissionNo = $_POST['admission_no'];
    $reg_no = $_POST['reg_no'];
    echo $reg_no;
    $sname = $_POST['sname'];
    $fname = $_POST['fname'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $religion = $_POST['religion'];
    $student_type = $_POST['student_type'];
    $marital_status = $_POST['marital_status'];
    $residence = $_POST['residence'];
    $date = $_POST['date'];
    $phoneno = $_POST['phoneno'];
    $email = $_POST['email'];
    $hall = $_POST['hall'];
    $dob = $_POST['dob'];
    $entry_scheme = $_POST['entry_scheme'];

    $program = $_POST['program'];
    $dateAdmission = $_POST['dateAdmission'];
    $academicYearEntry = $_POST['academicYearEntry'];
    $gradDate = $_POST['gradDate'];

    $fname = $_POST['fname'];
    $fcareer = $_POST['fcareer'];
    $faddress = $_POST['faddress'];
    $ftelno = $_POST['ftelno'];
    $femail = $_POST['femail'];

    $mname = $_POST['mname'];
    $mcareer = $_POST['mcareer'];
    $maddress = $_POST['maddress'];
    $mtelno = $_POST['mtelno'];
    $memail = $_POST['memail'];

    $gname = $_POST['gname'];
    $gcareer = $_POST['gcareer'];
    $gaddress = $_POST['gaddress'];
    $gtelno = $_POST['gtelno'];
    $gemail = $_POST['gemail'];

    $nname = $_POST['nname'];
    $ncareer = $_POST['ncareer'];
    $naddress = $_POST['naddress'];
    $ntelno = $_POST['ntelno'];
    $nemail = $_POST['nemail'];

    $olevelsch = $_POST['olevelsch'];
    $olevelyr = $_POST['olevelyr'];
    $olevelindex = $_POST['olevelindex'];

    $sopt1 = $_POST['sopt1'];
    $sopt2 = $_POST['sopt2'];
    $sopt3 = $_POST['sopt3'];

    $gopt1 = $_POST['gopt1'];
    $gopt2 = $_POST['gopt2'];
    $gopt3 = $_POST['gopt3'];

    $alevelsch = $_POST['alevelsch'];
    $alevelyr = $_POST['alevelyr'];
    $alevelindex = $_POST['alevelindex'];

    $formerInst = $_POST['formerInst'];
    $formerQual = $_POST['formerQual'];
    $formerYrCourse = $_POST['formerYrCourse'];
    $formerRegNo = $_POST['formerRegNo'];

    $medicalProblemDesc = $_POST['medicalProblemDesc'];
    
    if (isset($_FILES['imagePic'])) {
        $errors = array();
        $file_name = $_FILES['imagePic']['name'];
        $file_size = $_FILES['imagePic']['size'];
        $file_tmp = $_FILES['imagePic']['tmp_name'];
        $file_type = $_FILES['imagePic']['type'];
        $extensions = array("jpeg", "jpg", "png");
        if ($file_type != 'image/jpeg') {
            $errors = "extension not allowed, please choose a JPEG or PNG file.";
            echo $errors;
        }
        if ($file_size > 2097152) {
            $errors[] = 'File size must be excately 2 MB';
            echo $errors;
        }
        $date = date('Hms');
        $newFilename = trim($fullName . '.jpg');
        echo $newFilename;
        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "../dist/img/stdphotos/" . $newFilename);
        } else {
            echo "Image Upload Failed. Please Try Again";
        }
    }
    /************inserting data*******************/
    /**START  TRANSACTION **/
    include 'real-config.php';
    mysqli_autocommit($mysqli, FALSE);
    //Queries to execute
    $studentbio_query = $mysqli->query("INSERT INTO `student` (`id`, `regNo`, `studentNo`, `surname`, `firstName`, `gender`, `maritalStatus`, `photo`, `dob`, `nationality`, `hallOfResidence`, `religion`, `notes`, `medicalProblem`, `medicalInformation`, `telNo`, `address`, `yearOfStudy`, `placeOfResidence`, `email`, `academicyearEntry`, `dateOfAdmission`, `gradDate`, `entryScheme`, `dateofcompletion`, `program`, `status`, `uceSchool`, `uaceSchool`, `uceAggregates`, `uacePoints`, `formerInstitution`, `formerQualification`, `formerYearCourse`, `formerRegNo`, `promotionalStatus`, `courseDuration`, `reason`, `uceIndex`, `uaceIndex`, `institutionReg`, `yearOfCourse`, `yearOfUace`,`yearOfUCE`,`sponsorshipType`, `enteredOn`, `enteredBy`, `updatedOn`, `updatedBy`) VALUES (NULL, '" . $reg_no . "', '" . $studentNo . "', '" . $sname . "', '" . $fname . "', '" . $gender . "', '" . $marital_status . "', '" . $newFilename . "', '" . $dob . "', '" . $nationality . "', '" . $hall . "', '" . $religion . "', '', '', '" . $medicalProblemDesc . "', '" . $phoneno  . "', NULL, '" . $academicYearEntry . "', '" . $residence . "', '" . $email . "', '" . $academicYearEntry . "', '" . $dateAdmission . "', '" . $gradDate . "', '" . $entry_scheme . "', NULL, '" . $program . "', '" . $student_type . "', '" . $olevelsch . "', '" . $alevelsch . "', NULL, NULL, '" . $formerInst . "', '" . $formerQual . "','" . $formerYrCourse . "','" . $formerRegNo . "',NULL,NULL, NULL, '" . $olevelindex . "', '" . $alevelindex . "', NULL, '', '" . $alevelyr . "', '" . $olevelyr . "', '', '', '', '', '')");
if (!$studentbio_query){
    echo $mysqli->error;
}
    $get_stdno = mysqli_query($mysqli,"SELECT id FROM student WHERE studentNo = '".$studentNo."' ");
    $row = mysqli_fetch_array($get_stdno);
    $stdno = $row['id'];
    $father_query = $mysqli->query("INSERT INTO `parent` (`parentID`, `type`, `surname`, `firstname`, `address`, `telno1`, `telno2`, `alive`, `career`, `email`, `studentID`, `student_studentID`) VALUES (NULL, 'father', '" . $fname . "', NULL, '" . $faddress . "', '" . $ftelno . "', NULL, NULL, '" . $fcareer . "', '" . $femail . "', NULL, '" . $stdno . "')");
    $mother_query = $mysqli->query("INSERT INTO `parent` (`parentID`, `type`, `surname`, `firstname`, `address`, `telno1`, `telno2`, `alive`, `career`, `email`, `studentID`, `student_studentID`) VALUES (NULL, 'mother', '" . $mname . "', NULL, '" . $maddress . "', '" . $mtelno . "', NULL, NULL, '" . $mcareer . "', '" . $memail . "', NULL, '" . $stdno . "')");
    $guardian_query = $mysqli->query("INSERT INTO `parent` (`parentID`, `type`, `surname`, `firstname`, `address`, `telno1`, `telno2`, `alive`, `career`, `email`, `studentID`, `student_studentID`) VALUES (NULL, 'guardian', '" . $gname . "', NULL, '" . $gaddress . "', '" . $gtelno . "', NULL, NULL, '" . $gcareer . "', '" . $gemail . "', NULL, '" . $stdno . "')");
    $nok_query = $mysqli->query("INSERT INTO `parent` (`parentID`, `type`, `surname`, `firstname`, `address`, `telno1`, `telno2`, `alive`, `career`, `email`, `studentID`, `student_studentID`) VALUES (NULL, 'nok', '" . $nname . "', NULL, '" . $naddress . "', '" . $ntelno . "', NULL, NULL, '" . $ncareer . "', '" . $nemail . "', NULL, '" . $stdno . "')");
    $i = 1;
    while($i<8){
        $subject = $_POST[''.$i.'s'];
        $grade = $_POST[''.$i.'g'];
        $uce_query = $mysqli->query("INSERT INTO `uceresults` (`id`, `subject`, `result`, `student_studentID`) VALUES (NULL, '".$subject."', '".$grade."', '".$stdno."');");
    $i++;
    }
    $uce_opt1_query = $mysqli->query("INSERT INTO `uceresults` (`id`, `subject`, `result`, `student_studentID`) VALUES (NULL, '".$sopt1."', '".$gopt1."', '".$stdno."');");
    $uce_opt2_query = $mysqli->query("INSERT INTO `uceresults` (`id`, `subject`, `result`, `student_studentID`) VALUES (NULL, '".$sopt2."', '".$gopt2."', '".$stdno."');");
    $uce_opt3_query = $mysqli->query("INSERT INTO `uceresults` (`id`, `subject`, `result`, `student_studentID`) VALUES (NULL, '".$sopt3."', '".$gopt3."', '".$stdno."');");
    $x = 1;
    while($x<6){
        $subject = $_POST[''.$x.'as'];
        $grade = $_POST[''.$x.'ag'];
        $uace_query = $mysqli->query("INSERT INTO `uace_results` (`id`, `subject`, `result`, `student_studentID`) VALUES (NULL, '".$subject."', '".$grade."', '".$stdno."');");
    $x++;
    }
    if ($studentbio_query && $get_stdno && $father_query && $uce_query && $uce_opt1_query && $uce_opt2_query && $uce_opt3_query && $uace_query) {
        //Commiting Trasaction Onsucccess
        mysqli_commit($mysqli);
        mysqli_close($mysqli);
        msg_success('Operation Successful', 'Student Added');
    } else {
        //Rollback Trasaction OnFail
        mysqli_rollback($mysqli);
        msg_error('Operation Failed', 'An Error Occured');
        echo $mysqli->error;
    }
}
function insert_programme($name,$category,$duration,$gradLoad,$code){
    //$name = $_POST['pname'];
    //$category = $_POST['category'];
    //$duration = $_POST['duration'];
    //$gradLoad = $_POST['gradLoad'];
    //$code = $_POST['code'];
    // echo "lllllllllllllllll".$inst_id;
    include 'real-config.php';
    if (check_program($code) == false) {
        if ($mysqli->query("INSERT INTO `programme` (`name`, `category`,`duration`, `gradLoad`, `code`, `action`) VALUES (
        '" . $name . "',
        '" . $category . "',
        '" . $duration . "',
        '" . $gradLoad . "',
        '" . $code . "',
        'y'
        );")) {
            msg_success('Operation Successful', 'Programme Added');
        } else {
            msg_error('Operation Failed', 'An Error Occured');
            echo $mysqli->error;
        }
    } else {
        msg_error('Operation Failed', 'This Programme Exists');
    }
}
function update_programme($id,$name,$category,$duration,$gradLoad,$code) {
    // $name = $_POST['pname'];
    // $category = $_POST['category'];
    // $duration = $_POST['duration'];
    // $gradLoad = $_POST['gradLoad'];
    // $code = $_POST['code'];
    // echo "lllllllllllllllll".$inst_id;
    include 'real-config.php';
    if(check_program($code) == false){
        if ($mysqli->query("UPDATE `programme` SET name = '" . $name . "',category = '" . $category . "',duration =  '" . $duration . "',gradLoad =   '" . $gradLoad . "',code =  '" . $code . "' WHERE programmeID = '" . $id . "'")) {
            msg_success('Operation Successful', 'Programme Updated');
        } else {
            msg_error('Operation Failed', 'An Error Occured');
            echo $mysqli->error;
        }
    }else{
        msg_error('Operation Failed', 'This Code exists');
        echo $mysqli->error;        
    }
}
function insert_course() {
    $name = $_POST['cname'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $credits = $_POST['credit_units'];
    $code = $_POST['code'];
    $programme = $_POST['programmeID'];
    // echo "lllllllllllllllll".$inst_id;
    include 'real-config.php';
    if (check_course($code) == true) {
        if ($mysqli->query("INSERT INTO `courseunit` (`name`, `semesterOffered`,`yearOffered`, `creditUnits`,`courseunitCode`,`programme_programmeID`) VALUES (
        '" . $name . "',
        '" . $semester . "',
        '" . $year . "',
        '" . $credits . "',
        '" . $code . "',
        '" . $programme . "'
        );")) {
            msg_success('Operation Successful', 'Courseunit Added');
        } else {
            msg_error('Operation Failed', 'An Error Occured');
            echo $mysqli->error;
        }
    } else {
        msg_error('Operation Failed', 'A Courseunit with this code (' . $code . ') already exists');
    }
}
function update_course($id) {
    $name = $_POST['cname'];
    $semester = $_POST['semester'];
    $year = $_POST['year'];
    $credits = $_POST['credit_units'];
    $code = $_POST['code'];
    $programme = $_POST['programmeID'];
    // echo "lllllllllllllllll".$inst_id;
    include 'real-config.php';
    if ($mysqli->query("UPDATE `courseunit` SET 
  name =   '" . $name . "',
    semesterOffered = '" . $semester . "',
    yearOffered =  '" . $year . "',
    creditUnits =   '" . $credits . "',
    courseunitCode =  '" . $code . "',
    programme_programmeID =  '" . $programme . "'
    WHERE courseunitID = '" . $id . "'")) {
            msg_success('Operation Successful', 'Course Unit Updated');
        } else {
            msg_error('Operation Failed', 'An Error Occured');
            echo $mysqli->error;
        }
    }
function update_student($id) {
    include_once '../config/login/login-func.php';
    //Biodata
    $rand = rand(1000, 20000);
    $studentNo = $_POST['student_no'];
    $admissionNo = $_POST['admission_no'];
    $reg_no = $_POST['reg_no'];
   // echo $reg_no;
    $sname = $_POST['sname'];
  //  echo $sname;
    $fname = $_POST['fname'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $religion = $_POST['religion'];
    $student_type = $_POST['student_type'];
    $marital_status = $_POST['marital_status'];
    $residence = $_POST['residence'];
    $date = $_POST['date'];
    $phoneno = $_POST['phoneno'];
    $email = $_POST['email'];
    $hall = $_POST['hall'];
    $dob = $_POST['dob'];
    $entry_scheme = $_POST['entry_scheme'];

    $program = $_POST['program'];
    $dateAdmission = $_POST['dateAdmission'];
    $academicYearEntry = $_POST['academicYearEntry'];
    $gradDate = $_POST['gradDate'];

    $fname = $_POST['fname'];
    $fcareer = $_POST['fcareer'];
    $faddress = $_POST['faddress'];
    $ftelno = $_POST['ftelno'];
    $femail = $_POST['femail'];

    $mname = $_POST['mname'];
    $mcareer = $_POST['mcareer'];
    $maddress = $_POST['maddress'];
    $mtelno = $_POST['mtelno'];
    $memail = $_POST['memail'];

    $gname = $_POST['gname'];
    $gcareer = $_POST['gcareer'];
    $gaddress = $_POST['gaddress'];
    $gtelno = $_POST['gtelno'];
    $gemail = $_POST['gemail'];

    $nname = $_POST['nname'];
    $ncareer = $_POST['ncareer'];
    $naddress = $_POST['naddress'];
    $ntelno = $_POST['ntelno'];
    $nemail = $_POST['nemail'];

    $olevelsch = $_POST['olevelsch'];
    $olevelyr = $_POST['olevelyr'];
    $olevelindex = $_POST['olevelindex'];

    $sopt1 = $_POST['sopt1'];
    $sopt2 = $_POST['sopt2'];
    $sopt3 = $_POST['sopt3'];

    $gopt1 = $_POST['gopt1'];
    $gopt2 = $_POST['gopt2'];
    $gopt3 = $_POST['gopt3'];

    $alevelsch = $_POST['alevelsch'];
    $alevelyr = $_POST['alevelyr'];
    $alevelindex = $_POST['alevelindex'];

    $formerInst = $_POST['formerInst'];
    $formerQual = $_POST['formerQual'];
    $formerCourse = $_POST['formerCourse'];
    $formerRegNo = $_POST['formerRegNo'];

    $medicalProblemDesc = $_POST['medicalProblemDesc'];
    
    if (isset($_FILES['imagePic'])) {
        $errors = array();
        $file_name = $_FILES['imagePic']['name'];
        $file_size = $_FILES['imagePic']['size'];
        $file_tmp = $_FILES['imagePic']['tmp_name'];
        $file_type = $_FILES['imagePic']['type'];
        $extensions = array("jpeg", "jpg", "png");
        if ($file_type != 'image/jpeg') {
            $errors = "extension not allowed, please choose a JPEG or PNG file.";
            echo $errors;
        }
        if ($file_size > 2097152) {
            $errors[] = 'File size must be excately 2 MB';
            echo $errors;
        }
        $date = date('Hms');
        $newFilename = trim($fullName . '.jpg');
        echo $newFilename;
        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "../dist/img/stdphotos/" . $newFilename);
        } else {
            echo "Image Upload Failed. Please Try Again";
        }
    }
    /************inserting data*******************/
    /**START  TRANSACTION **/
    include 'real-config.php';
    mysqli_autocommit($mysqli, FALSE);
    //Queries to execute
 
    $username = getfield('username',$mysqli);
    $studentbio_query = $mysqli->query("UPDATE `student` SET `surname` = '$sname', `firstName` = '$fname', `gender` = '$gender', `maritalStatus` = '$marital_status', `photo` = '$newFilename', `dob` = '$dob', `nationality` = '$nationality', `hallOfResidence` = '$hall', `religion` = '$religion', `notes` = '', `medicalProblem` = '', `medicalInformation` = '$medicalProblemDesc', `telNo` = '$phone1', `address` = '', `yearOfStudy` = '$year', `placeOfResidence` = '$residence', `email` = '$email', `academicyearEntry` = '$academicYearEntry', `dateOfAdmission` = '$dateAdmission', `gradDate` = '$gradDate', `entryScheme` = '$entry_scheme', `dateofcompletion` = '', `program` = '$program', `status` = '$student_type', `uceSchool` = '$olevelsch', `uaceSchool` = '$alevelindex', `uceAggregates` = '', `uacePoints` = '', `formerInstitution` = '$formerInst', `formerQualification` = '$formerQual', `formerYearCourse` = '$formerCourse', `formerRegNo` = '$formerRegNo', `promotionalStatus` = '', `courseDuration` = '', `reason` = '', `uceIndex` = '$olevelindex', `uaceIndex` = '$alevelindex', `institutionReg` = '', `yearOfCourse` = '', `yearOfUace` = '$alevelindex', `yearOfUCE` = '$olevelyr', `sponsorshipType` = '', `enteredOn` = '', `enteredBy` = '$username', `updatedOn` = '', `updatedBy` = '' WHERE `student`.`id` = '$id'");

    /*$get_stdno = mysqli_query($mysqli,"SELECT id FROM student WHERE studentNo = '".$studentNo."' ");
    $row = mysqli_fetch_array($get_stdno);
    $stdno = $row['id'];
    $father_query = $mysqli->query("UPDATE `parent` SET `firstname` = '$fname', `address` = '$faddress', `telno1` = '$ftelno', `telno2` = '$ftelno', `alive` = '', `career` = '$fcareer', `email` = '$femail',  WHERE `parent`.`type` = 'father' AND `parent`.`student_studentID` = '$id;");
    $mother_query = $mysqli->query("INSERT INTO `parent` (`parentID`, `type`, `surname`, `firstname`, `address`, `telno1`, `telno2`, `alive`, `career`, `email`, `studentID`, `student_studentID`) VALUES (NULL, 'mother', '" . $mname . "', NULL, '" . $maddress . "', '" . $mtelno . "', NULL, NULL, '" . $mcareer . "', '" . $memail . "', NULL, '" . $stdno . "')");
    $guardian_query = $mysqli->query("INSERT INTO `parent` (`parentID`, `type`, `surname`, `firstname`, `address`, `telno1`, `telno2`, `alive`, `career`, `email`, `studentID`, `student_studentID`) VALUES (NULL, 'guardian', '" . $gname . "', NULL, '" . $gaddress . "', '" . $gtelno . "', NULL, NULL, '" . $gcareer . "', '" . $gemail . "', NULL, '" . $stdno . "')");
    $nok_query = $mysqli->query("INSERT INTO `parent` (`parentID`, `type`, `surname`, `firstname`, `address`, `telno1`, `telno2`, `alive`, `career`, `email`, `studentID`, `student_studentID`) VALUES (NULL, 'nok', '" . $nname . "', NULL, '" . $naddress . "', '" . $ntelno . "', NULL, NULL, '" . $ncareer . "', '" . $nemail . "', NULL, '" . $stdno . "')");
    */
    $i = 1;
    while($i<11){
        $uceid = $_POST[''.$i.'uceid'];
        $subject_val1 = $_POST[''.$i.'s'];
        $grade_val1  = $_POST[''.$i.'g'];
        $uce_query = $mysqli->query("UPDATE `uceresults` SET `subject` = '$subject_val1', `result` = '$grade_val1' WHERE `student_studentID` = '$id' AND id = '$uceid'");
    $i++;
    }
    if($uce_query){
        echo "yes";
    }else{
        echo $mysqli->error;
    }
  //  $uce_opt1_query = $mysqli->query("INSERT INTO `uceresults` (`id`, `subject`, `result`, `student_studentID`) VALUES (NULL, '".$sopt1."', '".$gopt1."', '".$stdno."');");
    //$uce_opt2_query = $mysqli->query("INSERT INTO `uceresults` (`id`, `subject`, `result`, `student_studentID`) VALUES (NULL, '".$sopt2."', '".$gopt2."', '".$stdno."');");
  //  $uce_opt3_query = $mysqli->query("INSERT INTO `uceresults` (`id`, `subject`, `result`, `student_studentID`) VALUES (NULL, '".$sopt3."', '".$gopt3."', '".$stdno."');");

   $x = 1;
  
    while($x<6){
        $uaceid = $_POST[''.$x.'uaceid'];
        $subject_val = $_POST[''.$x.'as'];
        $grade_val = $_POST[''.$x.'ag'];
        $uace_query = $mysqli->query("UPDATE `uace_results` SET `subject` = '$subject_val', `result` = '$grade_val' WHERE `student_studentID` = '$id' AND id = '$uaceid'");
    $x++;
    }
   
    if ($studentbio_query && $uace_query && $uce_query) {
        //Commiting Trasaction Onsucccess
        mysqli_commit($mysqli);
        mysqli_close($mysqli);
        msg_success('Operation Successful', 'Student Added');
        header('http://localhost:9090/sims/pages/dash.php?view_student='.$id);
    } else {
        //Rollback Trasaction OnFail
        mysqli_rollback($mysqli);
        msg_error('Operation Failed', 'An Error Occured (TU5001)');
        echo $mysqli->error;
    }
}

/* pull a particular program data */
function programData($id){
    include 'real-config.php';

    $query= "SELECT * FROM programme  WHERE programmeID = '".$id."'";
    $query_run= mysqli_query($mysqli, $query);
    $row = mysqli_fetch_array($query_run);
    if($row){
        echo json_encode($row);
    }else{
        msg_error('Operation Failed', 'An Error Occured');
    }
}

/* delete a programme */
function delete_programme($id){
    include 'real-config.php';

    $query= "DELETE FROM `programme` WHERE programmeID = '".$id."'";
    $query_run = mysqli_query($mysqli, $query);
    if($query_run){
        msg_success('Operation Successful', 'Programme deleted');
    }else{
        msg_error('Operation Failed', 'An Error Occured');
    }
}

/* Check for a college */
function check_college($shortname,$fullname) {
    include 'real-config.php';
    $query = "SELECT * FROM college WHERE fullname = '".$fullname."' and shortname = '".$shortname."'";
    $query_run = mysqli_query($mysqli, $query);
    if (!$query_run) {
        echo "Query Run Error" . mysqli_error($mysqli);
    } else {
        $num_of_rows = mysqli_num_rows($query_run);
        if ($num_of_rows == 1) {
            return true;
        } else {
            return false;
        }
    }
}

/* Inserting a College */
function insert_college($shortname,$fullname){
    include 'real-config.php';
    if (check_college($shortname,$fullname) == false) {
        if ($mysqli->query("INSERT INTO `college` (`fullname`, `shortname`) VALUES ('" . $fullname . "','" . $shortname . "');")) {
            msg_success('Operation Successful', 'College Added');
        } else {
            msg_error('Operation Failed', 'An Error Occured');
            echo $mysqli->error;
        }
    } else {
        msg_error('Operation Failed', 'This College Exists');
    }
}

/* pull a particular college data */
function collegeData($id){
    include 'real-config.php';

    $query= "SELECT * FROM college  WHERE collegeId = '".$id."'";
    $query_run= mysqli_query($mysqli, $query);
    $row = mysqli_fetch_array($query_run);
    if($row){
        echo json_encode($row);
    }else{
        msg_error('Operation Failed', 'An Error Occured');
    }
}

/* Update a particular college data */
function update_college($id,$shortname,$fullname){
    include 'real-config.php';
    if(check_college($shortname,$fullname) == false){
        if ($mysqli->query("UPDATE `college` SET fullname = '".$fullname."',shortname = '".$shortname."' WHERE collegeId = '" . $id . "'")) {
            msg_success('Operation Successful', 'Programme Updated');
        } else {
            msg_error('Operation Failed', 'An Error Occured');
            echo $mysqli->error;
        }
    }else{
        msg_error('Operation Failed', 'This College exists');
        echo $mysqli->error;        
    }
}

/* delete a College */
function delete_college($id){
    include 'real-config.php';

    $query= "DELETE FROM `college` WHERE collegeId = '".$id."'";
    $query_run = mysqli_query($mysqli, $query);
    if($query_run){
        msg_success('Operation Successful', 'College deleted');
    }else{
        msg_error('Operation Failed', 'An Error Occured');
    }
}