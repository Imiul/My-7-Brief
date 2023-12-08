<?php
    include('../../-- Database/db-connection.php');
            
             if (isset($_GET["triage"])) {
                $fetchusers = "SELECT * FROM user ORDER BY username COLLATE utf8mb4_general_ci ASC";
                $userData = $cnx->query($fetchusers);
            }
            
            ?>
    


<div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8" id="users-table-container">
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-Accounts.phfull py-2 sm:px-6 lg:px-8">
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
