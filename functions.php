<?php

	/* function sum($x, $y) {
		$answer = $x+$y;
		return $answer;

	}		
	function hello($firstname, $lastname) {
		$answer1 = $firstname.$lastname;
		return "Tere tulemast "
		.$firstname
		." "
		.$lastname
		."!";
		
	}

$firstname = "Gittan";
$lastname = "Kaus";

	
echo sum(1234567, 12345678);
echo "<br>";
echo sum(2, 3);
echo "<br>";
echo hello($firstname, $lastname);

*/
//et saab kasutada $_SESSION muutujaid
//kõigis failides mis on sellega seotud
session_start();
$database = "if16_gittkaus_3";
//var_dump($GLOBALS);

	function signup($email, $password) {
			$notice = "";
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);	
			$stmt = $mysqli->prepare("INSERT INTO user_sample(email, password) VALUES (?, ?)");
			$stmt->bind_param("ss", $email, $password );
			if( $stmt->execute() ) {	
				echo "salvestamine õnnestus";
			} else {
				echo "ERROR ".$stmt->error;
			}
	}
	
	
	function login($email, $password) {
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
		
			SELECT id, email, password, created
			FROM user_sample
			WHERE email = ?
		
		");
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran muutujad reale mis kätte saan
		$stmt->bind_result($idDb, $emailDb, $passwordDb, $created);
		
		$stmt->execute();
		
		//ainult selecti puhul
		if ($stmt->fetch()) {
			
			//vähemalt 1 rida tuleb läbi
			$hash = hash("sha512", $password);
			if ($hash == $passwordDb) {	
				//õnnestus
				echo "Kasutaja".id."logis sisse";
				
				$_SESSION["user"] = $id;
				$_SESSION["userEmail"] = $emailDb;
				
				header("Location: data.php");
				
			} else {
				
				echo "Vale parool!";
				$notice =  "Vale parool!";
				
			}
			
		} else {
			//ei leitud ühtegi rida
			
			echo "Sellist emaili pole!";
			$notice = "Sellist emaili pole";
			
		}
		
		return $notice;
		
	}
?>