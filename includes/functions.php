<?php

//Redirects user and calls exit to stop data from being sent to user from request page
function redirect_to($new_Location){
    header("Location: " . $new_Location);
    exit();
}

//Takes passed in $string and calls mysqli_real_escape_string to protect against SQL inject
//Safe string is returned
function mysql_prep($string) {
    global $dbconn;

    $safe_string = mysqli_real_escape_string($dbconn, $string);
    return $safe_string;
}

//Check's to see if passed in $result_set returned anything
//If not, calls die which prints Database query failed. to console and exits the script.
function confirm_query($result_set) {
    if (!$result_set) {
            die("Database query failed.");
    }
}

//Creates data to be added to <select> dropdown from the associative $diseases[] array
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

//Could be optimized by passing raw variables to JavaScript to do processing.
//Will implement in the future
function disease_info( $disease=[] ) {

    //Declare return variable       
    $result = "";

    //Check that disease is not an empty object        
    if( !empty($disease) ) {       
        //Initiate variables and break string into array respectively
        $subjective = explode("," , $disease["subjective"]);
        $objective = explode("," , $disease["objective"]);
        $icd_codes = explode("," , $disease["icd_codes"]);
        $labs = explode("," , $disease["labs"]);
        $diagnostics = explode("," , $disease["diagnostics"]);
        $referral = explode("," , $disease["referral"]);
        $medication = explode("," , $disease["medication"]);
        $patient_ed = $disease["patient_ed"];
        $follow_up = $disease["follow_up"];

        //Display selected disease name           
        $result .= "<h1>{$disease["disease_name"]}</h1>";
        $result .= "<br>";

        //Create table w/headers
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

        //SUBJECTIVE
        $result .= "<td>";
        $result .= "<ul class=\"list-group\">";
        foreach($subjective as $value){
            $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
        }
        $result .= "</ul>";
        $result .= "</td>";

        //OBJECTIVE
        $result .= "<td>";
        $result .= "<ul class=\"list-group\">";
        foreach($objective as $value){
            $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
        }
        $result .= "</ul>";
        $result .= "</td>";

        //ICD CODES
        $result .= "<td>";
        $result .= "<ul class=\"list-group\">";
        foreach($icd_codes as $value){
            $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
        }
        $result .= "</ul>";
        $result .= "</td>"; 

        //LABS
        $result .= "<td>";
        $result .= "<ul class=\"list-group\">";
        foreach($labs as $value){
            $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
        }
        $result .= "</ul>";
        $result .= "</td>";

        //DIAGNOSTICS            
        $result .= "<td>";
        $result .= "<ul class=\"list-group\">";
        foreach($diagnostics as $value){
            $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
        }
        $result .= "</ul>";
        $result .= "</td>";

        //REFERRAL
        $result .= "<td>";
        $result .= "<ul class=\"list-group\">";
        foreach($referral as $value){
            $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
        }
        $result .= "</ul>";
        $result .= "</td>";

        //MEDICATION           
        $result .= "<td>";
        $result .= "<ul class=\"list-group\">";
        foreach($medication as $value){
            $result .= "<li class=\"list-group-item\">" . $value . "</li><br>";
        }
        $result .= "</ul>";
        $result .= "</td>";

        //PATIENT EDUCATION            
        $result .= "<td>";
        $result .= "<ul class=\"list-group\">";
            $result .= "<li class=\"list-group-item\">" . $patient_ed . "</li><br>";
        $result .= "</ul>";
        $result .= "</td>";

        //FOLLOW-UP            
        $result .= "<td>";
        $result .= "<ul class=\"list-group\">";
            $result .= "<li class=\"list-group-item\">" . $follow_up . "</li><br>";
        $result .= "</ul>";
        $result .= "</td>";

        //END OF TABLE            
        $result .= "</tr>";
        $result .= "</table>";
        $result .= "</div>";

        return $result;
    }
}

//Calls mysql_prep on all data to be input into database. If query is successful, addCombo
//is called, which grabs the ID of the last inserted row (mysqli_query($dbconn, $query)) and the $body_system selected
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

//Calls mysql_prep on all data to be input into database. If query is successful, return true, otherwise return false
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

