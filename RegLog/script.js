function checkemail(url){
	let usermail = document.getElementById("email").value;
	return fetch(url, {
	method: "post",
		headers: { "Content-type": "application/x-www-form-urlencoded" },
		body: "email=" +usermail,
	}).then(function (response){
		if(response.status !== 200){
			return;
		}
		return response.text();
	}).then(function (result){
		console.log(result);
		if(result == "E-mail already used, try a different one"){
			document.getElementById("emailerror").innerHTML = result;
		} else if(result == "Check e-mail format"){
			document.getElementById("emailerror").innerHTML = result;
		} else{
			document.getElementById("emailerror").innerHTML = "";
		}
	});
}