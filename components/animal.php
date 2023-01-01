<?php 
    $animal = getDepartment($user_data["department_id"], false, "animal");
    if(is_array($animal)){
        $animal = $animal[0]["animal"];

        if(getActivePageName() == "performance"){
            $table = "performance_table";
        }elseif(getActivePageName() == "records"){
            $table = "records_table";
        }elseif(getActivePageName() == "weight"){
            $table = "weight_table";
        }

        if($user_data["department_id"] != 0){
            $sql = "SELECT * FROM $table WHERE ";
            if(strtolower($animal) != "sheep,goat"){
                $sql .= "animal_type='$animal'";
            }else{
                $sql .= "animal_type='sheep' OR animal_type='goat'";
            }
        }else{
            $sql = "SELECT * FROM $table";
        }

        $query = $connect->query($sql);
        if($query->num_rows > 0) :
            //displaying data from the performance table. This is the performance.php preview
            if(getActivePageName() == "performance") :
            while($row = $query->fetch_assoc()) :
                if(($superadmin && $row["animal_type"] != "pig") || $row["animal_type"] != "pig") :
?>
    <div class="p-2 border animal cursor-pointer hover:shadow" data-row-id="<?= $row["row_id"] ?>" data-animal-type="<?= $row["animal_type"] ?>">
        <div>
            <span data-id="<?= $row["animal_id"] ?>" class="font-semibold"><?= $row["animal_id"] ?></span>
            <span data-breed="<?= $row["animal_breed"] ?>" class="text-sm">- <?= $row["animal_breed"] ?></span>
        </div>
        <div class="grid grid-cols-3 mt-4 md:grid-cols-2 gap-1 text-sm">
            <span data-remark="<?= $row["remarks"] ?>" class="self-end col-span-2 md:col-span-1"><?= $row["remarks"] ?></span>
            <div class="grid">
                <span data-birth-type="<?= $row["birth_type"] ?>"><?= $row["birth_type"] ?></span>
                <span data-sex="<?= strtolower($row["animal_sex"]) ?>"><?= $row["animal_sex"] ?></span>
                <span data-bl-weight="<?= $row["birth_litter_weight"] ?>"><?= $row["birth_litter_weight"] ?> KG</span>
                <span data-sire-id="<?= $row["sire_id"] ?>"><?= $row["sire_id"] ?></span>
                <span data-suck-date="<?= $row["suck_date"] ?>"><?= $row["suck_date"] ?></span>
            </div>
        </div>
    </div>
    <?php elseif(($superadmin && $row["animal_type"] == "pig") || $row["animal_type"] == "pig") : ?>
    <div class="p-2 border animal cursor-pointer hover:shadow" data-row-id="<?= $row["row_id"] ?>" data-animal-type="<?= $row["animal_type"] ?>">
        <div>
            <span data-id="<?= $row["animal_id"] ?>" class="font-semibold"><?= $row["animal_id"] ?></span>
            <span data-breed="<?= $row["animal_breed"] ?>" class="text-sm">- <?= $row["animal_breed"] ?></span>
        </div>
        <div class="grid grid-cols-3 mt-4 md:grid-cols-1 gap-1 text-sm">
            <span data-remark="<?= $row["remarks"] ?>" class="self-end col-span-2 md:col-span-1"><?= $row["remarks"] ?></span>
            <div class="grid md:grid-cols-2 md:bg-blue-50/60 md:py-1 md:px-2">
                <span data-sex="<?= strtolower($row["animal_sex"]) ?>"><?= $row["animal_sex"] ?></span>
                <span data-bl-weight="<?= $row["birth_litter_weight"] ?>"><?= $row["birth_litter_weight"] ?> KG</span>
                <span data-litter-size="<?= $row["litter_size"] ?>"><?= $row["litter_size"] ?></span>
                <span data-sire-id="<?= $row["sire_id"] ?>"><?= $row["sire_id"] ?></span>
                <span data-suck-date="<?= $row["suck_date"] ?>"><?= $row["suck_date"] ?></span>
                <span data-offspring="<?= $row["offsprings"] ?>"><?= explode(",",$row["offsprings"])[0] ?> males, <?= explode(",",$row["offsprings"])[1] ?> females</span>
            </div>
        </div>  
    </div>
    <?php   
            endif;
            endwhile;

        //display data from the records table. This is the records.php preview
        elseif(getActivePageName() == "records") :
            while($row = $query->fetch_assoc()) :
                if(($superadmin && $row["animal_type"] != "pig") || $row["animal_type"] != "pig") :
?>
        <div class="p-2 border animal cursor-pointer hover:shadow" data-row-id="<?= $row["row_id"] ?>" data-animal-type="<?= $row["animal_type"] ?>">
            <div>
                <span data-id="<?= $row["animal_id"] ?>" class="font-semibold"><?= $row["animal_id"] ?></span>
                <span data-breed="<?= $row["animal_breed"] ?>"class="text-sm">- <?= $row["animal_breed"] ?></span>
            </div>
            <div class="grid grid-cols-3 mt-4 md:grid-cols-2 gap-1 text-sm">
                <span data-remark="<?= $row["remarks"] ?>" class="self-end col-span-2 md:col-span-1"><?= $row["remarks"] ?></span>
                <div class="grid">
                    <span data-sex="<?= strtolower($row["animal_sex"]) ?>"><?= $row["animal_sex"] ?></span>
                    <span data-b-weight="<?= $row["birth_weight"] ?>"><?= $row["birth_weight"] ?>kg</span>
                    <span data-sire-id="<?= $row["sire_id"] ?>">Sire: <?= $row["sire_id"] ?></span>
                    <span data-dam-id="<?= $row["dam_id"] ?>">Dam: <?= $row["dam_id"] ?></span>
                    <span data-dob="<?= $row["animal_dob"] ?>"><?= date("d M, Y", strtotime($row["animal_dob"])) ?></span>
                </div>
            </div>
        </div>
        <?php elseif(($superadmin && $row["animal_type"] == "pig") || $row["animal_type"] == "pig") : ?>
        <div class="p-2 border animal cursor-pointer hover:shadow" data-row-id="<?= $row["row_id"] ?>" data-animal-type="<?= $row["animal_type"] ?>">
            <div>
                <span data-id="<?= $row["animal_id"] ?>" class="font-semibold"><?= $row["animal_id"] ?></span>
                <span data-breed="<?= $row["animal_breed"] ?>"class="text-sm">- <?= $row["animal_breed"] ?></span>
            </div>
            <div class="grid grid-cols-3 mt-4 md:grid-cols-1 gap-1 text-sm">
                <span data-remark="<?= $row["remarks"] ?>" class="self-end col-span-2 md:col-span-1"><?= $row["remarks"] ?></span>
                <div class="grid md:grid-cols-2 md:bg-blue-50/60 md:py-1 md:px-2">
                    <span data-sex="<?= strtolower($row["animal_sex"]) ?>"><?= $row["animal_sex"] ?></span>
                    <span data-b-weight="<?= $row["birth_weight"] ?>"><?= $row["birth_weight"] ?>kg</span>
                    <span data-w-weight="<?= $row["weaning_weight"] ?>"><?= $row["weaning_weight"] ?></span>
                    <span data-sire-id="<?= $row["sire_id"] ?>">Sire: <?= $row["sire_id"] ?></span>
                    <span data-dam-id="<?= $row["dam_id"] ?>">Dam: <?= $row["dam_id"] ?></span>
                    <span data-dob="<?= $row["animal_dob"] ?>"><?= date("d M, Y", strtotime($row["animal_dob"])) ?></span>
                </div>
            </div>
        </div>
<?php
                endif;
            endwhile;
            elseif(getActivePageName() == "weight") : 
                while($row = $query->fetch_assoc()) :
?>
        <div class="p-2 border animal cursor-pointer hover:shadow" data-row-id="<?= $row["id"] ?>" data-animal-type="<?= $row["animal_type"] ?>">
            <div>
                <span data-id="<?= $row["animal_id"] ?>" class="font-semibold"><?= $row["animal_id"] ?></span>
                <span data-breed="<?= $row["animal_breed"] ?>" class="text-sm">- <?= $row["animal_breed"] ?></span>
            </div>
            <div class="grid grid-cols-3 mt-4 md:grid-cols-2 gap-1 text-sm">
                <span data-remark="<?= $row["remarks"] ?>" class="self-end col-span-2 md:col-span-1"><?= $row["remarks"] ?></span>
                <div class="grid">
                    <span data-sex="<?= strtolower($row["animal_sex"]) ?>"><?= $row["animal_sex"] ?></span>
                    <span data-weight="<?= $row["animal_weight"] ?>"><?= $row["animal_weight"] ?></span>
                    <span data-date="<?= $row["record_date"] ?>"><?= date("d M, Y", strtotime($row["record_date"])) ?></span>
                </div>
            </div>
        </div>
<?php 
                endwhile;
            endif;
        else:
?>
<div class="p-4 text-lg text-center border mt-4 mb-2 col-span-4 flex justify-center items-center">
    <p class="py-2 px-3 w-full">No items were found</p>
</div>
<?php
        endif;
    }
?>