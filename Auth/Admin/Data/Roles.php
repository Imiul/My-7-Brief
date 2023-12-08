<?php 

    session_start();
    if (!isset($_SESSION['name']) || $_SESSION['user_type'] != "ADMIN") {
        header("Location: ../../Login.php");
        exit;
    }

    include('../../-- Database/db-connection.php');

    
    if (isset($_POST['add_role'])) {
        $role_name = $_POST['role_value'];

        if (empty($role_name)) {
            echo "<script>alert('Role Name Should Not Be Empty');</script>";
        } else {

            $query = "INSERT INTO role (name) VALUES ('$role_name')";
            $run_query = mysqli_query($cnx, $query);


            $find_id = "SELECT id FROM role WHERE name = '$role_name' ";
            $run_find_id = mysqli_query($cnx, $find_id);
            $id_row = mysqli_fetch_assoc($run_find_id);


            $permition_array = $_POST['permition_id'];
            foreach($permition_array as $pr) {

                $profrole = "
                    INSERT INTO permissionofrole (role_id, permission_id)
                    VALUES (" . $id_row['id'] . ", $pr);
                ";

                $run_profrole = mysqli_query($cnx, $profrole);
            }

            echo "<script>alert('Role Added Succesfuly');</script>";
        }


        
    }

    if (isset($_GET['rm'])) {
        $id_to_remove = $_GET['rm'];

        $query = "
            DELETE FROM `role` WHERE `id` = '$id_to_remove';
        ";

        $run_query = mysqli_query($cnx, $query);
        echo "<script>window.alert('Role Deleated Succesfully');</script>";
        header("Location: Roles.php");
    }


    

    if (isset($_POST['update_role'])) {

        $updatedRole = $_POST['updatedRole'];

        $upd_query = "
            UPDATE role
            SET name = '$updatedRole'
            WHERE id = ". $_GET['upd']. ";
        ";

        $run_upd_query = mysqli_query($cnx, $upd_query);

        echo "<script>window.alert('Role Updated Succesfully');</script>";
        header("Location: Roles.php");

    }

    $fetchRoles = "SELECT * FROM role;";
    $rolesData = $cnx->query($fetchRoles);
    

    if (isset($_POST['logout'])) {
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header('Location: ../../Login.php');
        exit();
    }


    $fetchPermitionsdb = "SELECT * FROM permission";
    $permitionsdb = mysqli_query($cnx, $fetchPermitionsdb);
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
                    <a href="Agencies.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Agency's</a>
                    <a href="Atm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Distrubuteur's</a>
                    <a href="Roles.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">Role's</a>
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
        <section id="add" class="mt-20 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <form action="Roles.php" method="post" class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <input name="role_value" type="text" placeholder="Role Name" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                
                <select name="permition_id[]" multiple class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                    <option value="">select role permitions</option>
                    <?php
                        foreach($permitionsdb as $permition) {
                            echo "<option value='" . $permition['id'] . "'> " . $permition['name'] . "</option>";
                        }
                    ?>
                </select>

                <button type="submit" name="add_role" class="bg-gray-600 text-white text-xl rounded">Add Role</button>
            </form>
        </section>


        <!-- PAGE CONTENT ===================== -->
        <main id="show">
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table id="example" class="table table-striped" style="width:100%">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Role Name</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($rolesData as $role) {
                                
                                echo "<tr class='border-b dark:border-neutral-500'>";
                                echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $role['id'] . "</td>";
                                echo "<td class='whitespace-nowrap px-6 py-4'>" . $role['name'] . "</td>";
                                echo "<td class='whitespace-nowrap px-6 py-4'>";
                                echo "<a href='Roles.php?upd=" . $role['id'] . "' class='bg-blue-600 mr-4 py-2 px-8 text-white font-bold'>Edit</a>";
                                echo "<a href='Roles.php?rm=" . $role['id'] . "' class='bg-red-600 py-2 px-8 text-white font-bold'>Remove</a>";
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
            $fetching = "SELECT * FROM role WHERE id = $id_to_update";
            $run_fetching = mysqli_query($cnx, $fetching);
            
            $row = mysqli_fetch_assoc($run_fetching);
        }

    ?>
    <section id="update" class="hidden mt-20 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <form method="post" class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <input name="updatedRole" type="text" <?php echo "value='" . $row['name'] . "'";?> class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                <button type="submit" name="update_role" class="bg-gray-600 text-white text-xl rounded">Update Role</button>
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





    
