<?php 
    function redirect_to($new_Location){
        header("Location: " . $new_Location);
        exit;
    }

    function mysql_prep($string) {
        global $dbconn;

        $escaped_string = mysqli_real_escape_string($dbconn, $string);
        return $escaped_string;
    }

    function confirm_query($result_set) {
        if (!$result_set) {
                die("Database query failed.");
        }
    }

    function disease_dropdown_list( $diseases=[] ) {
        $result = "<option value=\"default\">Select disease</option>";
        $temp = "";

        if ( !empty($diseases) ){
            foreach($diseases as $disease) {
                $result .= "<option id=\"disease_id\" value=\"{$disease["disease_id"]}\">{$disease["disease_name"]}</option>";
            }
        }
        $temp = $result;
        $result = "";
        return $temp;
    }

    function disease_info( $disease=[] ) {
//
//Declare return variable
//         
        $result = "";
//
//Check that disease is not an empty object
//        
        if( !empty($disease) ) {
//           
//Initiate variables and break string into array respectively
//
            $subjective = explode("," , $disease["subjective"]);
            $objective = explode("," , $disease["objective"]);
            $icd_codes = explode("," , $disease["icd_codes"]);
            $labs = explode("," , $disease["labs"]);
            $diagnostics = explode("," , $disease["diagnostics"]);
            $referral = explode("," , $disease["referral"]);
            $medication = explode("," , $disease["medication"]);
            $patient_ed = $disease["patient_ed"];
            $follow_up = $disease["follow_up"];
//
//Display selected disease name
//            
            $result .= "<h1>{$disease["disease_name"]}</h1>";
            $result .= "<br>";
//
//Create table w/headers
//             
            $result .= "<div class=\"table-responsive\">";
            $result .= "<table class=\"table table-bordered\">";
            $result .= "<th>Subjective</th>";
            $result .= "<th>Objective</th>";
            $result .= "<th>ICD-Codes</th>";
            $result .= "<th>Labs</th>";
            $result .= "<th>Diagnostics</th>";
            $result .= "<th>Referral</th>";
            $result .= "<th>Medication</th>";
            $result .= "<th>Patient-Ed</th>";
            $result .= "<th>Follow-up</th>";
            $result .= "<tr>";
//
//SUBJECTIVE
//
            $result .= "<td>";
            $result .= "<ul class=\"list-group\">";
            foreach($subjective as $value){
                $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
            }
            $result .= "</ul>";
            $result .= "</td>";
//
//OBJECTIVE
//            
            $result .= "<td>";
            $result .= "<ul class=\"list-group\">";
            foreach($objective as $value){
                $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
            }
            $result .= "</ul>";
            $result .= "</td>";
//
//ICD CODES
//
            $result .= "<td>";
            $result .= "<ul class=\"list-group\">";
            foreach($icd_codes as $value){
                $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
            }
            $result .= "</ul>";
            $result .= "</td>"; 
//
//LABS
//            
            $result .= "<td>";
            $result .= "<ul class=\"list-group\">";
            foreach($labs as $value){
                $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
            }
            $result .= "</ul>";
            $result .= "</td>";
//
//DIAGNOSTICS
//            
            $result .= "<td>";
            $result .= "<ul class=\"list-group\">";
            foreach($diagnostics as $value){
                $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
            }
            $result .= "</ul>";
            $result .= "</td>";
//
//REFERRAL
//            
            $result .= "<td>";
            $result .= "<ul class=\"list-group\">";
            foreach($referral as $value){
                $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
            }
            $result .= "</ul>";
            $result .= "</td>";
//
//MEDICATION
//            
            $result .= "<td>";
            $result .= "<ul class=\"list-group\">";
            foreach($medication as $value){
                $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
            }
            $result .= "</ul>";
            $result .= "</td>";
//
//PATIENT EDUCATION
//            
            $result .= "<td>";
            $result .= "<ul class=\"list-group\">";
                $result .= "<li class=\"list-group-item\">" . $patient_ed . "</li><br>";
            $result .= "</ul>";
            $result .= "</td>";
//
//FOLLOW-UP
//            
            $result .= "<td>";
            $result .= "<ul class=\"list-group\">";
                $result .= "<li class=\"list-group-item\">" . $follow_up . "</li><br>";
            $result .= "</ul>";
            $result .= "</td>";
//
//END OF TABLE
//            
            $result .= "</tr>";
            $result .= "</table>";
            $result .= "</div>";
            
            return $result;
        }
        
    }
    
    function create_disease($body_system, $disease_name, $subjective, $objective, $icd_codes, $labs, 
            $diagnostics, $referral, $medication, $patient_ed, $follow_up) {
        global $dbconn;
        
        $safe_body_system = mysql_prep($body_system);
        $safe_disease_name = mysql_prep($disease_name);
        $safe_subjective = mysql_prep($subjective);
        $safe_objective = mysql_prep($objective);
        $safe_icd_codes = mysql_prep($icd_codes);
        $safe_labs = mysql_prep($labs);
        $safe_diagnostics = mysql_prep($diagnostics);
        $safe_referral = mysql_prep($referral);
        $safe_medication = mysql_prep($medication);
        $safe_patient_ed = mysql_prep($patient_ed);
        $safe_follow_up = mysql_prep($follow_up);
        
        $query  = "INSERT INTO diseases (";
        $query .= "disease_name, subjective, objective, icd_codes, labs, ";
        $query .= "diagnostics, referral, medication, patient_ed, follow_up";
        $query .= ") VALUES (";
        $query .= "'{$safe_disease_name}','{$safe_subjective}','{$safe_objective}','{$safe_icd_codes}','{$safe_labs}',";
        $query .= "'{$safe_diagnostics}','{$safe_referral}','{$safe_medication}','{$safe_patient_ed}','{$safe_follow_up}'";
        $query .= ")";
        
        $result = mysqli_query($dbconn, $query);
        
        //Disease insert success
        if( $result ){
            //Combo insert success
            if ( addCombo( mysqli_insert_id($dbconn), $body_system) ) {
                return true;
            //Combo insert failed    
            }else{
                return false;
            }
        //Disease insert failed    
        } else {
            return false;
        }
        
    }
    
    function edit_disease($disease_id, $disease_name, $subjective, $objective, $icd_codes, $labs, 
            $diagnostics, $referral, $medication, $patient_ed, $follow_up) {
        
        global $dbconn;
        
        $safe_body_system = mysql_prep($body_system);
        $safe_disease_name = mysql_prep($disease_name);
        $safe_subjective = mysql_prep($subjective);
        $safe_objective = mysql_prep($objective);
        $safe_icd_codes = mysql_prep($icd_codes);
        $safe_labs = mysql_prep($labs);
        $safe_diagnostics = mysql_prep($diagnostics);
        $safe_referral = mysql_prep($referral);
        $safe_medication = mysql_prep($medication);
        $safe_patient_ed = mysql_prep($patient_ed);
        $safe_follow_up = mysql_prep($follow_up);
        
        $query  = "UPDATE diseases ";
        $query .= "SET disease_name='{$safe_disease_name}', ";
        $query .= "subjective='{$safe_subjective}', ";
        $query .= "objective='{$safe_objective}', ";
        $query .= "icd_codes='{$safe_icd_codes}', ";
        $query .= "labs='{$safe_labs}', ";
        $query .= "diagnostics='{$safe_diagnostics}', ";
        $query .= "referral='{$safe_referral}', ";
        $query .= "medication='{$safe_medication}', ";
        $query .= "patient_ed='{$safe_patient_ed}', ";
        $query .= "follow_up='{$safe_follow_up}' ";
        $query .= "WHERE disease_id='{$disease_id}'";
        
        
        $result = mysqli_query($dbconn, $query);
        
        //Disease update success
        if( $result ){
                return true;
        //Disease update failed    
        } else {
            return false;
        }
        
    }
    
    function addCombo($disease_id, $system_id){
        global $dbconn;
        
        $query = "INSERT INTO disease_by_system (";
        $query .= "disease_id, system_id";
        $query .= ") VALUES (";
        $query .= "'{$disease_id}','{$system_id}'";
        $query .= ")";
        
        $result = mysqli_query($dbconn, $query);
        
        if( $result ){
            return true;
        } else {
            return false;
        }
    }
    
    function form_errors( $errors=[] ) {
        $result = "";

        if (!empty($errors)) {

                $result .= "<div class=\"alert alert-danger\">";
                foreach ($errors as $key => $error){
                        $result .= "{$error}<br>";
                }
                $result .= "</div>";
        }
        return $result;
    }
    
    function form_success( $success=[] ) {
        $result = "";

        if (!empty($success)) {

                $result .= "<div class=\"alert alert-success\">";
                foreach ($success as $value){
                        $result .= "{$value}<br>";
                }
                $result .= "</div>";
        }
        return $result;
    }

    function find_user_by_email($email) {
        global $dbconn;

        //Escape all user input
        $safe_email = mysql_prep($email);

        $query  = "SELECT user_id, username, password, email, admin ";
        $query .= "FROM users ";
        $query .= "WHERE email = '{$safe_email}' ";
        $query .= "LIMIT 1";
        $user_set = mysqli_query($dbconn, $query);
        confirm_query($user_set);
        if($user = mysqli_fetch_assoc($user_set)) {
            mysqli_free_result($user_set);
            mysqli_close($dbconn);
            return $user;
        } else {
            mysqli_free_result($user_set);
            return false;
        }
    }

    function find_diseases($bodySystem) {
        global $dbconn;

        //Escape any queries
        $safe_bs = mysql_prep($bodySystem);

        $query  = "SELECT disease.disease_name, disease.disease_id ";
        $query .= "FROM diseases AS disease ";
        $query .= "JOIN disease_by_system AS by_system ";
        $query .= "ON disease.disease_id = by_system.disease_id ";
        $query .= "WHERE by_system.system_id = '{$safe_bs}' ";
        
        $disease_set = mysqli_query($dbconn, $query);

        if( $disease_names = mysqli_fetch_all($disease_set, MYSQLI_ASSOC) ) {
            mysqli_free_result($disease_set);
            mysqli_close($dbconn);
            return $disease_names;
        } else {
            mysqli_free_result($disease_set);
            return false;
        }
    }
    
    function find_disease_by_id($disease_id) {
        global $dbconn;

        //Escape any queries
        $safe_id = mysql_prep($disease_id);

        $query  = "SELECT disease_name, subjective, objective, icd_codes, labs, diagnostics, referral, medication, patient_ed, follow_up ";
        $query .= "FROM diseases ";
        $query .= "WHERE disease_id = '{$safe_id}' ";
        
        $disease_set = mysqli_query($dbconn, $query);

        if( $disease_info = mysqli_fetch_assoc($disease_set) ) {
            mysqli_free_result($disease_set);
            mysqli_close($dbconn);
            return $disease_info;
        } else {
            mysqli_free_result($disease_set);
            return false;
        }
    }
    
    function find_disease_by_id_json($disease_id) {
        global $dbconn;

        //Escape any queries
        $safe_id = mysql_prep($disease_id);

        $query  = "SELECT disease_id, disease_name, subjective, objective, icd_codes, labs, diagnostics, referral, medication, patient_ed, follow_up ";
        $query .= "FROM diseases ";
        $query .= "WHERE disease_id = '{$safe_id}' ";
        
        $disease_set = mysqli_query($dbconn, $query);

        if( $disease_info = mysqli_fetch_assoc($disease_set) ) {
            mysqli_free_result($disease_set);
            mysqli_close($dbconn);
            return json_encode($disease_info);
        } else {
            mysqli_free_result($disease_set);
            return false;
        }
    }

    function register_user($username, $email, $password){
        global $dbconn;

        //Escape all user input
        $safe_username = mysql_prep($username);
        $safe_email = mysql_prep($email);
        $safe_password = mysql_prep($password);
        $encrypted_password = encrypt_password($safe_password);

        $query  = "INSERT INTO users (";
        $query .= "  username, password, email";
        $query .= ") VALUES (";
        $query .= "  '{$safe_username}', '{$encrypted_password}', '{$safe_email}'";
        $query .= ")";
        $result = mysqli_query($dbconn, $query);

        if($result){
                return true;
        } else {
                return false;
        }
    }

    function encrypt_password($password){
        //Encrypt password
        $hash_format = "$2y$10$";
        $salt_length = 22;
        $salt = generate_salt($salt_length);
        $format_and_salt = $hash_format . $salt;

        $hash = crypt($password, $format_and_salt);
        return $hash;
    }

    function generate_salt($length){

        //MD5 returns 32 characters
        $random_string = md5(uniqid(mt_rand(), true));

        //Valid chars for salt [a-zA-Z0-9./]
        $base64_string = base64_encode($random_string);

        //Replace + from base64 encoding with something valid
        $modified_base64_string = str_replace('+', '.', $base64_string);

        //Truncate string to 22 chars for salt
        $salt = substr($modified_base64_string, 0, $length);

        return $salt;

    }

    function password_check($password, $existing_hash) {

        $hash = crypt($password, $existing_hash);

        if ($hash === $existing_hash) {
                return true;
        } else {
                return false;
        }
    }

    function attempt_login($email, $password) {
        
        $safe_email = mysql_prep($email);
        $safe_password = mysql_prep($password);
            
        $user = find_user_by_email($safe_email);
        if($user){
                //Found user. Check password.
                if(password_check($safe_password, $user["password"])) {
                        //password matches
                        return $user;
                } else {
                        //password does not match
                        return false;
                }
        } else {
                return false;
        }
    }

    function attempt_registration($username, $email, $password) {

        $safe_username = mysql_prep($username);
        $safe_email = mysql_prep($email);
        $safe_password = mysql_prep($password);
                
        $user = find_user_by_email($email);

        if(!$user){
                //No user found by email
                if( register_user($safe_username, $safe_email, $safe_password) ) {
                        //success
                        return true;
                } else {
                        //something went wrong
                        return false;
                }
        } else {
                //Email exist in database
                return false;
        }
    }
?>