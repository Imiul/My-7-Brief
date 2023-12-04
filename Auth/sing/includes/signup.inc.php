<?php
session_start();

if (isset($_POST["signup-submit"])) {
    require "../../-- Database/db-connection.php";

    $username = $_POST["username"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $ville = $_POST["ville"];
    $quartier = $_POST["quartier"];
    $rue = $_POST["rue"];
    $code_postal = $_POST["code_postal"];
    $password = $_POST["passwordUser"];
    $repeatedPassword = $_POST["password-repeat"];

    // Validate and sanitize user input
    if (empty($username) || empty($email) || empty($password) || empty($repeatedPassword) || empty($telephone) || empty($ville) || empty($quartier) || empty($rue) || empty($code_postal)) {
        header("Location: ../signup.php?error=emptyfields&uid=" . $username . "&email=" . $email . "&telephone=" . $telephone . "&ville=" . $ville . "&quartier=" . $quartier . "&rue=" . $rue . "&code_postal=" . $code_postal);
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidemail&uid=" . $username . "&telephone=" . $telephone . "&ville=" . $ville . "&quartier=" . $quartier . "&rue=" . $rue . "&code_postal=" . $code_postal);
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invaliduid&email=" . $email . "&telephone=" . $telephone . "&ville=" . $ville . "&quartier=" . $quartier . "&rue=" . $rue . "&code_postal=" . $code_postal);
        exit();
    } elseif ($password !== $repeatedPassword) {
        header("Location: ../signup.php?error=passwordcheck&uid=" . $username . "&email=" . $email . "&telephone=" . $telephone . "&ville=" . $ville . "&quartier=" . $quartier . "&rue=" . $rue . "&code_postal=" . $code_postal);
        exit();
    }

    // Existing code for inserting user data into the database
    $hashedpdw = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username already exists
    $check_username_sql = "SELECT * FROM user WHERE username = ?";
    $check_username_stmt = mysqli_stmt_init($cnx);

    if (!mysqli_stmt_prepare($check_username_stmt, $check_username_sql)) {
        header("Location: ../signup.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($check_username_stmt, "s", $username);
    mysqli_stmt_execute($check_username_stmt);
    mysqli_stmt_store_result($check_username_stmt);

    if (mysqli_stmt_num_rows($check_username_stmt) > 0) {
        header("Location: ../signup.php?error=usernameexists&email=" . $email . "&telephone=" . $telephone . "&ville=" . $ville . "&quartier=" . $quartier . "&rue=" . $rue . "&code_postal=" . $code_postal);
        exit();
    }

    // Insert address data into the 'address' table
    $address_sql = "INSERT INTO address (ville, quartier, rue, code_postal, email, telephone) VALUES (?,?,?,?,?,?)";
    $address_stmt = mysqli_stmt_init($cnx);

    if (!mysqli_stmt_prepare($address_stmt, $address_sql)) {
        header("Location: ../signup.php?error=sqlerror&uid=" . $username . "&email=" . $email . "&telephone=" . $telephone . "&ville=" . $ville . "&quartier=" . $quartier . "&rue=" . $rue . "&code_postal=" . $code_postal);
        exit();
    }

    mysqli_stmt_bind_param($address_stmt, "ssssss", $ville, $quartier, $rue, $code_postal, $email, $telephone);
    mysqli_stmt_execute($address_stmt);


    // Get the last inserted ID from the address table
    $user_id = mysqli_insert_id($cnx);

    // Insert user data into the 'user' table
    $user_sql = "INSERT INTO user (username, password, role_id , address_id) VALUES (?,?, 'User', '$user_id')";
    $user_stmt = mysqli_stmt_init($cnx);

    if (!mysqli_stmt_prepare($user_stmt, $user_sql)) {
        header("Location: ../signup.php?error=sqlerror&uid=" . $username . "&email=" . $email . "&telephone=" . $telephone . "&ville=" . $ville . "&quartier=" . $quartier . "&rue=" . $rue . "&code_postal=" . $code_postal);
        exit();
    }

    mysqli_stmt_bind_param($user_stmt, "ss", $username, $hashedpdw);
    mysqli_stmt_execute($user_stmt);


    header("Location: ../signup.php?signup=success");
    exit();

} else {
    header("Location: ../signup.php?");
    exit();
}
?>