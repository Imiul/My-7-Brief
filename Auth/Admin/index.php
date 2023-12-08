<?php
session_start();
include('../-- DATABASE/db-connection.php');

if (!isset($_SESSION['name']) || $_SESSION['user_type'] != "Admin") {
    header("Location: ../Login.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
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
    <title>Dashboard</title>
</head>
<body>

    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="">

                <div class="hidden md:block">
                    <div class=" flex items-baseline space-x-4">
                    <a href="#" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Home</a>
                    <a href="Data/bank.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Bank's</a>
                    <a href="Data/Agencies.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Agency's</a>
                    <a href="Data/Atm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Distrubuteur's</a>
                    <a href="Data/Roles.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Role's</a>
                    <a href="Data/Users.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">User's</a>
                    <a href="Data/Addresses.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Address's</a>
                    <a href="Data/Accounts.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Account's</a>
                    <a href="Data/Transactions.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Transaction's</a>
                    <a href="Data/Permition.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Permition's</a>    
                </div>
                </div>
                </div>
                <div class="hidden md:block">

                <div class="ml-4 flex items-center md:ml-6">
                    <!-- <button >Log Out</button> -->
                    <form method="post" style="display: flex; align-items: center;">
                        
                        <button style="color: red;" name="logout" type="submit">Log Out</button>
                    </form>
                </div>

                </div>
                
            </div>
            </div>

            
        </nav>


    

        <!-- PAGE CONTENT ===================== -->
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <!-- Your content -->
                <div>
                    <?php
                        echo "<h2 class='text-xl  mt-20 border[3px] border-gray-700  px-8 py-10 bg-gray-200'>Welcome To Your Dashboard <strong><u>" . $_SESSION["name"] . "</u>, You Are An <u>" . $_SESSION["user_type"]." </u> !</strong> </h2>";
                    ?>
                </div>
            </div>

        </main>
    </div>


    <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <h2 class="text-xl py-4">Your Information :</h2>
                        <table class="min-w-full text-left text-sm font-light" >
                        <thead class="border-b font-medium dark:border-neutral-500  border-2 border-gray-600 bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Username</th>
                                <th scope="col" class="px-6 py-4">Role</th>
                                <th scope="col" class="px-6 py-4">Ville</th>
                                <th scope="col" class="px-6 py-4">Quartier</th>
                                <th scope="col" class="px-6 py-4">rue</th>
                                <th scope="col" class="px-6 py-4">code postal</th>
                                <th scope="col" class="px-6 py-4">email</th>
                                <th scope="col" class="px-6 py-4">phone</th>
                            </tr>
                        </thead>
                        <tbody class=" border-2 border-gray-600">

                        <?php

                            $user_name = $_SESSION['name'];
                            $userInfo = "
                                SELECT * FROM user WHERE username = '$user_name';
                            ";

                            $run_userInfo = mysqli_query($cnx, $userInfo);

                            foreach($run_userInfo as $info) {
                                echo "<tr >";
                                echo "<th scope='col' class='px-6 py-4'>" . $info['id'] ."</th>";
                                echo "<th scope='col' class='px-6 py-4'>" . $info['username'] ."</th>";
                                echo "<th scope='col' class='px-6 py-4'>" . $info['role_id'] ."</th>";

                                $addresseInfo = "
                                    SELECT * FROM address WHERE id = '" . $info['address_id'] . "';
                                ";

                                $run_addresseInfo = mysqli_query($cnx, $addresseInfo);

                                foreach($run_addresseInfo as $address) {
                                    echo "<th scope='col' class='px-6 py-4'>" . $address['ville'] ."</th>";
                                    echo "<th scope='col' class='px-6 py-4'>" . $address['quartier'] ."</th>";
                                    echo "<th scope='col' class='px-6 py-4'>" . $address['rue'] ."</th>";
                                    echo "<th scope='col' class='px-6 py-4'>" . $address['code_postal'] ."</th>";
                                    echo "<th scope='col' class='px-6 py-4'>" . $address['email'] ."</th>";
                                    echo "<th scope='col' class='px-6 py-4'>" . $address['telephone'] ."</th>";
                                }

                                echo "</tr>";
                            }

                        ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </main>

</body>
</html>