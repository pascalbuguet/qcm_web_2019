<?php
/*
 * ConnexionTest.php
 */
require_once 'Connexion.php';

$lcnx = seConnecter("../conf/locale.ini");

echo "<br><pre>";
var_dump($lcnx);
echo "</pre><br>";

seDeconnecter($lcnx);
?>