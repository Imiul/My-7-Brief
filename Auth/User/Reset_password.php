<?php

    session_start();
    include('../-- Database/db-connection.php');

    if (!$_SESSION['name'] || $_SESSION['user_type'] != "User") {
        header("Location: ../Login.php");
        exit();
    }

    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ../Login.php');
        exit();
    }


    if (isset($_POST['reset_password'])) {

        $user_name = $_SESSION['name'];
        $fetchdata = "SELECT * FROM user WHERE username = '$user_name'";
        $run_fetchdata = mysqli_query($cnx, $fetchdata);
        $row = mysqli_fetch_assoc($run_fetchdata);

        $password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        $update_query = "
            UPDATE user
            SET password = '$password'
            WHERE id = " . $row['id'] ."
        ";

        $run_update_query = mysqli_query($cnx, $update_query);

        session_unset();
        session_destroy();
        header('Location: ../Login.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <title>Transaction's</title>
</head>
<body>

<div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="">

                <div class="hidden md:block">
                    <div class=" flex items-baseline space-x-4">
                    <a href="Data.php"  class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium" >Your Personal Data</a>
                    <a href="my_transaction.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Transaction's</a>
                    <a href="Reset_password.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-mediumm">Reset Password</a>    
                </div>
                </div>
                </div>
                <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">

                    
                </div>
                </div>
                
                <div class="ml-4 flex items-center md:ml-6">
                    <!-- <button >Log Out</button> -->
                    <form method="post" style="display: flex; align-items: center;">
                        <?php
                        echo "<h3 style='color: white; margin-right: 30px;'> ( User Name : " . $_SESSION['name']. " )</h3>";
                        ?>
                        <button style="color: red;" name="logout" type="submit">Log Out</button>
                    </form>
                </div>
            </div>
            </div>

            
        </nav>



        <section class="mt-12 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 " >
            <!-- <h3 class="sm:px-20">Add A User</h3> -->
            <form method="post" class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <input name="new_password" type="text" placeholder="Your New Password" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                <button type="submit" name="reset_password" class="bg-gray-600 text-white text-xl rounded">Change Your Password</button>
            </form>
        </section>

    </div>


</body>
</html>





    
