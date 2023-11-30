<?php

include('-- Database/db-connection.php');

if (isset($_POST['resetPassword'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];


    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "<script>window.alert('Inputs Should Not Be Empty !');</script>";
    } else if ($confirmPassword != $password) {
        echo "<script>window.alert('Password Not Confirmed !');</script>";
    } else {

        $query = "SELECT * FROM user WHERE username = '$username' ";
        $run_query = mysqli_query($cnx, $query);

        if ($run_query) {
            if (mysqli_num_rows($run_query) > 0 ) {

                $user_row = mysqli_fetch_assoc($run_query);

                $find_ad_email = "SELECT * FROM address WHERE id = " . $user_row['address_id'] . "";
                $run_find_ad_email = mysqli_query($cnx, $find_ad_email);

                if (mysqli_num_rows($run_find_ad_email) > 0) {
                    $address_row = mysqli_fetch_assoc($run_find_ad_email);
                    if ($email == $address_row['email']) {
                        
                        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                        $update_password_query = "
                            UPDATE user 
                            SET password = '$hashed_password'
                            WHERE id = " . $user_row['id'] ."
                        ";

                        $run_update_password_query = mysqli_query($cnx, $update_password_query);

                        echo "<script>window.alert('Password Reset Succesffully!');</script>";
                        header("Location: Login.php");

                    } else {
                        echo "<script>window.alert('Invalid Email Address!');</script>";
                    }
                } 
            } else {
                echo "<script>window.alert('Usernme Invalid !');</script>";
            }
        }

    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Reset Password Page</title>
</head>
<body>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Reset Your Password</h2>
        </div>

        <form method="post" class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

            <input name="username" type="text" placeholder="Username" class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <div class="errorMessage px-4 mt-2 bg-red-600 text-white rounded mb-4"></div>

            <input name="email" type="email" placeholder="email" class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <div class="errorMessage px-4 mt-2 bg-red-600 text-white rounded mb-4"></div>
            
            <input name="password" type="password" placeholder="Password" class="px-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <div class="errorMessage px-4 mt-2 bg-red-600 text-white rounded  mb-4"></div>

            <input name="confirmPassword" type="password" placeholder="confirm Password" class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <div class="errorMessage px-4 mt-2 bg-red-600 text-white rounded mb-8"></div>

            <button type="submit" name="resetPassword" class="flex w-full justify-center rounded-md bg-gray-800 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Reset Password</button>
            <p class="w-full text-center mt-4 mb-2"><a href="Login.php"><u>Return To Login ?</u></a></p>
        </form>
    </div>


    <!-- SCRIPT -->
    <script>
        
    </script>

</body>
</html>