<?php

    session_start();
    include('../-- Database/db-connection.php');

    if (!$_SESSION['name'] || $_SESSION['user_type'] != "User") {
        header("Location: ../Login.php");
        exit();
    }


    if (isset($_GET['rm'])) {
        $id_to_remove = $_GET['rm'];

        $run_delete = "DELETE FROM account WHERE id = $id_to_remove";
        $run_delete = mysqli_query($cnx, $run_delete);
        echo "<script>window.alert('Account Deleted Succesfully');</script>";
        header("Location: Data.php");
    }

    if (isset($_POST['logout'])) {
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
    <title>Account's</title>
</head>
<body>

<div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="">

                <div class="hidden md:block">
                    <div class=" flex items-baseline space-x-4">
                    <a href="Data.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Your Personal Data</a>
                    <a href="my_transaction.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Transaction's</a>
                    <a href="Reset_password.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Reset Password</a>
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



        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <h2 class="text-xl py-4">Your Personal Information :</h2>
                        <table class="min-w-full text-left text-sm font-light" >
                        <thead class="border-b font-medium dark:border-neutral-500  border-2 border-gray-600 bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Username</th>
                                <!-- <th scope="col" class="px-6 py-4">Role</th> -->
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

                            $find_username = "SELECT * FROM user WHERE username = '$user_name'";
                            $run_find_username = mysqli_query($cnx, $find_username);

                            foreach($run_find_username as $user) {
                                
                                echo "<tr>";
                                echo "<td scope='col' class='px-6 py-4'>" . $user['id'] . "</th>";
                                echo "<td scope='col' class='px-6 py-4'>" . $user['username'] . "</th>";
                                // echo "<td scope='col' class='px-6 py-4'>" . $user['role_id'] . "</th>";

                                $find_address = "SELECT * FROM address WHERE id = " . $user['address_id'] ."";
                                $run_find_address = mysqli_query($cnx, $find_address);

                                foreach($run_find_address as $addressInfo) {
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['ville'] . "</th>";
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['quartier'] . "</th>";
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['rue'] . "</th>";
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['code_postal'] . "</th>";
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['email'] . "</th>";
                                    echo "<td scope='col' class='px-6 py-4'>" . $addressInfo['telephone'] . "</th>";
                                }

                                echo "</tdscope=>";
                            }
                        ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
                            
            <h2 class="text-xl py-4 mt-8">Accounts Information :</h2>
            <table class="min-w-full  text-left text-sm font-light mb-12" >
                        <thead class="border-b font-medium dark:border-neutral-500  border-2 border-gray-600 bg-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-4">Account id</th>
                                <th scope="col" class="px-6 py-4">Rib</th>
                                <th scope="col" class="px-6 py-4">Devise</th>
                                <th scope="col" class="px-6 py-4">Balance</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody class=" border-2 border-gray-600">

                        <?php

                            $find_id = "SELECT id FROM user WHERE username = '$user_name'";
                            $run_find_id = mysqli_query($cnx, $find_id);
                            
                            foreach($run_find_id as $id) {
                                $find_this_id =  $id['id']; 
                            }

                            $find_accounts = "SELECT * FROM account WHERE user_id = $find_this_id";
                            $run_find_accounts = mysqli_query($cnx, $find_accounts);

                            foreach($run_find_accounts as $accounts_filtred) {
                                echo "<tr class='border-2 border-gray-600 ' >";
                                echo "<td scope='col' class='px-6 py-4'>" . $accounts_filtred['id'] . "</th>";
                                echo "<td scope='col' class='px-6 py-4'>" . $accounts_filtred['rib'] . "</th>";
                                echo "<td scope='col' class='px-6 py-4'>" . $accounts_filtred['devise'] . "</th>";
                                echo "<td scope='col' class='px-6 py-4'>" . $accounts_filtred['balance'] . "</th>";
                                echo "<td scope='col' class='px-6 py-4'>";
                                echo "<a href='Data.php?rm=" . $accounts_filtred['id'] . "' class='bg-red-600 py-2 px-8 text-white font-bold'>Remove</a>";
                                echo "</th>";
                                echo "</tr>";
                            }
                        ?>
                        </tbody>
                        </table>
            </div>
            </main>
    </div>


</body>
</html>





    
