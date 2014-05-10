function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Je email is fout.")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Je email is fout.")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
			alert("Je email is fout.")
			return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
			alert("Je email is fout.")
			return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
			alert("Je email is fout.")
			return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
			alert("Je email is fout.")
			return false
		 }
		
		 if (str.indexOf(" ")!=-1){
			alert("Je email is fout.")
			return false
		 }

		 return true					
	}

function ValidateForm(){
	var email=document.form1.email
	var gebruikersnaam=document.form1.gebruikersnaam
	var wachtwoord=document.form1.wachtwoord
	var wachtwoordh=document.form1.wachtwoordh
	var opvraagwoord=document.form1.opvraagwoord
	
	/// Checken of de velden zijn ingevult ///
	if (gebruikersnaam.value==""){
		alert("je gebruikersnaam is leeg");
		gebruikersnaam.focus()
		return false
	}	
	if (wachtwoord.value==""){
		alert("Je wachtwoord is leeg");
		wachtwoord.focus()
		return false
	}	
	if (wachtwoordh.value==""){
		alert("Je wachtwoord herhalen is leeg");
		wachtwoordh.focus()
		return false
	}		
	if (opvraagwoord.value==""){
		alert("Je opvraagwoord is leeg");
		opvraagwoord.focus()
		return false
	}
	if (email.value==""){
		alert("Je email is leeg");
		email.focus()
		return false
	}
	if (wachtwoord.value != wachtwoordh.value) {
		alert("De wachtwoorden komen niet overeen");
		wachtwoord.focus()
		return false
	}
	if (echeck(email.value)==false){
		email.value=""
		email.focus()
		return false
	}
	return true
 }