<h1>Visa källkod</h1>

<?php
// Create the object to display sourcecode
$source = new CSource(array('secure_dir' => '..', 'base_dir' => '..'));

echo  "<h4>Utforskare:</h4>" . $source->View();
?>
