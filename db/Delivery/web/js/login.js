$("#loginForm").submit(function(event) {
	var username = $("#inputUsername").val(); 
	var password = $("#inputPassword").val();
	$.getJSON("./AJAX/ajax_login.php?username="  +  username  +  "&password="  +  password,  function(result) {
		if (result.status == 'true') {
			$("#signIn").removeAttr("hidden");
			$("#continueUsername").text(username);
			$("#loginForm").hide();
			$("#loginAlert").hide();
		} else {
			$("#loginAlert").removeAttr("hidden");
			$("#loginErrorMessage").text(result.message);
		}
	});
	return false;
});