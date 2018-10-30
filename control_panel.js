var xmlhttp0;

function checkLoginStatus(){
	var url = "control_panel.php";
	url = url+"?call=checkLoginStatus";
    query(url, "main");
}divForms



function logout(){
	var url = "control_panel.php";
	url = url+"?call=logout";
    query(url, "main");
}

function divLabTestForm() {
	var url = "control_panel.php";
	url = url+"?call=divLabTestForm";
    query(url, "table");
}

function changeAccount() {
	var url = "control_panel.php";
	url = url+"?call=changeAccount";
    query(url, "main");
}




function donorAccount() {
	var url = "control_panel.php";
	url = url+"?call=donorAccount";
   	redirectPage(url, "donor.php");
}

function hositalAccount() {
	var url = "control_panel.php";
	url = url+"?call=hositalAccount";
    query(url, "main");
}

function requesterAccount() {
	var url = "control_panel.php";
	url = url+"?call=requesterAccount";
    query(url, "main");
}

function laboratoryAccount() {
	var url = "control_panel.php";
	url = url+"?call=labAccount";
    query(url, "main");	
}




function tablehospitalBooking() {
	var url = "control_panel.php";
	url = url+"?call=getTablehospitalBookings";
    query(url, "main-panel");	
}

function accountForm() {
	var url = "control_panel.php";
	url = url+"?call=accountForm";
	query(url, "accountForm");
}

function getDonorBookingForm() {
	var url = "control_panel.php";
	url = url+"?call=getDonorBookingForm";
	query(url, "main-panel");
}

function getTableDonorProfile(tableName, userId) {
	var url = "control_panel.php";
	url = url+"?call=getTableDonorProfile&tableName=" + tableName + "&userId=" + userId;
	query(url, "main-panel");
}

function donorBooking() {
	var hospId = document.getElementById('book_hosp').value;
	var time = document.getElementById('book_time').value;
	var date = document.getElementById('book_date').value;

	var url = "control_panel.php";
	url = url+"?call=donationBooking&hospId=" + hospId + "&time=" + time + "&date=" + date;
	query(url, "main");
}

function tableDonorBookings(tableName, userId) {
	var url = "control_panel.php";
	if (tableName == "getPendingTestsTable") {
		url = url+"?call=getPendingTestsTable";
	} else if (tableName == "getTestedLabTable") {
		url = url+"?call=getTestedLabTable";
	} else if (tableName == "getFlaggedLabTable") {
		url = url+"?call=getFlaggedLabTable";
	} else if (tableName == "getTestedLabTableUser") {
		url = url+"?call=getTestedLabTableUser";
	} else if (tableName == "getFlaggedLabTableUser") {
		url = url+"?call=getFlaggedLabTableUser";
	} else if (tableName == "getBloodLevels") {
		url = url+"?call=getBloodLevels";
	} else {
		url = url+"?call=tableDonorBookings&tableName=" + tableName + "&userId=" + userId;
	}
	query(url, "main-panel");
} 




function checkAdminPass() {
	var password = document.getElementById('admin_password').value;
	
	var url = "control_panel.php";
	url = url+"?call=checkAdminPass&pass=" + password;
    
    query(url, "main");
}

function login() {
	var email = document.getElementById('log_email').value;
	var password = document.getElementById('log_password').value;
	
	var url = "control_panel.php";
	url = url+"?call=login&email=" + email + "&pass=" + password;
    
    query(url, "main");
}

function labTestSubmit() {
	var labId = document.getElementById('lab_id').value;
	var donorEmail = document.getElementById('lab_don_email').value;
	var donNum = document.getElementById('lab_don_num').value;
	
	var url = "control_panel.php";
	url = url+"?call=labTestSubmit&labId=" + labId + "&donorEmail=" + donorEmail + "&donNum=" + donNum;
    
    query(url, "main");
}

function signup() {
	var email = document.getElementById('sign_email').value;
	var password = document.getElementById('sign_password').value;
	
	var url = "control_panel.php";
	url = url+"?call=signup&email=" + email + "&pass=" + password;
    
    query(url, "main");
}




function deleteRecord(id, tableName) {
	var url = "control_panel.php";
	url = url+"?call=deleteRecord&id=" + id + "&tableName=" + tableName;
    
    query(url, "main");
}

