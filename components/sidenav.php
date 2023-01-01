<?php
    include_once "server/connect.php";
    $tabs = [
        "dashboard" => ["name" => "dashboard", "title" => "Dashboard", "url" => "dashboard.php", "deps"=>"0,1,2,3"],
        "performance" => ["name" => "performance", "title" => "Performance Records", "url" => "performance.php", "deps"=>"0,1,2,3"],
        "records" => ["name" => "records", "title" => "Animal Records", "url" => "records.php", "deps"=>"0,1,2,3"],
        "weight" => ["name" => "weight", "title" => "Weight Records", "url" => "weight.php", "deps"=>"0,1,2,3"],
        "users" => ["name" => "users", "title" => "Users", "url" => "", "deps"=>"0"],
        "account" => ["name" => "account", "title" => "My Account", "url" => "", "deps"=>"0,1,2,3"],
        "logout" => ["name" => "logout", "title" => "Logout", "url" => "logout.php", "deps"=>"0,1,2,3,4,5,6"]
    ];

    //get current path
    $script_name = getActivePageName();
?>

<nav class="border hidden sm:flex flex-col py-2 bg-gradient-to-tr from-indigo-600 to-blue-600 text-white col-span-2 items-center sm:col-span-4 lg:p-2 lg:col-span-3 overflow-y-auto">
        <!-- logo -->
        <div class="w-24 md:w-32 lg:w-42">
            <img src="assets/logo.png" alt="">
        </div>
        <!-- user full name -->
        <span class="block text-center w-full font-semibold">
           <?= ucwords($user_data["fname"])." ".ucfirst($user_data["lname"]) ?>
        </span>
        <!-- username -->
        <span class="block text-center text-sm"><?= ucwords($user_data["username"]) ?></span>

        <!-- department -->
        <?php if(intval($user_data["department_id"]) > 0) : ?>
        <span class="block text-center text-sm"><?= getDepartment(intval($user_data["department_id"]), true); ?> Department</span>
        <?php else : ?>
        <span class="block text-center text-sm">No Department</span>
        <?php endif; ?>
        
        <!-- nav links -->
        <div class="links mt-6 p-2 flex flex-col w-full gap-1">
            <?php 
                foreach($tabs as $tab):
                    //make sure this tab should be shown to selected user
                    $val_dep = explode(",", $tab["deps"]);
                    
                    if(in_array($user_data["department_id"], $val_dep)) :
            ?><a href="<?= $tab["url"] ?>"
                <?php 
                    //check if this is the current tab
                    if($tab["name"] != $script_name) :?>
                    class="cursor-pointer border text-center px-2 py-1 hover:bg-blue-800"
                    <?php else : ?>
                    class="link cursor-pointer border text-center px-2 py-1 bg-blue-800 hover:bg-blue-900"
                <?php endif; ?>>
                <span><?= $tab["title"] ?></span>
            </a>
            <?php 
                    endif;
                endforeach;
            ?>
        </div>
    </nav>