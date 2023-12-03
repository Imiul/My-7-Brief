<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_bancaire";

$cnx = new mysqli($servername, $username, $password, $database);



// $password2 = password_hash('admin', PASSWORD_BCRYPT);

// $address = "
//         INSERT INTO address (ville, quartier, rue, code_postal,email, telephone)
//         VALUES  ('safi', 'centre Ville', '5', '25000', 'aymen@gmail.com', 0658365874);
//     ";
// $delete_existing = "DELETE FROM user WHERE username = 'amine_admin';";
// $cnx->query($delete_existing);

// $admin = "
//         INSERT INTO user (username, password, address_id, role_id)
//         VALUES  ('amine_admin', '$password2', 1, 'Admin');
//     ";


// // $cnx->query($address);
// // $cnx->query($admin);


?>