function updateRecord(id, tableName) {
	var name = document.getElementById('form_name').value;
	var contact = document.getElementById('form_phone').value;
	var address = document.getElementById('form_address').value;
	var email = document.getElementById('form_email').value;

	var url = "control_panel.php";
	url = url+"?call=updateRecord&id=" + id + "&tableName=" + tableName + 
	"&name=" + name + "&email=" + email + "&contact=" + contact + "&address=" + address;
    
    query(url, "main");
}

function labTestUpdateForm(id) {
	var url = "control_panel.php";
	url = url+"?call=labTestUpdateForm&id=" + id;
    
    query(url, "main-panel");
}

function updateLabTestRecord(id) {
	var bloodId = document.getElementById('lab_test_blood_type').value;
	var bloodStatus = document.getElementById('lab_test_blood_status').value;

	var url = "control_panel.php";
	url = url+"?call=updateLabTestRecord&id=" + id + "&bloodId=" + bloodId  + "&bloodStatus=" + bloodStatus;
    
    query(url, "main-panel");
}

function divRecordUpadte(id, tableName, name, email, contact, address) {
	var url = "control_panel.php";
	url = url+"?call=divRecordUpadte&id=" + id + "&tableName=" + tableName + 
	"&name=" + name + "&email=" + email + "&contact=" + contact + "&address=" + address;
    
    query(url, "main");
}

function getTableHospitals(tableName) {
	var url = "control_panel.php";
	if (tableName == "getBloodLevels") {
		url = url+"?call=getBloodLevels";
	} else {
		url = url+"?call=getTableHospitals&tableName=" + tableName;
    }
    query(url, "main-panel");
}




function registerUser() {
	var name = document.getElementById('reg_name').value;
	var surname = document.getElementById('reg_surname').value;
	var phone = document.getElementById('reg_phone').value;
	var city = document.getElementById('reg_city').value;
	var sex = document.getElementById('reg_sex').value;
	var dob = document.getElementById('reg_dob').value;
	var address = document.getElementById('reg_address').value;

	var url = "control_panel.php";
	url = url+"?call=registerUser&name=" + name + "&surname=" + surname + "&phone=" + phone + "&city=" + 
	city + "&sex=" + sex + "&dob=" + dob + "&address=" + address;
    
    query(url, "main");
}

function registerForm(str) {
	var name = document.getElementById('form_name').value;
	var phone = document.getElementById('form_phone').value;
	var address = document.getElementById('form_address').value;
	var email = document.getElementById('form_email').value;

	var url = "control_panel.php";
	url = url+"?call=registerForm&type=" + str + "&name=" + name + "&phone=" + phone + "&address=" + address + "&email=" + email;
    
    query(url, "main");
}

function acceptBooking(id, tableName) {
	var url = "control_panel.php";
	url = url+"?call=acceptBooking&id=" + id + "&tableName=" + tableName;
    query(url, "main");
}

function divForms(str) {
	var url = "control_panel.php";
	url = url+"?call=" + str;
    
    if (str == "getTablehospitalBookings") {
    	query(url, "table");
    } else if (str == "divLabTestForm" || str == "orderBloodForm" ||  str == "getBloodLevels") {
    	query(url, "table");
    } else if (str == "getTablelabTests" || str == "getTableHospitalOrders") {
    	query(url, "table");
    } else {
    	query(url, "main");
	}
}

function searchForBlood(str) {
	var hospId = document.getElementById('hosp_id').value;
	var bloodId = document.getElementById('blood_id').value;
	var units = document.getElementById('blood_units').value;

	var url = "control_panel.php";
	if (str == "searchForBlood") {
		url = url+"?call=searchForBlood&hospId=" + hospId + "&bloodId=" + bloodId + "&units=" + units;
	} else {
		url = url+"?call=orderBloodUnit&hospId=" + hospId + "&bloodId=" + bloodId + "&units=" + units;
	}
	
    query(url, "bloodSearch");
}




function divSignup() {
	var url = "control_panel.php";
	url = url+"?call=divSignup";
    query(url, "main");
}

function divLogin() {
	var url = "control_panel.php";
	url = url+"?call=divLogin";
    query(url, "main");
}

function query(url, div) {
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
		if (this.readyState==4 && this.status == 200) {
			document.getElementById(div).innerHTML= this.responseText;
		}
	}
    xmlhttp.open("POST", url, true);
    xmlhttp.send();	
}

function redirectPage(url, page) {
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			window.location = 'page';
			//document.getElementById(div).innerHTML= this.responseText;
		}
	}
    xmlhttp.open("POST", url, true);
    xmlhttp.send();	
}
 
