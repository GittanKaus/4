<?php
	require("functions.php");

	//kas kasutaja tahab v�lja logida
	if(isset($_GET["logout"])) {
		
			session_destroy();
			
			header("Location: sisselog.php");
		
		
	}



?>



<h1>Data</h1>
<p>Tere tulemast <?=$_SESSION["userEmail"];?>!
<a href="?logout=1">Logiv�lja</a>
</p>