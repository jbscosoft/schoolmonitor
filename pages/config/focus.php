<?php
function  msg_error($msgHeader,$msgContent){
    echo "<div class='alert alert-danger alert-dismissible'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <h4>$msgHeader</h4>
    <p>$msgContent</p>
    </div>";
}
function  msg_success($msgHeader,$msgContent){
    echo "<div class='alert alert-success alert-dismissible'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <h4>$msgHeader</h4>
    <p>$msgContent</p>
    </div>";
}
function new_institution($institute_name,$username, $password, $email, $phone_no,$key){
    include_once 'config/real-config.php';
    //inserting | Institute Details 
    if($stmt = $mysqli->prepare("INSERT INTO institute (institute_name,pro_key)VALUES (?,?)")){
        $stmt->bind_param("ss", $institute_name,$key);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
            if ($inst = $mysqli->prepare("SELECT id, institute_name FROM institute WHERE institute_name = ? LIMIT 1")) {
                $inst->bind_param('s',$institute_name);  // Bind "$username" to parameter.   // Execute the prepared query.
                if($inst->execute()){
                    return true;
                }else{
                    return false;
                }
                $inst->store_result();
            //inserting | Super User Details
                $inst->bind_result($id, $institute_name);
                $inst->fetch();
                    if ($inst->num_rows == 1) {
                       // $query = ;
                       // $query->bind_param("ssssi", $username,$password,$email,$phone1,$id);
                        if($mysqli->query("INSERT INTO users (username,dwp,email,phone1,institute_instituteID)VALUES ('$username','$password','$email','$phone1','$id')")){
                          return true;
                        }else{
                          return false;
                        }
                       // echo "User Insert yes";
                    }else{
                        return false;
                    }
                   // echo "Select ID yes";
                }else{
                    return false;
                }
               // echo "Insert  yes";
    }else{
        return false;
    }       
}