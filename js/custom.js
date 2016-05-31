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
    FB.api('/me', function(userInfo){
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
//$("registrationEmail").focusout(function (){
//    $.ajax({
//        url: "includes/check_email.php",
//        type: "POST"
//    }).always(function (data) {
//        
//    });
//});

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
 * dynamically sent to PHP using URL parameters I.e '?q='
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
                    console.log(key + " " + value); 
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
    } else {
        //creating a disease
        $.post(
            "includes/create_disease.php",
            formData
        ).success(function () {
            if(successString != "") {
                $("#successMsg").remove();
                successString = "";
                successString += formatSuccess("Successfully created disease.");
                $("#newDiseaseLbl").after(successString);
                getDiseasesNew( $("#newBodySystem").val() );
            } else {
                successString += formatSuccess("Successfully created disease.");
                $("#newDiseaseLbl").after(successString);
                getDiseasesNew( $("#newBodySystem").val() );
            }
        }).fail(function (){
            if(failString != "") {
                $("#errorMsg").remove();
                failString = "";
                failString += formatError("Error: Creation unsuccessful.");
                $("#newDiseaseLbl").after(failString);
            } else {
                failString += formatError("Error: Creation unsuccessful.");
                $("#newDiseaseLbl").after(failString);
            }
        });
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
        if(successString != "") {
            $("#successMsg").remove();
            successString = "";
            successString += formatSuccess("Successfully edited disease.");
            $("#newDiseaseLbl").after(successString);
            getDiseasesNew( $("#newBodySystem").val() );
        } else {
            successString += formatSuccess("Successfully edited disease.");
            $("#newDiseaseLbl").after(successString);
            getDiseasesNew( $("#newBodySystem").val() );
        }
    }).fail(function () {
        if(failString != "") {
            $("#errorMsg").remove();
            failString = "";
            failString += formatError("Error: Edit unsuccessful.");
            $("#newDiseaseLbl").after(failString);
        } else {
            failString += formatError("Error: Edit unsuccessful.");
            $("#newDiseaseLbl").after(failString);
        }
    });
}
/*******************************************************************************
 *  Accepts one parameter to be the contents of the alert div. Formatted
 *  string is returned   
 ******************************************************************************/
function formatSuccess(message){
    var temp = "<div class=\"alert alert-success\" id=\"successMsg\">";
    temp += message;
    temp += "</div>";
    
    return temp;
}
function formatError(message){
    var temp = "<div class=\"alert alert-danger\" id=\"errorMsg\">";
    temp += message;
    temp += "</div>";
    
    return temp;
}
/*******************************************************************************
 *  Called when the user clicks the logout link from the dropdown menu in the nav.
 *  User's logged_in SESSION value is unset, which automatically redirects user
 *  to login.php due to page authorization.   
 ******************************************************************************/
$("#logout").click(function(e){
    $.ajax({
        url: "includes/logout.php",
        type: "POST"
    });
});