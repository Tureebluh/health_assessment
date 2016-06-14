/*******************************************************************************
 * Declare/initialize GLOBAL variables
 ******************************************************************************/
var getDiseasesCount = 0;
var getDiseasesNewCount = 0;
var getDiseaseInfoCount = 0;
var getDiseaseInfoNewCount = 0;
var formKeys = [];
var formData;
var successString = "";
var failString = "";
var email = "";
var displayErrorBool = false;
var displaySuccessBool = false;
var passwordLength = false;
var passwordLetter = false;
var passwordCapital = false;
var passwordNumber = false;
var passwordValidated = false;
var emailValidated = false;
var confirmPasswordValidated = false;
/*******************************************************************************
 * Functions required for Facebook Login
 ******************************************************************************/
function statusChangeCallback(response) {
    // Logged into app and Facebook.
    if (response.status === 'connected') {
        logInUser();
    }
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
}

window.fbAsyncInit = function() {
    FB.init({
      appId      : '528323244039374',
      xfbml      : true,
      version    : 'v2.6'
    });
};
//Code for downloading facebook SDK
(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

/*******************************************************************************
 * Perform AJAX request to set user email and logged_in variable
 * Redirect to search_diseases.php with JavaScript on success
 ******************************************************************************/
function logInUser(){
    FB.api('/me', {fields: 'email'}, function(userInfo){
        email = { email: userInfo.email };
        $.ajax({
            url: "includes/login.php",
            type: "POST",
            data: email
        }).success(function () {
            window.location.href = "search_diseases.php";
        });
    });
}
/*******************************************************************************
 * Perform AJAX request to check if email is in use after user exits field
 ******************************************************************************/
$("#registrationEmail").focusout(function (){
    //Returns the index of the character passed in, otherwise it returns -1
    //if value of email returns back something other than -1, it contains an @
    if( $("#registrationEmail").val().indexOf("@") !== -1 ){
        //if the index returned is equal to the length of the users email, it would not be a valid email
        //these are very basic validations because emails vary greatly. bootstrap offers built in validation
        //on top of this when the user tries to submit
        if ( $("#registrationEmail").val().indexOf("@") !== $("#registrationEmail").val().length -1 ) {
            checkEmailExist();
        } else {
            //displayError(message, target element);
            displayError("Email address not valid.<br>Example: email@email.com", "#registrationHeader");
            //indicates errors to users using the input field colors
            registrationEmailError();
            emailValidated = false;
        }
    } else {
        
        displayError("Email address not valid.<br>Example: email@email.com", "#registrationHeader");
        registrationEmailError();
        emailValidated = false;
    }  
});
/*******************************************************************************
 * Check if email exist when user exits email field using AJAX request.
 * JavaScript object is returned with a key of COUNT(1) and a value of 1, or 0.
 ******************************************************************************/
function checkEmailExist() {
    //Initialize email with value of email input
    var email = { email: $("#registrationEmail").val() };
    $.ajax({
        url: "includes/check_email.php",
        type: "POST",
        data: email,
        dataType: "json"
    }).always(function (data) {
        $.each(data, function(key, value){
            if(key === "COUNT(1)"){
                if(value === "1"){
                    //Email is taken
                    displayError("Email address already in use.<br><a href='index.php'>Back to login page?</a>", "#registrationHeader");
                    registrationEmailError();
                    emailValidated = false;
                } else {
                    //Email is not taken
                    $("#errorMsg").remove();
                    registrationEmailSuccess();
                    emailValidated = true;
                }
            }
        });
    });
}
/*******************************************************************************
 * Removes success indicators from email field and adds errors.
 ******************************************************************************/
function registrationEmailError(){
    $("#emailFormGroup").removeClass("has-success");
    $("#emailValidationSpan").removeClass("glyphicon-ok");
    $("#emailFormGroup").addClass("has-error");  
    $("#registrationEmail").css('color', '#a94442');
    $("#emailValidationSpan").addClass("glyphicon-remove");
}
/*******************************************************************************
 * Removes error indicators from email field and adds success.
 ******************************************************************************/
function registrationEmailSuccess(){
    $("#emailFormGroup").removeClass("has-error");
    $("#emailValidationSpan").removeClass("glyphicon-remove");
    $("#emailFormGroup").addClass("has-success");
    $("#registrationEmail").css('color', '#3c763d');
    $("#emailValidationSpan").addClass("glyphicon-ok");
}
/*******************************************************************************
 *                              Password functions
 ******************************************************************************/
//When user focuses into password field, show password requirements div
$("#registrationPassword").focusin(function (){
    $("#passwordRequirements").show();
//When user focuses out of password field, hide password requirements div    
}).focusout(function (){
    $("#passwordRequirements").hide();
//While user is typing password, run validation checks AFTER each key press    
}).keyup(function (){
    //$("#registrationPassword").val()
    var password = $(this).val();
    
    //Check password length
    if( password.length < 8 ){
        //Show error for LI and change validation variable to false
        registrationLiError("#length");
        passwordLength = false;
    } else {
        //Show success for LI and change validation variable to true
        registrationLiSuccess("#length");
        passwordLength = true;
    }
    //Check for at least one letter
    if( password.match(/[A-z]/) ){
        registrationLiSuccess("#letter");
        passwordLetter = true;
    } else {
        registrationLiError("#letter");
        passwordLetter = false;
    }
    //Check for at least one uppercase letter
    if( password.match(/[A-Z]/) ){
        registrationLiSuccess("#capital");
        passwordCapital = true;
    } else {
        registrationLiError("#capital");
        passwordCapital = false;
    }
    if( password.match(/[0-9]/) ){
        registrationLiSuccess("#number");
        passwordNumber = true;
    } else {
        registrationLiError("#number");
        passwordNumber = false;
    }
    if(passwordLength && passwordLetter && passwordCapital && passwordNumber) {
        registrationPasswordSuccess();
        passwordValidated = true;
    } else {
        registrationPasswordError();
        passwordValidated = false;
    }
});
/*******************************************************************************
 * Removes success indicators from password field and adds errors.
 ******************************************************************************/
function registrationPasswordError(){
    $("#passwordFormGroup").removeClass("has-success");
    $("#passwordValidationSpan").removeClass("glyphicon-ok");
    $("#passwordFormGroup").addClass("has-error");  
    $("#registrationPassword").css('color', '#a94442');
    $("#passwordRequirements").css('border-color', '#a94442');
    $("#upTriangle").css('color', '#a94442');
    $("#passwordValidationSpan").addClass("glyphicon-remove");
}
/*******************************************************************************
 * Removes error indicators from password field and adds success.
 ******************************************************************************/
function registrationPasswordSuccess(){
    $("#passwordFormGroup").removeClass("has-error");
    $("#passwordValidationSpan").removeClass("glyphicon-remove");
    $("#passwordFormGroup").addClass("has-success");
    $("#registrationPassword").css('color', '#3c763d');
    $("#passwordRequirements").css('border-color', '#3c763d');
    $("#upTriangle").css('color', '#3c763d');
    $("#passwordValidationSpan").addClass("glyphicon-ok");
}
//adds error indicators to target element (li)
function registrationLiError(target) {
    $(target).removeClass("glyphicon-ok").addClass("glyphicon-remove").css('color', '#a94442');
}
//adds success indicators to target element (li)
function registrationLiSuccess(target) {
    $(target).removeClass("glyphicon-remove").addClass("glyphicon-ok").css('color', '#3c763d');
}

$("#confirmPassword").keyup(function() {
    if( $("#confirmPassword").val() === $("#registrationPassword").val() ) {
        //The passwords match
        confirmPasswordSuccess();
        confirmPasswordValidated = true;
    } else {
        confirmPasswordError();
        confirmPasswordValidated = false;
    }
});

function attemptRegistration(){
    var data = { email: $("#registrationEmail").val(), password: $("#registrationPassword").val() };
    
    $.ajax({
        url: "includes/register.php",
        type: "POST",
        data: data,
        dataType: "text"
    }).always(function (data) {
        if(data === "1"){
            //successful
            displaySuccess("Account successfully created! Redirecting to login screen.", "#registrationHeader");
            setTimeout(redirectTo, 2500, "index.php");
        } else {
            //something went wrong
        }
    });
}
function checkValidation(){
    if(confirmPasswordValidated && passwordValidated && emailValidated){
         attemptRegistration();
     } else if (!passwordValidated){
         //User tried to submit with password validation failed
         $("#registrationPassword").focus();
     } else if (!emailValidated){
         //User tried to submit with email validation failed
         $("#registrationEmail").focus();
     } else {
         //User tried to submit with confirm password validation failed
         $("#confirmPassword").focus();
     } 
}
/*******************************************************************************
 * Removes success indicators from confirm password field and adds errors.
 ******************************************************************************/
function confirmPasswordError(){
    $("#confirmFormGroup").removeClass("has-success");
    $("#confirmValidationSpan").removeClass("glyphicon-ok");
    $("#confirmFormGroup").addClass("has-error");  
    $("#confirmPassword").css('color', '#a94442');
    $("#confirmValidationSpan").addClass("glyphicon-remove");
}
/*******************************************************************************
 * Removes error indicators from confirm password field and adds success.
 ******************************************************************************/
function confirmPasswordSuccess(){
    $("#confirmFormGroup").removeClass("has-error");
    $("#confirmValidationSpan").removeClass("glyphicon-remove");
    $("#confirmFormGroup").addClass("has-success");
    $("#confirmPassword").css('color', '#3c763d');
    $("#confirmValidationSpan").addClass("glyphicon-ok");
}
/*******************************************************************************
 * Perform AJAX request to dynamically populate disease drop down. Bodysystem is
 * sent as a URL parameter
 ******************************************************************************/
function getDiseases(bodySystem) {
    
    $.ajax({
        url: "includes/diseasesDD.php?q=" + bodySystem,
        type: "GET",
    }).always(function (data) {
        if (getDiseasesCount < 1) {
            $("#ddPanel").append(data);
            getDiseasesCount++;
        } else {
            $(".diseasesDD").empty();
            $("#ddPanel").append(data);
        }
    });
}
/*******************************************************************************
 * Perform AJAX request to dynamically populate disease drop down. Bodysystem is
 * sent as a URL parameter.
 ******************************************************************************/
function getDiseasesNew(bodySystem) {
    //resets button if user triggered form for edit
    if( $("#createDiseaseBtn").val() == "Edit Disease" ){
        $("#createDiseaseBtn").val("Create Disease");
        $("#newDiseaseLbl").text("Create New Disease");
    }
    
    $.ajax({
        url: "includes/diseasesDD_new.php?q=" + bodySystem,
        type: "GET",
    }).always(function (data) {
        if (getDiseasesNewCount < 1) {
            $("#newBodySystem").after(data);
            getDiseasesNewCount++;
        } else {
            $(".diseasesDD_new").empty();
            clearFormNew();
            $("#newBodySystem").after(data);
        }
        
    });
}
/*******************************************************************************
 * AJAX event handler for populating disease info from database. Information is
 * dynamically sent to PHP using URL parameters I.e '?q=1234'
 ******************************************************************************/
function getDiseaseInfo(bodySystem) {
    
    $.ajax({
        url: "includes/disease_assessment.php?q=" + bodySystem,
        type: "GET",
    }).always(function (data) {
        if (getDiseaseInfoCount < 1) {
            $("#contentPanel").append(data);
            getDiseaseInfoCount++;
        } else {
            $("#contentPanel").empty();
            $("#contentPanel").append(data);
        }
    });   
}
/*******************************************************************************
 * AJAX event handler for populating disease info from database. Information is
 * dynamically sent to PHP using URL parameters I.e '?q='
 * Data is returned as a JavaScript object and parsed
 ******************************************************************************/
function getDiseaseInfoNew(diseaseId) {
    
    if( $("#newDiseaseDD").val() !== "default" ) {
        $("#createDiseaseBtn").val("Edit Disease");
        $("#newDiseaseLbl").text("Edit Disease");
    } else {
        $("#createDiseaseBtn").val("Create Disease");
        $("#newDiseaseLbl").text("Create New Disease");
    }
    
    $.ajax({
        url: "includes/disease_assessment_new.php?q=" + diseaseId,
        type: "GET",
        dataType: "json"
    }).always(function (data) {
        if (getDiseaseInfoNewCount < 1) {
            $.each(data, function(key, value){
                if (key != "disease_id"){
                    $("#" + key).val(value);
                    formKeys.push(key); 
                }
            });
            getDiseaseInfoNewCount++;
        } else {
            clearFormNew();
            if( $("#newDiseaseDD").val() !== "default" ) {
                $.each(data, function(key, value){
                    if (key != "disease_id") {
                        $("#" + key).val(value);
                    }
                });
            }
        }
    });   
}
/*******************************************************************************
 *  Clear values from form fields.   
 ******************************************************************************/
function clearFormNew(){
    for(i = 0; i < formKeys.length; i++){
        $("#" + formKeys[i]).val("");
    } 
}

/*******************************************************************************
 * Function is called when user clicks the Submit button on the new_disease
 * page. A JavaScript object is created using the values in the form fields.
 * If the user has selected a disease from the dropdown, this function will call
 * editDisease(), otherwise it will pass the object to create_disease using an
 * AJAX request, and display the results to the user.
 ******************************************************************************/
function createDisease(){
    
    formData = {
        body_system: $("#newBodySystem").val(),
        disease_id: $("#newDiseaseDD").val(),
        disease_name: $("#disease_name").val(),
        subjective: $("#subjective").val(),
        objective: $("#objective").val(),
        icd_codes: $("#icd_codes").val(),
        labs: $("#labs").val(),
        diagnostics: $("#diagnostics").val(),
        referral: $("#referral").val(),
        medication: $("#medication").val(),
        patient_ed: $("#patient_ed").val(),
        follow_up: $("#follow_up").val()
    };
    
    if( $("#newDiseaseDD").val() !== "default" ) {
        //editing a disease
        editDisease();
    } else if ($("#disease_name").val() !== ""){
        //creating a disease
        $.post(
            "includes/create_disease.php",
            formData
        ).success(function () {
            displaySuccess("Successfully created disease.", "#newDiseaseLbl");
            getDiseasesNew( $("#newBodySystem").val() );
        }).fail(function (){
            displayError("Creation unsuccessful.", "#newDiseaseLbl");
        });
    } else {
        displayError("Creation unsuccessful. Disease name is required.", "#newDiseaseLbl");       
    }
}
/*******************************************************************************
 * This function is called when the user has selected a disease from the drop-down
 * list. The same JavaScript object created from createDisease() is passed to a 
 * different PHP file, edit_disease. The results of the AJAX request are displayed
 * to the user.
 ******************************************************************************/
function editDisease(){
    $.ajax({
        url: "includes/edit_disease.php",
        type: "POST",
        data: formData,
        cache: false
    }).success(function () {
        displaySuccess("Successfully edited disease.", "#newDiseaseLbl" );  
        getDiseasesNew( $("#newBodySystem").val() );
    }).fail(function () {
        displayError("Edit unsuccessful.", "#newDiseaseLbl");
    });
}

/*******************************************************************************
 *  Accepts two parameters. Message is to be the contents of the alert div.
 *  Target is the element the alert div should be placed AFTER  
 ******************************************************************************/
function displaySuccess(message, target){
    if(displaySuccessBool !== false){
       $("#successMsg").remove(); 
    }
    if(displayErrorBool !== false){
        $("#errorMsg").remove();
        displayErrorBool = false;
    }   

    successString = "<div class=\"alert alert-success\" id=\"successMsg\">";
    successString += message;
    successString += "</div>";
    $(target).after(successString);
    displaySuccessBool = true;
}
function displayError(message, target){
    if(displayErrorBool !== false){
        $("#errorMsg").remove();
    }
    if(displaySuccessBool !== false){
        $("#successMsg").remove();
        displaySuccessBool = false;
    }
    
    failString = "<div class=\"alert alert-danger\" id=\"errorMsg\">";
    failString += message;
    failString += "</div>";
    $(target).after(failString);
    displayErrorBool = true;
}

/*******************************************************************************
 *  Called when the user clicks the logout link from the dropdown menu in the nav.
 *  User's logged_in SESSION value is unset. Forced redirect with JS on successful
 *  logout.   
 ******************************************************************************/
$("#logout").click(function(){
    $.ajax({
        url: "includes/logout.php",
        type: "POST"
    }).success(function (){
        redirectTo("index.php");
    });
});

function redirectTo(path){
    window.location.href = "" + path;
}