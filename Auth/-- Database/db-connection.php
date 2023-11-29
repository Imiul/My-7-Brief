<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "gestion_bancaire";

    $cnx = new mysqli($servername, $username, $password, $database);



    $address = "
        INSERT INTO address (ville, quartier, rue, code_postal, email, telephone)
        VALUES  ('safi', 'sanya', '5', '25000', 'amineelkarroudi@gmail.com', 0648414362);
    ";

    $admin = "
        INSERT INTO user (username, password, address_id)
        VALUES  ('amineelkarroudi', 'Amiine_elk123', 1);
    ";


    // $cnx->query($address);
    // $cnx->query($admin);


?>