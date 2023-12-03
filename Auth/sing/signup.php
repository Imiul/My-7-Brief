<?php
session_start();
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Sing up Page</title>
</head>

<body>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign up to your
                account</h2>
        </div>


        <form action=".\includes\signup.inc.php" method="post" class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div id="form1" class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                <input type="text" name="username" placeholder="Your Name"
                    value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''; ?>"
                    class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <br>
                <input name="email" type="text" placeholder="Email Address"
                    value="<?php echo isset($_GET['email']) ? $_GET['email'] : "" ?>"
                    class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <br>
                <input name="passwordUser" type="password" placeholder="Password"
                    class="px-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <br>
                <input name="password-repeat" type="password" placeholder="repeat password"
                    class="px-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <br>
                <div id="nextButton" onclick="showForm2()"
                    class="flex w-full justify-center rounded-md bg-gray-800 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Next</div>
            </div>
            <div id="form2" class="hidden flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                <input name="telephone" type="number" placeholder="telephone"
                    class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <br>
                <input name="ville" type="text" placeholder="Ville"
                    class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                <br>
                <input name="quartier" type="text" placeholder="quartier"
                    class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <br>
                <input name="rue" type="text" placeholder="rue"
                    class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                <br>
                <input name="code_postal" type="number" placeholder="code postal"
                    class="block w-full rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">

                <br>
                <button type="submit" name="signup-submit"
                    class="flex w-full justify-center rounded-md bg-gray-800 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sing
                    up</button>

            </div>
        </form>
    </div>
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyfields") {
            echo '<p class="error">fill the inputs</p>';
        } elseif ($_GET['error'] == "invalidemailUid") {
            echo '<p class="error">email and username not valid</p>';
        } elseif ($_GET['error'] == "invalidemail") {
            echo '<p class="error">email not valid</p>';
        } elseif ($_GET['error'] == "invaliduid") {
            echo '<p class="error"> username not valid</p>';
        } elseif ($_GET['error'] == "passwordcheck") {
            echo '<p class="error">Passwords do not match</p>';
        }
    } elseif (isset($_GET['signup']) == "success") {
        echo '<p class="success">Sign up Successfully</p>';
    }
    ?>


    <!-- SCRIPT -->
    <script>
        function showForm2() {
            document.getElementById("form1").style.display = "none";
            document.getElementById("form2").style.display = "flex";
        }
    </script>

</body>

</html>