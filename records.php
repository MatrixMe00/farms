<?php include_once "server/connect.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farms | Animal Record</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">

    <!-- Tailwind css -->
    <script src="assets/css/tailwind.js"></script>

    <!-- Jquery -->
    <script src="assets/jquery/compressed_jquery.js"></script>

    <style>*{transition: all 0.5s;}</style>
</head>
<body class="grid grid-cols-12 p-2 overflow-hidden min-h-[100vh]">
    <!-- Nav Bar -->
    <?php require_once "components/sidenav.php" ?>
    <!-- end of nav bar -->
    
    <!-- start of main content -->
    <main class="overflow-auto h-[98vh] border bg-gradient-to-b from-blue-300 to-blue-400 text-slate-900 p-2 sm:col-span-8 col-span-12 lg:col-span-9">
        <div class="flex justify-between items-center mb-6">
            <div class="ham sm:hidden">
                <span class="bg-slate-900 h-1 w-8 block m-1"></span>
                <span class="bg-slate-900 h-1 w-8 block m-1"></span>
                <span class="bg-slate-900 h-1 w-8 block m-1"></span>
            </div>
            <h1 class="font-bold text-right text-xl">Farm Cattle Records</h1>
        </div>
        
        <!-- View tabs -->
        <div id="tabs" class="flex p-2 gap-x-1 bg-white justify-center">
            <div class="tab p-2 border cursor-pointer bg-sky-600 text-white border-sky-600 hover:bg-sky-700" data-block-id="view"
                onclick="$('#add').find('button[name=resetForm]').click()"
            >
                <span>View Calves</span>
            </div>
            <div class="tab p-2 border cursor-pointer hover:bg-sky-600 hover:text-white" data-block-id="add"
                onclick="$('#add').find('select#animal_type').change()"
            >
                <span>Add Record</span>
            </div>
        </div>

        <div id="view" class="blocks active-block bg-white p-2 my-1 grid md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-2">
            <!-- Search bar -->
            <div class="md:col-span-2 lg:col-span-3 2xl:col-span-4">
                <p id="wrong_key" class="hidden p-1 text-red-700"></p>
                <input type="search" name="search" id="search" class="border w-full max-w-screen-sm p-2" placeholder="Search animal by id or breed or sex or sire id">
                <div class="instruction hidden border py-1 px-2 text-sm">
                    <p class="font-semibold">Search Instructions <br>
                        <span class="font-normal">Use the format below for searching</span>
                    </p>
                    <ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 border p-2 gap-x-2">
                        <li class="text-red-600">id:animal id</li>
                        <li class="text-blue-600">breed:animal breed</li>
                        <li class="text-orange-600">sex:animal sex</li>
                        <li class="text-violet-600">weight:animal weight</li>
                        <li class="text-green-600">dam:animal dam id</li>
                        <li class="text-cyan-600">sire:animal sire id</li>
                        <li class="text-indigo-600">dob:animal birthdate</li>
                        <li class="text-emerald-600">wean:piglet wean weight</li>
                    </ul>
                </div>
            </div>

            <!-- Animal details -->
            <?php require_once("components/animal.php") ?>
        </div>

        <!-- Update a record -->
        <?php require_once("components/update.php") ?>

        <!-- Add a record -->
        <?php require_once("components/add.php") ?>

        <!-- Delete box -->
        <?php include("components/delete.php") ?>

    </main>
    <!-- end of main -->

    <!-- scripts -->
    <?php include("components/basescript.php") ?>

</body>
</html>