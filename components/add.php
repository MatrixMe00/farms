<?php 
    $animal = getDepartment($user_data["department_id"], false, "animal");
    if(is_array($animal)){
        $animal = $animal[0]["animal"];

        if(getActivePageName() == "performance"):
?>
        <div id="add" class="hidden blocks bg-white p-2 my-1">
            <form action="" class="p-2 lg:p-4 z-10 w-full bg-white sm:m-auto" 
                name="add-form">
                <h1 class="pt-2 pb-4 text-xl capitalize">Add a new performance Record</h1>
                <div class="grid gap-2 bg-red-50 p-2">
                    <!-- message box -->
                    <div class="hidden message-box sticky top-2 p-2 text-center border lg:col-span-2">
                        <span>Some message to show</span>
                    </div>
                    
                    <!-- displayed input fields -->
                    <div class="grid all">
                        <label for="animal_type">Animal Type</label>
                        <select type="text" name="animal_type" id="animal_type"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                            <?php if($superadmin || $user_data["department_id"] == 1) : ?>
                            <option value="cow">Cow</option>
                            <?php endif; ?>
                            <?php if($superadmin || $user_data["department_id"] == 2) : ?>
                            <option value="sheep">Sheep</option>
                            <option value="goat">Goat</option>
                            <?php endif; ?>
                            <?php if($superadmin || $user_data["department_id"] == 3) : ?>
                            <option value="pig">Pig</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="grid">
                        <label for="animal_id">Animal ID</label>
                        <input type="text" name="animal_id" id="animal_id" placeholder="Animal ID"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="animal_breed">Breed</label>
                        <input type="text" name="animal_breed" id="animal_breed" placeholder="Breed"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="animal_sex">Sex</label>
                        <select name="animal_sex" id="animal_sex"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="grid">
                        <label for="suck_date" class="cow">Calving Date</label>
                        <label for="suck_date" class="sheep">Lambing Date</label>
                        <label for="suck_date" class="pig">Farrowing Date</label>
                        <label for="suck_date" class="goat">Kidding Date</label>
                        <input type="date" name="suck_date" id="suck_date" placeholder="Calving Date"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid pig">
                        <label for="litter_size">Litter Size</label>
                        <input type="number" name="litter_size" id="litter_size" placeholder="Litter Size"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid pig">
                        <label for="male_pigs">Male Piglets</label>
                        <input type="number" name="male_pigs" id="male_pigs" placeholder="Male Piglets"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid pig">
                        <label for="female_pigs">Female Piglets</label>
                        <input type="number" name="female_pigs" id="female_pigs" placeholder="Female Piglets"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid cow goat sheep">
                        <label for="birth_type">Type of Birth</label>
                        <input type="text" name="birth_type" id="birth_type" placeholder="Type of Birth"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="birth_litter_weight" class="cow goat sheep">Birth Weight</label>
                        <label for="birth_litter_weight" class="pig">Litter Weight</label>
                        <input type="text" name="birth_litter_weight" id="birth_litter_weight" placeholder="Birth Weight"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="sire_id">Sire ID</label>
                        <input type="text" name="sire_id" id="sire_id" placeholder="Sire ID"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid md:col-span-2">
                        <label for="remarks">Remarks</label>
                        <textarea name="remarks" id="remarks" placeholder="Remarks"
                            class="border p-2 rounded focus:outline-none focus:rounded-none min-h-[10vh]"
                        ></textarea>
                    </div>
                    <div class="lg:col-span-2 flex flex-wrap justify-center gap-x-12 gap-y-2">
                        <button class="p-2 border bg-gradient-to-tr from-green-600 to-emerald-600 text-white w-full lg:max-w-[16rem] 
                            hover:shadow hover:to-green-600" type="submit" name="submit" value="add_animal_performance">Add Performance</button>
                        <button type="button" name="resetForm" class="p-2 border bg-gradient-to-tr from-rose-600 to-red-600 text-white 
                            w-full lg:max-w-[16rem] hover:shadow hover:from-red-600 hover:to-red-600">Reset</button>
                    </div>
                </div>
            </form>
        </div>
<?php
        elseif(getActivePageName() == "records"):
?>
        <div id="add" class="hidden blocks bg-white p-2 my-1">
            <form action="" class="p-2 lg:p-4 z-10 w-full bg-white sm:m-auto" 
                name="add-form">
                <h1 class="pt-2 pb-4 text-xl capitalize">Add a new performance Record</h1>
                <div class="grid gap-2 bg-red-50 p-2">
                    <!-- message box -->
                    <div class="hidden message-box sticky top-2 p-2 text-center border lg:col-span-2">
                        <span>Some message to show</span>
                    </div>
                    
                    <!-- displayed input fields -->
                    <div class="grid">
                        <label for="animal_type">Animal Type</label>
                        <select type="text" name="animal_type" id="animal_type"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                            <?php if($superadmin || $user_data["department_id"] == 1) : ?>
                            <option value="cow">Cow</option>
                            <?php endif; ?>
                            <?php if($superadmin || $user_data["department_id"] == 2) : ?>
                            <option value="sheep">Sheep</option>
                            <option value="goat">Goat</option>
                            <?php endif; ?>
                            <?php if($superadmin || $user_data["department_id"] == 3) : ?>
                            <option value="pig">Pig</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="grid">
                        <label for="animal_id">Animal ID</label>
                        <input type="text" name="animal_id" id="animal_id" placeholder="Animal ID"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" id="dob" placeholder="Calving Date"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="animal_breed">Breed</label>
                        <input type="text" name="animal_breed" id="animal_breed" placeholder="Breed"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="animal_sex">Sex</label>
                        <select name="animal_sex" id="animal_sex"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="grid pig">
                        <label for="wean_weight">Weaning Weight (KG)</label>
                        <input type="number" name="wean_weight" id="wean_weight" placeholder="Weaning Weight"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="birth_weight">Birth Weight (KG)</label>
                        <input type="text" name="birth_weight" id="birth_weight" placeholder="Birth Weight"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="sire_id">Sire ID</label>
                        <input type="text" name="sire_id" id="sire_id" placeholder="Sire ID"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="dam_id">Dam ID</label>
                        <input type="text" name="dam_id" placeholder="Dam ID"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid md:col-span-2">
                        <label for="remarks">Remarks</label>
                        <textarea name="remarks" id="remarks" placeholder="Remarks"
                            class="border p-2 rounded focus:outline-none focus:rounded-none min-h-[10vh]"
                        ></textarea>
                    </div>
                    <div class="lg:col-span-2 flex flex-wrap justify-center gap-x-12 gap-y-2">
                        <button class="p-2 border bg-gradient-to-tr from-green-600 to-emerald-600 text-white w-full lg:max-w-[16rem] 
                            hover:shadow hover:to-green-600" type="submit" name="submit" value="add_animal_record">Add Record</button>
                        <button type="button" name="resetForm" class="p-2 border bg-gradient-to-tr from-rose-600 to-red-600 text-white 
                            w-full lg:max-w-[16rem] hover:shadow hover:from-red-600 hover:to-red-600">Reset</button>
                    </div>
                </div>
            </form>
        </div>
<?php
        elseif(getActivePageName() == "weight"):
?>
        <div id="add" class="hidden blocks bg-white p-2 my-1">
            <form action="" class="p-2 lg:p-4 z-10 w-full bg-white sm:m-auto" 
                name="add-form">
                <h1 class="pt-2 pb-4 text-xl capitalize">Add a new performance Record</h1>
                <div class="grid gap-2 bg-red-50 p-2">
                    <!-- message box -->
                    <div class="hidden message-box sticky top-2 p-2 text-center border lg:col-span-2">
                        <span>Some message to show</span>
                    </div>
                    
                    <!-- displayed input fields -->
                    <div class="grid">
                        <label for="animal_type">Animal Type</label>
                        <select type="text" name="animal_type" id="animal_type"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                            <?php if($superadmin || $user_data["department_id"] == 1) : ?>
                            <option value="cow">Cow</option>
                            <?php endif; ?>
                            <?php if($superadmin || $user_data["department_id"] == 2) : ?>
                            <option value="sheep">Sheep</option>
                            <option value="goat">Goat</option>
                            <?php endif; ?>
                            <?php if($superadmin || $user_data["department_id"] == 3) : ?>
                            <option value="pig">Pig</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="grid">
                        <label for="animal_id">Animal ID</label>
                        <input type="text" name="animal_id" id="animal_id" placeholder="Animal ID"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="animal_breed">Breed</label>
                        <input type="text" name="animal_breed" id="animal_breed" placeholder="Breed"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid">
                        <label for="animal_sex">Sex</label>
                        <select name="animal_sex" id="animal_sex"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="grid">
                        <label for="animal_weight">Animal Weight (KG)</label>
                        <input type="text" name="animal_weight" placeholder="Animal Weight"
                            class="border p-2 rounded focus:outline-none focus:rounded-none"
                        >
                    </div>
                    <div class="grid md:col-span-2">
                        <label for="remarks">Remarks</label>
                        <textarea name="remarks" id="remarks" placeholder="Remarks"
                            class="border p-2 rounded focus:outline-none focus:rounded-none min-h-[10vh]"
                        ></textarea>
                    </div>
                    <div class="lg:col-span-2 flex flex-wrap justify-center gap-x-12 gap-y-2">
                        <button class="p-2 border bg-gradient-to-tr from-green-600 to-emerald-600 text-white w-full lg:max-w-[16rem] 
                            hover:shadow hover:to-green-600" type="submit" name="submit" value="add_animal_weight">Add Record</button>
                        <button type="button" name="resetForm" class="p-2 border bg-gradient-to-tr from-rose-600 to-red-600 text-white 
                            w-full lg:max-w-[16rem] hover:shadow hover:from-red-600 hover:to-red-600">Reset</button>
                    </div>
                </div>
            </form>
        </div>
<?php
        endif;
    }
?>