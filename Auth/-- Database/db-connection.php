<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "my_7_brief";

$cnx = new mysqli($servername, $username, $password, $database);


$password = password_hash('AMIINE_elk123', PASSWORD_BCRYPT);
$query = "
    INSERT INTO `user` (`username`, `password`, `role_id`, `address_id`, `agence_id`)
    VALUES ('amine', '$password', 'ADMIN', 1, 1);
";
// $cnx->query($query);


?>