<?php
if (isset($_POST["login-submit"])) {
    require "../db-connection.php";
    $userid = $_POST["userId"];
    $password = $_POST["password"];
    if (empty($userid) || empty($password)) {
        header("Location: ../index.php?error=emptyfields");
        exit();
    } else {
        $sql = "select * from users where userid = ? OR useremail = ? ";
        $stmt = mysqli_stmt_init($cnx);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $userid, $userid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
        
            if ($row) {
                $pwdCheck = password_verify($password, $row["passwordUser"]);
                if ($pwdCheck == false) {
                    header("Location: ../Login.php?error=nouser");
                    exit();
                } else if ($pwdCheck == true) {
                    
                    session_start();
                    $_SESSION["userid"] = $row["userid"];
                    $_SESSION["useremail"] = $row["useremail"];
                    header("Location: ../Login.php?login=success");
                    exit();
                } else {
                    header("Location: ../Login.php?error=nouser");
                    exit();
                }
            } else {
                header("Location: ../Login.php?error=nouser");
                exit();
            }
        }
    }
} else {
    header("Location: ../Login.php?");
    exit();
}
