<?php


    session_start();
    if (!isset($_SESSION['name']) || $_SESSION['user_type'] != "Admin") {
        header("Location: ../../Login.php");
        exit;
    }

    include('../../-- Database/db-connection.php');


    if (isset($_POST['add_user'])) {
        
        $username = $_POST['UserName'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $address_id = $_POST['AddressId'];
        $userRole = $_POST['userRole'];

        if (empty($username) || empty($password) || empty($address_id)) {
            echo "<script>window.alert('Inputs Shuld Not Be Empty');</script>";
        } else {

            $query = "
            INSERT INTO user (username, password, role_id, address_id)
                VALUES ('$username', '$password', '$userRole', '$address_id')
            ";

            $run_query = mysqli_query($cnx, $query);
            echo "<script>window.alert('User Added Successfully');</script>";


        }
    }

    $fetchRoles = "SELECT * FROM role;";
    $rolesData = $cnx->query($fetchRoles);

    $fetchAddress = "SELECT * FROM address;";
    $addresesData = $cnx->query($fetchAddress);

    $fetchusers = "SELECT * FROM user;";
    $userData = $cnx->query($fetchusers);

    if (isset($_GET['rm'])) {

        $id_to_delete = $_GET['rm'];
        $delete_user = "DELETE FROM user WHERE id = $id_to_delete";

        $run_delete = mysqli_query($cnx, $delete_user);
        echo "<script>window.alert('User Deleted Successfully');</script>";
        header("Location: Users.php");
    }
    
    if (isset($_POST['logout'])) {
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header('Location: ../../Login.php');
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
                    <a href="../index.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium" >Home</a>
                    <a href="bank.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Bank's</a>
                    <a href="Agencies.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Agency's</a>
                    <a href="Atm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Distrubuteur's</a>
                    <a href="Roles.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Role's</a>
                    <a href="Users.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">User's</a>
                    <a href="Addresses.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Address's</a>
                    <a href="Accounts.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Account's</a>
                    <a href="Transactions.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Transaction's</a>
                    </div>
                </div>
                </div>

                <div class="hidden md:block">

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
            </div>
        </nav>


        <!-- PAGE CONTENT ===================== -->
        <section id="add" class="mt-20 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 " >
            <!-- <h3 class="sm:px-20">Add A User</h3> -->
            <form method="post" placeholder class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <input name="UserName" type="text" placeholder="User UserName" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="password" type="text" placeholder="Password" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                
                <select name="AddressId" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                    <option value="">select user address</option>
                    <?php
                        foreach($addresesData as $address) {
                            echo "<option value='" . $address['id'] . "' >". $address['id'] . " / " . $address['ville'] . " / " . $address['quartier'] . " / " . $address['rue'] .  " / " . $address['code_postal'] .  " / " . $address['email'] . " / " .    $address['telephone'] ."</option>";
                        }
                    ?>
                </select>

                <select name="userRole" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                    <option value="">Choose User Role</option>
                    <?php
                        foreach($rolesData as $role) {
                            echo "<option value=" . $role['name'] . ">" . $role['name'] . "</option>";
                        }
                    ?>
                </select>

                <button type="submit" name="add_user" class="bg-gray-600 text-white text-xl rounded">Add User</button>
            </form>
        </section>

        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">UserName</th>
                                <th scope="col" class="px-6 py-4">Password</th>
                                <th scope="col" class="px-6 py-4">Address Id</th>
                                <th scope="col" class="px-6 py-4">Role</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 

                                foreach($userData as $user) {
                                    echo "<tr class='border-b dark:border-neutral-500'>";
                                    echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>". $user['id']. "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>". $user['username']. "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>". $user['password']. "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>". $user['address_id']. "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>". $user['role_id']. "</td>";
                                    // echo "<td class='whitespace-nowrap px-6 py-4'>". $user['role_id']. "</td>";

                                    echo "<td class='whitespace-nowrap px-6 py-4'>";
                                    echo "<a href='Users.php?upd=" . $user['id'] . "' class='bg-blue-600 py-2 px-8 text-white font-bold'>Edit</a>";
                                    echo "<a href='Users.php?rm=" . $user['id'] . "' class='bg-red-600 py-2 ml-2 px-8 text-white font-bold'>Remove</a>";
                                    echo "</td>";

                                    echo "</td>";
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
    </div>


</body>
</html>





    
