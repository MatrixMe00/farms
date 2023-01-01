<?php 
    $animal = getDepartment($user_data["department_id"], false, "animal");
    if(is_array($animal)){
        $animal = $animal[0]["animal"];

        if(getActivePageName() == "performance"):
?>
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
                    <li class="text-cyan-600">sire:animal sire id</li>
                    <li class="text-indigo-600">suck:animal suck date</li>
                    <?php if($superadmin || $animal == "pig") : ?>
                    <li class="text-emerald-600">litter:animal litter size</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
<?php
        elseif(getActivePageName() == "records"):
?>
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
                    <?php if($superadmin || $animal == "pig") : ?>
                    <li class="text-emerald-600">wean:piglet wean weight</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
<?php
        elseif(getActivePageName() == "weight"):
?>
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
                    <li class="text-green-600">date:record date</li>
                </ul>
            </div>
        </div>
<?php
        endif;
    }
?>