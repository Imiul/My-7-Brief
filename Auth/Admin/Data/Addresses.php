<?php
    
    session_start();
    if (!isset($_SESSION['name']) || $_SESSION['user_type'] != "Admin") {
        header("Location: ../../Login.php");
        exit;
    }
    
    include('../../-- Database/db-connection.php');

    $moroccoCities = array(
        'Casablanca', 'Rabat', 'Marrakech', 'Fes', 'Agadir', 'Tangier', 'Essaouira', 'Meknes', 'Ouarzazate', 'Chefchaouen', 'Zemamra', 'Safi'
    );

    if (isset($_POST['addAddress'])) {

        $ville = $_POST['ville'];   
        $quartier = $_POST['quartier'];
        $rue = $_POST['rue'];
        $code_postal = $_POST['codePostal'];
        $email_address = $_POST['EmailAddress'];
        $phone_number = $_POST['PhoneNumber'];
    
        if (empty($ville) || empty($quartier) || empty($rue) || empty($code_postal) || empty($email_address) || empty($phone_number)) {
            echo "<script>window.alert('Inputs Should Not Be Empty');</script>";
    
        } else {
    
            $query = "
                INSERT INTO address (ville, quartier, rue, code_postal, email, telephone)
                VALUES ('$ville', '$quartier', '$rue', '$code_postal', '$email_address', '$phone_number');
            ";
    
            $run_query = mysqli_query($cnx, $query);
            echo "<script>window.alert('Address Added Successfully');</script>";
        }
    }


    if (isset($_GET['rm'])) {
        $id_to_remove = $_GET['rm'];

        $query = "
            DELETE FROM `address` WHERE id = '$id_to_remove';
        ";

        $run_query = mysqli_query($cnx, $query);
        echo "<script>window.alert('Address Deleated Succesfully');</script>";
        header("Location: Addresses.php");
    }


    $fetchAddress = "SELECT * FROM address;";
    $addresesData = $cnx->query($fetchAddress);

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
                    <a href="Users.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">User's</a>
                    <a href="Addresses.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">Address's</a>
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
            <form method="post" action="Addresses.php" placeholder class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                
                <select name="ville" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    <option value="0">Choose City</option>
                    <?php
                        foreach ($moroccoCities as $city) {
                            echo "<option value='$city'>$city</option>";
                        }
                    ?>
                </select>    
                <input name="quartier" type="text" placeholder="Quartier" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="rue" type="text" placeholder="Rue" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="codePostal" type="text" placeholder="Code Postal" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="EmailAddress" type="text" placeholder="Email Address" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <input name="PhoneNumber" type="text" placeholder="Phone Number" class=" pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">

                <button type="submit" name="addAddress" class="bg-gray-600 text-white text-xl rounded">Add Address</button>
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
                                <th scope="col" class="px-6 py-4">Ville</th>
                                <th scope="col" class="px-6 py-4">Quartier</th>
                                <th scope="col" class="px-6 py-4">Rue</th>
                                <th scope="col" class="px-6 py-4">Code Postal</th>
                                <th scope="col" class="px-6 py-4">Email Address</th>
                                <th scope="col" class="px-6 py-4">Phone</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($addresesData as $addres) {
                                
                                echo "<tr class='border-b dark:border-neutral-500'>";
                                echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $addres['id'] . "</td>";
                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $addres['ville'] . "</td>";
                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $addres['quartier'] . "</td>";
                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $addres['rue'] . "</td>";
                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $addres['code_postal'] . "</td>";
                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $addres['email'] . "</td>";
                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $addres['telephone'] . "</td>";
                                echo "<td class='whitespace-nowrap px-6 py-4'>";
                                echo "<a href='Addresses.php?upd=" . $addres['id'] ."' class='bg-blue-600 mr-4 py-2 px-8 text-white font-bold'>Edit</a>";
                                echo "<a href='Addresses.php?rm=" . $addres['id'] ."' class='bg-red-600 py-2 px-8 text-white font-bold'>Remove</a>";
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





    
