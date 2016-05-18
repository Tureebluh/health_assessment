/*******************************************************************************
 * Declare GLOBAL variables
 ******************************************************************************/
var getDiseasesCount = 0;
var getDiseaseInfoCount = 0;

/*******************************************************************************
 * Perform AJAX request to dynamically populate disease drop down
 ******************************************************************************/
function getDiseases(bodySystem) {
    
    $.ajax({
        url: "includes/diseases.php?q=" + bodySystem,
        type: "GET",
    }).always(function (data) {
        if (getDiseasesCount < 1) {
            $("#ddPanel").append(data);
            getDiseasesCount++;
        } else {
            $(".diseasesDD").empty();
            $("#ddPanel").append(data);
            console.log(data);
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