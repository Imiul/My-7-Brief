<?php

    
    session_start();
    if (!isset($_SESSION['name']) || $_SESSION['user_type'] != "Admin") {
        header("Location: ../../Login.php");
        exit;
    }

    include('../../-- DATABASE/db-connection.php');

    if (isset($_POST['add_bank'])) {

        $bankName = $_POST['bankName'];
        $bankImage = $_POST['bankImage'];

        if (empty($bankName) || empty($bankImage)) {
            echo "<script>window.alert('Inputs should not be empty');</script>";
        
        } else {

            $query = "
                INSERT INTO bank (name, bank_logo)
                VALUES ('$bankName', '$bankImage');
            ";

            $run_query = mysqli_query($cnx, $query);
            echo "<script>window.alert('bank Added successfuly');</script>";
        }
    }

    $fetchBanks = "SELECT * FROM bank";
    $banksData = $cnx->query($fetchBanks);

    if (isset($_GET['rm'])) {

        $id_to_remove = $_GET['rm'];

        $remove_bank = "DELETE FROM bank WHERE id = $id_to_remove";
        $run_remove = mysqli_query($cnx, $remove_bank);
        echo "<script>window.alert('bank Deleted successfuly');</script>";
        header("Location: bank.php");
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
                    <a href="bank.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">Bank's</a>
                    <a href="Agencies.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Agency's</a>
                    <a href="Atm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Distrubuteur's</a>
                    <a href="Roles.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Role's</a>
                    <a href="Users.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">User's</a>
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
        <section class="mt-20 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8" >
            <form method="post" class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4" name="bank_form">
                <input name="bankName" type="text" placeholder="Bank Name" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="bankImage" type="text" placeholder="Bank Image Name" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <button type="submit" name="add_bank" class="bg-gray-600 text-white text-xl rounded">Add Bank</button>
            </form>
        </section>


        <!-- PAGE CONTENT ===================== -->
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
                                <th scope="col" class="px-6 py-4">Bank Logo</th>
                                <th scope="col" class="px-6 py-4">Bank Name</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                                foreach($banksData as $bank) {
                                    echo "<tr class='border-b dark:border-neutral-500'>";
                                    echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $bank['id']. "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>";
                                    echo " <img src='../../../Assets/Img/" . $bank['bank_logo'] ."' alt='bank logo' width='150px'>";
                                    echo "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $bank['name']. "</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>";
                                    echo "<a href='bank.php?upd=" . $bank['id'] . "' class='bg-blue-600 py-2 px-8 text-white font-bold'>Edit</a>";
                                    echo "<a href='bank.php?rm=" . $bank['id'] . "' class='bg-red-600 py-2 ml-2 px-8 text-white font-bold'>Remove</a>";
                                    echo "</td>";

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
    </div>



</body>
</html>





    
