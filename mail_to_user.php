<?php

function cleanUserInput($userInput) {
	$badStuff = array('to:', 'cc:', 'bcc:', 'content-type:', 'mime-version:', 'multipart-mixed:', 'content-transfer-encoding:');
	foreach ($badStuff as $needle) {
		if ( stripos($userInput, $needle) !== false ) {
			return '';
		}
	}
	$userInput = str_replace( array('\r', '\n', '%0a', '%0d'), ' ', $userInput);
	return trim($userInput);
}

function mailToUser($firstname, $lastname, $privemail, $telephone, $access, $jensenemail, $username) {

	$firstname = cleanUserInput($firstname);
	$lastname = cleanUserInput($lastname);
	$privemail = cleanUserInput($privemail);
	$telephone = cleanUserInput($telephone);
	$access = cleanUserInput($access);
	$username = cleanUserInput($username);
	$jensenemail = cleanUserInput($jensenemail);

	$userInput = array($firstname, $lastname, $privemail, $telephone, $access, $jensenemail, $username);

	$emptyArrayElementExists = false;
	foreach ($userInput as $userInputString) {
		if ( empty($userInputString) ) {
			$emptyArrayElementExists = true;
		}
	}

	if (!$emptyArrayElementExists) {

		$to = $privemail;
		$subject = "Your user account at Jensen Education";


		$senderEmail = "no-reply@jenseneducation.se";
		$recieverName = $firstname." ".$lastname;
		$header = "From: ".$senderEmail;

		$body = "
		<p>Hej $recieverName!</p>
		<p>Ett emailkonto har skapats åt dig.</p>
		<p>Gå till domän.se och logga in</p>
		<p>Användarnamn: $username</p>
		<p>Din emailadress: $jensenemail</p>
		<p>Lösenordet får du av en Jensen-anställd.</p>
		";

		$body = wordwrap($body, 70);

		//Not implemented:
		//mail( $to, $subject, $body, $header);
		
		//Temp message to file:
		$emailContent = "
		<p>To: $to</p>
		<p>Subject: $subject</p>
		<p>Body: $body</p>
		<p>Header: $header</p>
		<p>--------</p>
		";

		//åäö funkar inte, orkar inte fixa
		$handle = fopen("emails.html", "a");
		fwrite($handle, utf8_encode($emailContent));
		fclose($handle);

		return true;
	} else {
		return false;
	}

}
?>