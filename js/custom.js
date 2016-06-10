/*******************************************************************************
 * Declare GLOBAL variables
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

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

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
    if( $("#registrationEmail").val().indexOf("@") !== -1 ){
        if ( $("#registrationEmail").val().indexOf("@") !== $("#registrationEmail").val().length -1 ) {
            checkEmailExist();
        }
        displayError("Email address not valid.<br>Example: email@email.com", "#registrationHeader");
        registrationEmailError();
    } else {
        
        displayError("Email address not valid.<br>Example: email@email.com", "#registrationHeader");
        registrationEmailError();
    }  
});
$("#registrationPassword").focusout(function () {
    
});

function checkEmailExist() {
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
                } else {
                    //Email is not taken
                    $("#errorMsg").remove();
                    registrationEmailSuccess();
                }
            }
        });
    });
}
/*******************************************************************************
 * Perform AJAX request to dynamically populate disease drop down
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
 * Perform AJAX request to dynamically populate disease drop down
 ******************************************************************************/
function getDiseasesNew(bodySystem) {
    
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
                        console.log(key + " " + value);
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
 *  Accepts one parameter to be the contents of the alert div. Formatted
 *  string is returned   
 ******************************************************************************/
function displaySuccess(message, target){
    $("#errorMsg").remove();
    $("#successMsg").remove();

    successString = "<div class=\"alert alert-success\" id=\"successMsg\">";
    successString += message;
    successString += "</div>";
    $(target).after(successString);
}
function displayError(message, target){
    $("#errorMsg").remove();
    $("#successMsg").remove();

    failString = "<div class=\"alert alert-danger\" id=\"errorMsg\">";
    failString += message;
    failString += "</div>";
    $(target).after(failString);
}

function registrationEmailError(){
    $("#emailFormGroup").removeClass("has-success");
    $("#emailFormGroup").addClass("has-error");  
    $("#registrationEmail").css('color', 'red');
    $("#emailValidationSpan").removeClass("glyphicon-ok");
    $("#emailValidationSpan").addClass("glyphicon-remove");
}
function registrationEmailSuccess(){
    $("#emailFormGroup").removeClass("has-error");
    $("#emailFormGroup").addClass("has-success");
    $("#registrationEmail").css('color', 'green');
    $("#emailValidationSpan").removeClass("glyphicon-remove");
    $("#emailValidationSpan").addClass("glyphicon-ok");
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
        window.location.href = "index.php";
    });
});