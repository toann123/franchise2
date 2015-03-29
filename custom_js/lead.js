function validate_lead() {
	var isvalid = true;
	//validate contact

	if ($("#fname").val().length <= 0) {
		isvalid = false;
		$("#fname").addClass("form-error");
	} else {
		$("#fname").removeClass("form-error");
	}

	if ($("#lname").val().length <= 0) {
		isvalid = false;
		$("#lname").addClass("form-error");
	} else {
		$("#lname").removeClass("form-error");
	}

	if ($("#mobile").val().length <= 0) {
		isvalid = false;
		$("#mobile").addClass("form-error");
	} else if (ValidateMobNumber($("#mobile").val()) == false) {
		isvalid = false;
		$("#mobile").addClass("form-error");
	} else {
		$("#mobile").removeClass("form-error");
	}

	if ($("#email").val().length <= 0) {
		isvalid = false;
		$("#email").addClass("form-error");
	} else if (validateEmail($("#email").val()) == false) {
		isvalid = false;
		$("#email").addClass("form-error");
	} else {
		$("#email").removeClass("form-error");
	}

	if ($("#address").val().length <= 0) {
		isvalid = false;
		$("#address").addClass("form-error");
	} else {
		$("#address").removeClass("form-error");
	}

	if ($("#suburb").val().length <= 0) {
		isvalid = false;
		$("#suburb").addClass("form-error");
	} else {
		$("#suburb").removeClass("form-error");
	}

	if ($("#postcode").val().length <= 0) {
		isvalid = false;
		$("#postcode").addClass("form-error");
	} else if(validate_postcode($("#postcode").val()) == false){
		isvalid = false;
		$("#postcode").addClass("form-error");
	}
    else {
		$("#postcode").removeClass("form-error");
	}

	if ($("#service_code").val() == 0) {
		isvalid = false;
		$("#service_code").addClass("form-error");
	} else {
		$("#service_code").removeClass("form-error");
	}
	
	if ($("#price").val() == 0) {
		isvalid = false;
		$("#price").addClass("form-error");
	} else if(isFloat($("#price").val()) == false){
		isvalid = false;
		$("#price").addClass("form-error");
	} 
	else {
		$("#price").removeClass("form-error");
	}

	return isvalid;
}

function isFloat(val) {
    var floatRegex = /^-?\d+(?:[.,]\d*?)?$/;
    if (!floatRegex.test(val))
        return false;

    val = parseFloat(val);
    if (isNaN(val))
        return false;
    return true;
}

function ValidateMobNumber(num) {
	if (num == "") {
		return false;
	} else if (isNaN(num)) {
		alert("The phone number contains illegal characters.");
		
		return false;
	} else if (!(num.length == 10)) {
		alert("The phone number is the wrong length. \nPlease enter 10 digit mobile no.");
		
		return false;
	}

}

function validate_postcode(num) {
	if (num == "") {
		return false;
	} else if (isNaN(num)) {
		alert("The post code contains illegal characters.");
		
		return false;
	} else if (!(num.length >= 4)) {
		alert("The postcode is the wrong length. \nPlease enter at least 4 digits.");
		
		return false;
	}

}

function validateEmail(email) {
	var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	return re.test(email);
}

function submit_addlead() {
	if (validate_lead()) {
		var fname = $("#fname").val();
		var lname = $("#lname").val();
		var company_name = $("#company_name").val();
		var phone = $("#phone").val();
		var mobile = $("#mobile").val();
		var email = $("#email").val();
		var address = $("#address").val();
		var suburb = $("#suburb").val();
		var postcode = $("#postcode").val();
		var state = $("#state").val();
		var city = $("#city").val();
		var service_code = $("#service_code").val();
		var price = $("#price").val();
		var note = $("#note").val();

		var url = "php/controller/addlead.php";
		var param = "?fname=" + fname + "&lname=" + lname + "&company_name=" + company_name + "&phone=" + phone + "&mobile=" +mobile+ "&email=" + email + "&address=" + address + "&suburb=" + suburb + "&postcode=" + postcode + "&state=" + state + "&city=" + city + "&service_code=" + service_code + "&price=" + price + "&note=" + note;
		$.ajax({
			url : url + param,
			success : function(data) {
				if (data == 1) {
					window.location = "";
				} else {
					alert("fail");
				}
			}
		});
	}

}
