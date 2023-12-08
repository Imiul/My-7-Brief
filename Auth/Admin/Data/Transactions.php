
<?php

    session_start();
    if (!isset($_SESSION['name']) || $_SESSION['user_type'] != "Admin") {
        header("Location: ../../Login.php");
        exit;
    }

    include('../../-- DATABASE/db-connection.php');

    if (isset($_POST['add_transaction'])) {

        $accountId = $_POST['AccountId'];
        $type = $_POST['type'];
        $amount = $_POST['amount'];

        if ($type === 0 || $amount == 0 || empty($amount)) {
            echo "<script>alert('Inputs should not be empty');</script>";
        } else {

            $query = "
                INSERT INTO transaction (type, amount, account_id)
                VALUES ('$type', '$amount', '$accountId');
            ";
            $run_query = mysqli_query($cnx, $query);


            if ($type == "credit") {
                
                $update_amount = "
                    UPDATE account
                    SET balance =   balance + $amount
                    WHERE id = $accountId
                ";

                $updating = mysqli_query($cnx, $update_amount);
                echo "<script>window.alert('Balance Updated Succesfully & Transaction Added');</script>";

            } else {

                $update_amount = "
                    UPDATE account
                    SET balance =   balance - $amount
                    WHERE id = $accountId
                ";

                $updating = mysqli_query($cnx, $update_amount);
                echo "<script>window.alert('Transaction Added & Balance Updated Succesfully');</script>";

            }
        }
    }

    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('Location: ../../Login.php');
        exit();
    }


    $fetchAccount = "SELECT * FROM account";
    $accountData = $cnx->query($fetchAccount);

    $fetchTransactions = "SELECT * FROM transaction";
    $transactionData = $cnx->query($fetchTransactions);

    if (isset($_GET['rm'])) {

        $id_to_delete = $_GET['rm'];
        $transaction_delete = "DELETE FROM transaction WHERE id = $id_to_delete";
        $run_delete = mysqli_query($cnx, $transaction_delete);
        echo "<script>window.alert('Transaction Deleted Succesfully');</script>";
        header("Location: Transactions.php");
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
                    <a href="Agencies.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Agency's</a>
                    <a href="Atm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Distrubuteur's</a>
                    <a href="Roles.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Role's</a>
                    <a href="Users.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">User's</a>
                    <a href="Addresses.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Address's</a>
                    <a href="Accounts.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Account's</a>
                    <a href="Transactions.php" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium">Transaction's</a>
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


        <section id="add" class="mt-20 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8 " >
            <!-- <h3 class="sm:px-20">Add A User</h3> -->
            <form method="post" class="grid gap-4 grid-cols-2 border-b-4 border-gray-600 pb-4">
                <select name="AccountId" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    <option value="0">Choose Account to Add Account </option>
                    <?php
                    
                        $fetchuser = "SELECT * FROM user";
                        $data = $cnx->query($fetchuser);

                        foreach ($accountData as $account) {
                            echo "<option value='" . $account['id']. "'> ( RIB : " . $account['rib'] . " ) / Account Id : ". $account['id'] . " * User Id : ". $account['user_id'] ."</option>";
                        }
                    ?>
                </select>
                <select name="type" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                    <option value="0">Transaction Type</option>
                    <option value="credit">credit</option>
                    <option value="debit">debit</option>
                </select>    
                <input name="amount" type="number" placeholder="Amount" class="pl-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400  sm:text-sm sm:leading-6">
                
                <button type="submit" name="add_transaction" class="bg-gray-600 text-white text-xl rounded">Add Transaction</button>
            </form>
        </section>


        <!-- PAGE CONTENT ===================== -->
        <main>
            
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div >
                    <div class="overflow-hidden">
                        <table id="example" class="table table-striped" style="width:100%">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Type</th>
                                <th scope="col" class="px-6 py-4">Amount</th>
                                <th scope="col" class="px-6 py-4">Account Id</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                foreach($transactionData as $transaction) {
                                    echo "<tr class='border-b dark:border-neutral-500' >";
                                    echo "<td class='whitespace-nowrap px-6 py-4 font-medium'>" . $transaction['id'] ."</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" . $transaction['type'] ."</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" . $transaction['amount'] ."</td>";
                                    echo "<td class='whitespace-nowrap px-6 py-4'>" . $transaction['account_id'] ."</td>";

                                    echo "<td class='whitespace-nowrap px-6 py-4'>";
                                    echo "<a href='Transactions.php?upd=" . $transaction['id'] . "' class='bg-blue-600 py-2 px-8 text-white font-bold'>Edit</a>";
                                    echo "<a href='Transactions.php?rm=" . $transaction['id'] . "' class='bg-red-600 py-2 ml-2 px-8 text-white font-bold'>Remove</a>";
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





    
