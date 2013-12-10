function userPasswordReset(id){

	if(confirm("Är du säker på att du vill återställa lösenordet för denna användare?")){
		window.location.href = 'functions.php?function=resetUserPassword&id=' + id ;
	}
}