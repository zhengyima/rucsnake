function doUpload() {
	var formData = new FormData($("#uploadform")[0]);  
	var userid = $("#userid")[0].value;
	$.ajax({  
		url: "do_upload.php",
		type: "POST",
		data: formData,
		async: false,
		cache: false,  
		contentType: false,
		processData: false,
		success: function (returndata) {  
			alert(returndata);
		},  
		error: function (returndata) {  
			alert("error: ", + returndata);  
		}
	});

}