//Inserts disease_id and system_id into disease_by_system table to create relationship between
//any given body system, and the diseases associated with it.
//Function is called from within create_disease, therefore $system_id does not need to be cleaned
//$disease_id is retrieved directly from database
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

//Calls mysql_prep on $email and retrieves data from database. mysqli_fetch_assoc is called on $user_set
//to create $user associative array. $user object is returned
function find_user_by_email($email) {
    global $dbconn;

    //Escape all user input
    $safe_email = mysql_prep($email);

    $query  = "SELECT user_id, password, email, admin ";
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

//Checks to see if email exist in database. Runs COUNT(1) which returns the total number of emails that match
//NOTE: COUNT(1) and COUNT(*) are essentially the same thing.
function email_exist($email){
    global $dbconn;

    //Escape all user input
    $safe_email = mysql_prep($email);

    $query  = "SELECT COUNT(1) ";
    $query .= "FROM users ";
    $query .= "WHERE email = '{$safe_email}' ";

    $result_set = mysqli_query($dbconn, $query);

    confirm_query($result_set);

    if($result = mysqli_fetch_assoc($result_set)) {
        mysqli_free_result($result_set);
        mysqli_close($dbconn);
        return json_encode($result);
    }
}

//Runs join query on diseases & disease_by_system table. Returns back disease name and ID
//where the bodySystem is equal to the $bodySystem selected by user. Disease ID is appended
//as the value for each <option> in the dropdown
//
//NOTE: mysqli_fetch_all(result_set, MYSQLI_ASSOC) must be used to retrieve multiple results
//      mysqli_fetch_assoc(result_set) only returns ONE result and would not be appropriate here.
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

//Returns all info associated with the disease selected by user.
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

//Returns all info associated with the disease selected by user and creates JavaScript object with data
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

//Hash format tells PHP what hashing algorithm to use, and how many times to iterate.
//salt_length MUST be 22 characters. Too much is better than too little. Crypt will trim off the rest
//Too little will result in a completely different hash
function encrypt_password($password){
    //Encrypt password
    $hash_format = "$2y$10$";
    $salt_length = 22;
    $salt = generate_salt($salt_length);
    $format_and_salt = $hash_format . $salt;

    $hash = crypt($password, $format_and_salt);
    return $hash;
}

//Creates salt using length passed in by encrypt_password
function generate_salt($length){

    //MD5 returns 32 characters
    $random_string = md5(uniqid(mt_rand(), true));

    //Valid chars for salt [a-zA-Z0-9./]
    $base64_string = base64_encode($random_string);

    //Replace '+' from base64 encoding with something valid '.'
    $modified_base64_string = str_replace('+', '.', $base64_string);

    //Truncate string to 22 chars for salt
    $salt = substr($modified_base64_string, 0, $length);

    return $salt;

}

//Password is stored in database with $salt added to beginning
//Crypt will only accept the first 22 characters in the $existing_hash
//and then trim off the rest (the users actual password)
//This allows us to run crypt on the users password being typed in, and then
//compared to our stored password.
//The users password is ALMOST random, ALMOST unique. (Nothing can be truly random)
function password_check($password, $existing_hash) {

    $hash = crypt($password, $existing_hash);

    if ($hash === $existing_hash) {
            return true;
    } else {
            return false;
    }
}

//Escape user input with mysqli_prep() and calls find_user_by_email which returns
//either true or false. If the email exist, the password is checked. If the password
//is valid, the user object is returned. Otherwise, returns false.
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

//Escape user input with mysql_prep and encrypt the $safe_password.
//Attempt to INSERT user into users table. If the query succeeds, return true, otherwise return false
function attempt_registration($email, $password) {
    global $dbconn;

    $safe_email = mysql_prep($email);
    $safe_password = mysql_prep($password);
    $encrypted_password = encrypt_password($safe_password);

    $query  = "INSERT INTO users (";
    $query .= "  password, email";
    $query .= ") VALUES (";
    $query .= "  '{$encrypted_password}', '{$safe_email}'";
    $query .= ")";
    $result = mysqli_query($dbconn, $query);

    if($result){
            return true;
    } else {
            return false;
    }
}

?>