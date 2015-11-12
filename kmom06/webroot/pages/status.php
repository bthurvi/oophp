<h1>Visar status:</h1>

<?php
//get singelton instance (this only allovs ONE user)
$user = CUser::Instance();

//connect to session and database
$user->Init($urbax['database']);

//get auth-info
$user->PrintAuthInfo();
?>



