<?php include_once "server/connect.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farms | Dashboard</title>

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
            <h1 class="font-bold text-right text-xl">Records for the Current Month</h1>
        </div>
        
        <!-- summarized views -->
        <?php if($superadmin) : ?>
        <div class="space-y-5">
            <div class="p-2 bg-white/10 hover:bg-white/30">
                <h2 class="font-semibold text-base bg-white/90 rounded-t w-fit py-2 px-2">
                    Cattle Records
                </h2>
        <?php endif; ?>
                <?php if($superadmin || $user_data["department_id"] == 1): ?>
                <di class="grid lg:grid-cols-2 gap-x-2 gap-y-3 xl:grid-cols-3">
                    <div class="p-4 border rounded <?php if($superadmin): ?>rounded-tl-none<?php endif; ?> flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Total Cattle</span>
                        <span class="text-3xl mt-2"><?= countAnimalType("cow") ?></span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Population rise</span>
                        <span class="text-3xl mt-2"><?= populationRise("cow") ?></span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Average Cattle Weight</span>
                        <span class="text-3xl mt-2">31.25kg</span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Average Cattle Performance</span>
                        <span class="text-3xl mt-2">84.64%</span>
                    </div>
                </div>
                <?php endif; ?>
            <?php if($superadmin): ?>
            </div>
            <div class="p-2 bg-white/10 hover:bg-white/30">
                <h2 class="font-semibold text-base bg-white/90 rounded-t w-fit py-2 px-2">
                    Sheep Records
                </h2>
            <?php endif; ?>
                <?php if($superadmin || $user_data["department_id"] == 2): ?>
                <div class="grid lg:grid-cols-2 gap-x-2 gap-y-3 xl:grid-cols-3">
                    <div class="p-4 border rounded <?php if($superadmin): ?>rounded-tl-none<?php endif; ?> flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Total Sheep</span>
                        <span class="text-3xl mt-2">20</span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Population rise</span>
                        <span class="text-3xl mt-2">15.5%</span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Average Sheep Weight</span>
                        <span class="text-3xl mt-2">31.25kg</span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Average Sheep Performance</span>
                        <span class="text-3xl mt-2">84.64%</span>
                    </div>
                </div>
                <?php endif; ?>
            <?php if($superadmin): ?>
            </div>
            <div class="p-2 bg-white/10 hover:bg-white/30">
                <h2 class="font-semibold text-base bg-white/90 rounded-t w-fit py-2 px-2">
                    Pig Records
                </h2>
            <?php endif; ?>
                <?php if($superadmin || $user_data["department_id"] == 3): ?>
                <div class="grid lg:grid-cols-2 gap-x-2 gap-y-3 xl:grid-cols-3">
                    <div class="p-4 border rounded <?php if($superadmin): ?>rounded-tl-none<?php endif; ?> flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Total Pig</span>
                        <span class="text-3xl mt-2">20</span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Population rise</span>
                        <span class="text-3xl mt-2">15.5%</span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Average Pig Weight</span>
                        <span class="text-3xl mt-2">31.25kg</span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Average Pig Performance</span>
                        <span class="text-3xl mt-2">84.64%</span>
                    </div>
                </div>
                <?php endif; ?>
            <?php if($superadmin): ?>
            </div>
            <div class="p-2 bg-white/10 hover:bg-white/30">
                <h2 class="font-semibold text-base bg-white/90 rounded-t w-fit py-2 px-2">
                    Goat Records
                </h2>
            <?php endif; ?>
                <?php if($superadmin || $user_data["department_id"] == 2): ?>
                <div class="grid lg:grid-cols-2 gap-x-2 gap-y-3 xl:grid-cols-3 <?php if($user_data["department_id"] == 2){echo "mt-4";} ?>">
                    <div class="p-4 border rounded <?php if($superadmin): ?>rounded-tl-none<?php endif; ?> flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Total Goat</span>
                        <span class="text-3xl mt-2">20</span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Population rise</span>
                        <span class="text-3xl mt-2">15.5%</span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Average Goat Weight</span>
                        <span class="text-3xl mt-2">31.25kg</span>
                    </div>
                    <div class="py-2 px-4 border rounded flex justify-between items-between min-h-[10vh] bg-neutral-50">
                        <span class="text-sm">Average Goat Performance</span>
                        <span class="text-3xl mt-2">84.64%</span>
                    </div>
                </div>
                <?php endif; ?>
            <?php if($superadmin): ?>
            </div>
            <?php endif; ?>
        </div>
    </main>
    <!-- end of main content -->

    <!-- scripts -->
    <script src="assets/scripts/ham.js"></script>
</body>
</html>