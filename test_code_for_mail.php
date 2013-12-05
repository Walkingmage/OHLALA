<?php 

$firstname = "firstname-test";
$lastname = "lastname-test";
$privemail = "privemail-test";
$telephone = "telephone-test";
$access = "access-test";
$username = "username-test";
$password = "password-test";
$jensenemail = "jensenemail-test";

require('mail_to_user.php');

//function takes one user as input and returns true if everything is OK.
//returns false if any input param is empty or if any input param becomes as a result of cleanUserInput
//prints mockup email to emails.html
if ( mailToUser($firstname, $lastname, $privemail, $telephone, $access, $jensenemail, $username) )
	echo "File written";
else {
	echo "Some field was empty after cleanup";
}

?>