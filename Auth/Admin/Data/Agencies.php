<?php

    
    session_start();
    if (!isset($_SESSION['name']) || $_SESSION['user_type'] != "ADMIN") {
        header("Location: ../../Login.php");
        exit;
    }

    include('../../-- DATABASE/db-connection.php');

    if (isset($_POST['add_agency'])) {

        $bankId = $_POST['bankId'];
        $agenceName = $_POST['agenceName'];
        $longitude = $_POST['longitude'];
        $laltitude = $_POST['laltitude'];

        if ($bankId === 0 || empty($agenceName) || empty($longitude) || empty($laltitude) ) {
            echo "<script>window.alert('inputs should not be empty');</script>";
        } else {

            $query = "
                INSERT INTO agence (bank_name, longitude, latitude, bank_id)
                VALUES ('$agenceName', $longitude, '$laltitude', $bankId);
            ";

            $run_query = mysqli_query($cnx, $query);
            echo "<script>window.alert('Agency Added succesfully');</script>";

        }
    }

    $fetchAgence = "SELECT * FROM agence";
    $agenceData = $cnx->query($fetchAgence);

    $fetchBank = "SELECT * FROM bank";
    $bankData = $cnx->query($fetchBank);

    if (isset($_GET['rm'])) {

        $agency_to_remove = $_GET['rm'];

        $time = new DateTime();
        $escapedDateTime = mysqli_real_escape_string($cnx, $time->format("Y-m-d H:i:s"));

        $deleteQuery = "
            UPDATE `agence`
            SET softDelete = '$escapedDateTime'
            WHERE `id` = '$id_to_remove'
        ";

        $run_delete = mysqli_query($cnx, $deleteQuery);
        echo "<script>window.alert('Agency Deleated succesfully');</script>";
        header("Location: Agencies.php");
    }

    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ../../Login.php');
        exit();
    }
    
    if (isset($_POST['update_agency'])) {

        $ag_id_to_update = $_GET['upd'];

        $up_agenceName = $_POST['update_agenceName'];
        $up_longitude = $_POST['update_longitude'];
        $up_laltitude = $_POST['update_laltitude'];

        $update_query = "
            UPDATE agence 
            SET bank_name = '$up_agenceName', longitude = '$up_longitude', latitude = '$up_laltitude'
            WHERE id = $ag_id_to_update;
        ";

        $run_update_query = mysqli_query($cnx, $update_query);
        echo "<script>window.alert('Agency Updated Succesfully');</script>";
        header("Location: Agencies.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">


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
                    <a href="Agencies.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">Agency's</a>
                    <a href="Atm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Distrubuteur's</a>
                    <a href="Roles.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Role's</a>
                    <a href="Users.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">User's</a>
                    <a href="Addresses.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Address's</a>
                    <a href="Accounts.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Account's</a>
                    <a href="Transactions.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Transaction's</a>
                    <a href="Permition.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Permition's</a>    
                </div>
                </div>
                </div>
                <div class="hidden md:block">

                <div class="ml-4 flex items-center md:ml-6">
                    <form method="post" style="display: flex; align-items: center;">
                        <button style="color: red;" name="logout" type="submit">Log Out</button>
                    </form>
                </div>
                
                </div>
            </div>
            </div>

            
        </nav>


        <!-- PAGE CONTENT ===================== -->
        <section class="mt-20 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8" id="add" >
            <form method="post" class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <select name="bankId" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    <option value="0">Choose bank</option>
                    <?php
                        foreach($bankData as $bank) {
                            echo "<option value='". $bank['id'] . "' >" . $bank['name'] ."</option>";
                        }
                    ?>
                </select>    
                <input name="agenceName" type="text" placeholder="agence Name" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="longitude" type="text" placeholder="Longitude" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="laltitude" type="text" placeholder="Laltitude" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <!-- <input name="agenceId" type="text" placeholder="Bank Id" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"> -->
                

                <button name="add_agency" type="submit" class="bg-gray-600 text-white text-xl rounded">Add Agency</button>
            </form>
        </section>



        <!-- PAGE CONTENT ===================== -->
        <main id="show" >
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table id="example" class="table table-striped" style="width:100%">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Agency Name</th>
                                <th scope="col" class="px-6 py-4">Longitude</th>
                                <th scope="col" class="px-6 py-4">Laltitude</th>
                                <th scope="col" class="px-6 py-4">Bank ID</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_GET['upd'])) {
                                

                            }
                                foreach($agenceData as $agence) {
                                    if ($agence['softDelete'] == NULL) {
                                        echo "<tr class='border-b dark:border-neutral-500'>";

                                        echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $agence['id'] . "</td>";
                                        echo "<td class='whitespace-nowrap px-6 py-4'>" . $agence['bank_name'] . "</td>";
                                        echo "<td class='whitespace-nowrap px-6 py-4'>" . $agence['longitude'] . "</td>";
                                        echo "<td class='whitespace-nowrap px-6 py-4'>" . $agence['latitude'] . "</td>";
                                        echo "<td class='whitespace-nowrap px-6 py-4'>" . $agence['bank_id'] . "</td>";

                                        echo "<td class='whitespace-nowrap px-6 py-4'>";
                                        echo "<a href='Agencies.php?upd=" . $agence['id'] . "' class='bg-blue-600 mr-4 py-2 px-8 text-white font-bold'>Edit</a>";
                                        echo "<a href='Agencies.php?rm=" . $agence['id'] . "' class='bg-red-600 py-2 px-8 text-white font-bold'>Remove</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
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





    <?php
        if(isset($_GET['upd'])) {
            
            echo "
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.getElementById('update').classList.remove('hidden');
                        document.getElementById('add').classList.add('hidden');
                        document.getElementById('show').classList.add('hidden');
                    });
                </script>
            ";
    
            $id_to_update = $_GET['upd'];
            $fetching = "SELECT * FROM agence WHERE id = $id_to_update";
            $run_fetching = mysqli_query($cnx, $fetching);
            
            $row = mysqli_fetch_assoc($run_fetching);
        }
    ?>





    <section class="hidden mt-20 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8" id="update" >
            <form method="post" class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <select name="bankId" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    <?php
                        $find_bankname = "SELECT * FROM bank WHERE id = " . $row['bank_id'] .";";
                        $fetch_find_bankname = mysqli_query($cnx, $find_bankname);

                        $row_b = mysqli_fetch_assoc($fetch_find_bankname);
                        echo "<option value='' > " . $row_b['name'] ."</option>";
                    ?>
                </select>    
                <input name="update_agenceName" type="text" <?php echo "value='" . $row['bank_name'] . "'";?> class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="update_longitude" type="text" <?php echo "value='" . $row['longitude'] . "'";?> class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="update_laltitude" type="text" <?php echo "value='" . $row['latitude'] . "'";?>class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">

                <button name="update_agency" type="submit" class="bg-gray-600 text-white text-xl rounded">Update Agency</button>
            </form>
        </section>


        <script  src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script  src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script  src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script  >
        $(document).ready(function(){
            $('#example').DataTable();
        });
    </script>

</body>
</html>





    
