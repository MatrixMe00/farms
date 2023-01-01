<?php 
    include_once("server/connect.php");

    //return values
    $message = "";
    $error = false;

    if(@$_REQUEST["submit"]){
        $submit = $_REQUEST["submit"];

        if($submit == "getDepartment"){
            //set defaults
            $key = 0;
            $convert_name = true;

            //set the values if they are requested
            if(isset($_REQUEST["key"])){
                $key = $_REQUEST["key"];
            }

            if(isset($_REQUEST["convert_name"])){
                $convert_name = $_REQUEST["convert_name"];
            }

            //retrieve response from server
            $response = getDepartment($key, $convert_name);

            //return in json format
            echo json_encode($response);
            return;
        }elseif($submit == "create_account" || $submit == "log_in"){
            $username = ""; $password = ""; $fname = "";
            $lname = ""; $department = 0; $gender = "";

            //create account
            if($submit == "create_account"){
                //check for needed details
                if(!isset($_POST["fname"]) || (isset($_POST["fname"]) && $_POST["fname"] == "")){
                    $message = "Please enter your firstname";
                    $error = true;
                }elseif(!isset($_POST["lname"]) || (isset($_POST["lname"]) && $_POST["lname"] == "")){
                    $message = "Please enter your lastname";
                    $error = true;
                }elseif(!isset($_POST["gender"]) || (isset($_POST["gender"]) && $_POST["gender"] == "")){
                    $message = "Please select your gender";
                    $error = true;
                }elseif(!isset($_POST["department"]) || (isset($_POST["department"]) && $_POST["department"] == "")){
                    $message = "Department you belong to cannot be blank";
                    $error = true;
                }else{
                    $fname = ucfirst($_POST["fname"]);
                    $lname = ucfirst($_POST["lname"]);
                    $gender = $_POST["gender"];
                    $department = intval($_POST["department"]);
                }
            }

            if(!$error){
                //check username and password
                if(!isset($_POST["username"]) || (isset($_POST["username"]) && $_POST["username"] == "")){
                    $message = "Please provide a username";
                    $error = true;
                }elseif(!isset($_POST["password"]) || (isset($_POST["password"]) && $_POST["password"] == "")){
                    $message = "Please enter a password";
                    $error = true;
                }else{
                    $username = $_POST["username"];
                    $password = MD5($_POST["password"]);
                }

                if(!$error){
                    //check if username exists
                    $sql = "SELECT username FROM users_table WHERE username='$username'";
                    $query = $connect->query($sql);

                    if($query->num_rows > 0){
                        //create user
                        if($submit == "create_account"){
                            $message = "Username already exists, please provide a new one";
                        }else{
                            //check password
                            $sql = "SELECT user_id FROM users_table WHERE username='$username' AND password='$password'";
                            $query = $connect->query($sql);
                            
                            if($query->num_rows > 0){
                                $message = "login-success";

                                //create a session
                                $_SESSION["user_id"] = $query->fetch_assoc()["user_id"];
                            }else{
                                $message = "Password is incorrect. Please try again";
                                $error = true;
                            }
                        }
                    }else{
                        //create user
                        if($submit == "create_account"){
                            $sql = "INSERT INTO users_table (fname,lname, username, password,gender, department_id) 
                                VALUES(?,?,?,?,?,?)";
                            $stmt = $connect->prepare($sql);
                            $stmt->bind_param("sssssi", $fname, $lname, $username, $password, $gender, $department);
                            $stmt->execute();

                            $message = "insert-success";
                        }else{
                            //report to login that username is not valid
                            $message = "Username was not found. Check and try again";
                            $error = true;
                        }
                    }
                }
            }
        }elseif($submit == "update_animal_performance" || $submit == "add_animal_performance"){
            $update = false; $add = false;
            if($submit == "update_animal_performance"){
                $update = true;
            }else{
                $add = true;
            }

            //serialize data
            if(!isset($_REQUEST["animal_id"]) || $_REQUEST["animal_id"] == ""){
                $message = "Please provide the id of the requested animal";
                $error = true;
            }elseif(!isset($_REQUEST["animal_type"]) || $_REQUEST["animal_type"] == ""){
                $message = "Please specify the type or kind of animal";
                $error = true;
            }elseif(!isset($_REQUEST["animal_breed"]) || $_REQUEST["animal_breed"] == ""){
                $message = "Animal's breed was not specified";
                $error = true;
            }elseif(!isset($_REQUEST["animal_sex"]) || $_REQUEST["animal_sex"] == ""){
                $message = "Animal's sex was not specified";
                $error = true;
            }elseif(!isset($_REQUEST["suck_date"]) || $_REQUEST["suck_date"] == ""){
                if(strtolower($_REQUEST["animal_type"]) == "cow"){
                    $message = "Please specify the calving date";
                }elseif(strtolower($_REQUEST["animal_type"]) == "goat"){
                    $message = "Please specify the kidding date";
                }elseif(strtolower($_REQUEST["animal_type"]) == "sheep"){
                    $message = "Please specify the lambing date";
                }else{
                    $message = "Please specify the farrowing date";
                }
                $error = true;
            }elseif(strtolower($_REQUEST["animal_type"]) != "pig" && (!isset($_REQUEST["birth_type"]) || $_REQUEST["birth_type"] == "")){
                $message = "Type of Birth cannot be blank";
                $error = true;
            }elseif(strtolower($_REQUEST["animal_type"]) == "pig" && (!isset($_REQUEST["litter_size"]) || $_REQUEST["litter_size"] == "")){
                $message = "Litter size not specified";
                $error = true;
            }elseif(!isset($_REQUEST["birth_litter_weight"]) || !floatval($_REQUEST["birth_litter_weight"])){
                if(strtolower($_REQUEST["animal_type"]) != "pig"){
                    $message = "Please provide a valid birth weight";
                }else{
                    $message = "Please provide a valid litter weight";
                }
                $error = true;
            }elseif(strtolower($_REQUEST["animal_type"]) == "pig" && (!isset($_REQUEST["male_pigs"]) || $_REQUEST["male_pigs"] == "")){
                $message = "Provide a valid number of male piglets";
                $error = true;
            }elseif(strtolower($_REQUEST["animal_type"]) == "pig" && (!isset($_REQUEST["female_pigs"]) || $_REQUEST["female_pigs"] == "")){
                $message = "Provide a valid number of female piglets";
                $error = true;
            }elseif(!isset($_REQUEST["sire_id"]) || $_REQUEST["sire_id"] == ""){
                $message = "Sire ID was left blank. Please provide it";
                $error = true;
            }elseif(!isset($_REQUEST["remarks"]) || $_REQUEST["remarks"] == ""){
                $message = "Please provide a remark for this animal";
                $error = true;
            }

            //make sure a row id is provided
            if($update){
                if(!isset($_REQUEST["row_id"]) || $_REQUEST["row_id"] == ""){
                    $message = "Operation stopped. Could not find row of requested animal";
                    $error = true;
                }
            }

            if(!$error){
                $sql = "";

                //get the data
                $animal_id = $_REQUEST["animal_id"];
                $animal_type = $_REQUEST["animal_type"];
                $animal_breed = $_REQUEST["animal_breed"];
                $animal_sex = $_REQUEST["animal_sex"];
                $suck_date = date("Y-m-d",strtotime($_REQUEST["suck_date"]));
                $birth_litter_weight = floatval($_REQUEST["birth_litter_weight"]);
                $sire_id = $_REQUEST["sire_id"];
                $remarks = $_REQUEST["remarks"];

                $update_set = "";
                $insert_cols = "";
                $insert_vals = "";
                $types = "";
                
                if($animal_type != "pig"){
                    $birth_type = $_REQUEST["birth_type"];

                    if($update){
                        $update_set = "animal_id=?, animal_breed=?, animal_sex=?, animal_type=?, suck_date=?,
                        birth_type=?, birth_litter_weight=?, sire_id=?, remarks=?";
                    }else{
                        $insert_cols = "animal_id, animal_breed, animal_sex, animal_type, suck_date, birth_type, 
                        birth_litter_weight, sire_id, remarks";

                        $insert_vals = "?,?,?,?,?,?,?,?,?";
                    }

                    $types="ssssssdss";
                }else{
                    $litter_size = intval($_REQUEST["litter_size"]);
                    $male_pigs = intval($_REQUEST["male_pigs"]);
                    $female_pigs = intval($_REQUEST["female_pigs"]);
                    
                    if($update){
                        $update_set = "animal_id=?, animal_breed=?, animal_sex=?, animal_type=?, suck_date=?,
                        litter_size=?, offsprings=?, birth_litter_weight=?, sire_id=?, remarks=?";
                    }else{
                        $insert_cols = "animal_id, animal_breed, animal_sex, animal_type, suck_date, litter_size, 
                        offsprings, birth_litter_weight, sire_id, remarks";

                        $insert_vals = "?,?,?,?,?,?,?,?,?,?";
                    }

                    $types = "sssssisdss";
                }

                if($update){
                    $row_id = $_REQUEST["row_id"];
                    $sql = "UPDATE performance_table SET $update_set WHERE row_id = $row_id";
                }else{
                    $sql = "INSERT INTO performance_table ($insert_cols) VALUES ($insert_vals)";
                }

                $stmt = $connect->prepare($sql);
                
                if($animal_type != "pig"){
                    $stmt->bind_param($types, $animal_id, $animal_breed, $animal_sex, $animal_type, $suck_date, $birth_type, 
                        $birth_litter_weight, $sire_id, $remarks);
                }else{
                    $offsprings = $male_pigs.",".$female_pigs;
                    $stmt->bind_param($types, $animal_id, $animal_breed, $animal_sex, $animal_type, $suck_date, $litter_size, 
                        $offsprings, $birth_litter_weight, $sire_id, $remarks);
                }

                //execute command
                $stmt->execute();

                if($update)
                    $message = "Details of <strong>$animal_id</strong> updated successfully";
                else
                    $message = "Details of <strong>$animal_id</strong> was added successfully";
            }
        }elseif($submit == "update_animal_record" || $submit == "add_animal_record"){
            $update = false; $add = false;
            if($submit == "update_animal_record"){
                $update = true;
            }else{
                $add = true;
            }

            //serialize data
            if(!isset($_REQUEST["animal_id"]) || $_REQUEST["animal_id"] == ""){
                $message = "Please provide the id of the requested animal";
                $error = true;
            }elseif(!isset($_REQUEST["animal_type"]) || $_REQUEST["animal_type"] == ""){
                $message = "Please specify the type or kind of animal";
                $error = true;
            }elseif(!isset($_REQUEST["animal_breed"]) || $_REQUEST["animal_breed"] == ""){
                $message = "Animal's breed was not specified";
                $error = true;
            }elseif(!isset($_REQUEST["dob"]) || $_REQUEST["dob"] == ""){
                $message = "Please provide the date of birth";
                $error = true;
            }elseif(!isset($_REQUEST["animal_sex"]) || $_REQUEST["animal_sex"] == ""){
                $message = "Sex of animal cannot be empty";
                $error = true;
            }elseif(strtolower($_REQUEST["animal_type"]) == "pig" && (!isset($_REQUEST["wean_weight"]) || $_REQUEST["wean_weight"] == "")){
                $message = "Weaning weight not specified";
                $error = true;
            }elseif(!isset($_REQUEST["birth_weight"]) || !floatval($_REQUEST["birth_weight"])){
                $message = "Please provide the birth weight";
                $error = true;
            }elseif(!isset($_REQUEST["sire_id"]) || $_REQUEST["sire_id"] == ""){
                $message = "Sire ID was left blank. Please provide it";
                $error = true;
            }elseif(!isset($_REQUEST["dam_id"]) || $_REQUEST["dam_id"] == ""){
                $message = "Dam ID was left blank. Please provide it";
                $error = true;
            }elseif(!isset($_REQUEST["remarks"]) || $_REQUEST["remarks"] == ""){
                $message = "Please provide a remark for this animal";
                $error = true;
            }

            //make sure a row id is provided
            if($update){
                if(!isset($_REQUEST["row_id"]) || $_REQUEST["row_id"] == ""){
                    $message = "Operation stopped. Could not find row of requested animal";
                    $error = true;
                }
            }

            if(!$error){
                $sql = "";

                //get the data
                $animal_id = $_REQUEST["animal_id"];
                $animal_type = $_REQUEST["animal_type"];
                $animal_breed = $_REQUEST["animal_breed"];
                $animal_dob = date("Y-m-d",strtotime($_REQUEST["dob"]));
                $birth_weight = floatval($_REQUEST["birth_weight"]);
                $sire_id = $_REQUEST["sire_id"];
                $dam_id = $_REQUEST["dam_id"];
                $remarks = $_REQUEST["remarks"];
                $animal_sex = $_REQUEST["animal_sex"];

                $update_set = "";
                $insert_cols = "";
                $insert_vals = "";
                $types = "";
                
                if($animal_type == "pig"){
                    $wean_weight = $_REQUEST["wean_weight"];

                    if($update){
                        $update_set = "animal_id=?, animal_type=?, animal_dob=?, animal_sex=?, birth_weight=?,
                        animal_breed=?, weaning_weight=?, dam_id=?, sire_id=?, remarks=?
                        ";
                    }else{
                        $insert_cols = "animal_id, animal_type, animal_dob, animal_sex, birth_weight,
                        animal_breed, weaning_weight, dam_id, sire_id, remarks
                        ";

                        $insert_vals = "?,?,?,?,?,?,?,?,?,?";
                    }

                    $types="ssssdsdsss";
                }else{                    
                    if($update){
                        $update_set = "animal_id=?, animal_type=?, animal_dob=?, animal_sex=?, birth_weight=?,
                        animal_breed=?, dam_id=?, sire_id=?, remarks=?
                        ";
                    }else{
                        $insert_cols = "animal_id, animal_type, animal_dob, animal_sex, birth_weight,
                        animal_breed, dam_id, sire_id, remarks
                        ";

                        $insert_vals = "?,?,?,?,?,?,?,?,?";
                    }

                    $types = "ssssdssss";
                }

                if($update){
                    $sql = "UPDATE records_table SET $update_set WHERE animal_id = '$animal_id'";
                }else{
                    $sql = "INSERT INTO records_table ($insert_cols) VALUES ($insert_vals)";
                }

                $stmt = $connect->prepare($sql);
                
                if($animal_type != "pig"){
                    $stmt->bind_param($types, $animal_id, $animal_type, $animal_dob, $animal_sex, $birth_weight,
                        $animal_breed, $dam_id, $sire_id, $remarks);
                }else{
                    $stmt->bind_param($types, $animal_id, $animal_type, $animal_dob, $animal_sex, $birth_weight,
                        $animal_breed, $wean_weight, $dam_id, $sire_id, $remarks);
                }

                //execute command
                $stmt->execute();

                if($update)
                    $message = "Details of <strong>$animal_id</strong> updated successfully";
                else
                    $message = "Details of <strong>$animal_id</strong> was added successfully";
            }
        }elseif($submit == "update_animal_weight" || $submit == "add_animal_weight"){
            $update = false; $add = false;
            if($submit == "update_animal_weight"){
                $update = true;
            }else{
                $add = true;
            }

            //serialize data
            if(!isset($_REQUEST["animal_id"]) || $_REQUEST["animal_id"] == ""){
                $message = "Please provide the id of the requested animal";
                $error = true;
            }elseif(!isset($_REQUEST["animal_type"]) || $_REQUEST["animal_type"] == ""){
                $message = "Please specify the type or kind of animal";
                $error = true;
            }elseif(!isset($_REQUEST["animal_breed"]) || $_REQUEST["animal_breed"] == ""){
                $message = "Animal's breed was not specified";
                $error = true;
            }elseif(!isset($_REQUEST["animal_sex"]) || $_REQUEST["animal_sex"] == ""){
                $message = "Sex of animal cannot be empty";
                $error = true;
            }elseif(!isset($_REQUEST["animal_weight"]) || !floatval($_REQUEST["animal_weight"])){
                $message = "Please provide the weight of the animal";
                $error = true;
            }elseif(!isset($_REQUEST["remarks"]) || $_REQUEST["remarks"] == ""){
                $message = "Please provide a remark for this animal";
                $error = true;
            }

            //make sure a row id is provided
            if($update){
                if(!isset($_REQUEST["row_id"]) || $_REQUEST["row_id"] == ""){
                    $message = "Operation stopped. Could not find row of requested animal record";
                    $error = true;
                }
            }

            if(!$error){
                $sql = "";

                //get the data
                $animal_id = $_REQUEST["animal_id"];
                $animal_type = $_REQUEST["animal_type"];
                $animal_breed = $_REQUEST["animal_breed"];
                $animal_sex = $_REQUEST["animal_sex"];    
                $animal_weight = floatval($_REQUEST["animal_weight"]);
                $remarks = $_REQUEST["remarks"];
                $animal_record = "";
                $update_set = "";
                $insert_cols = "";
                $insert_vals = "";
                $types = "";
                
                if($update){
                    $update_set = "animal_id=?, animal_type=?, animal_sex=?,
                    animal_breed=?, animal_weight=?, remarks=?
                    ";

                    $types = "ssssds";
                }else{
                    $animal_record = date("Y-m-d");
                    $insert_cols = "animal_id, animal_type, animal_sex,
                    animal_breed, animal_weight, remarks, record_date";

                    $insert_vals = "?,?,?,?,?,?,?";

                    $types = "ssssdss";
                }

                if($update){
                    $row_id = $_REQUEST["row_id"];
                    $sql = "UPDATE weight_table SET $update_set WHERE id = $row_id";
                }else{
                    $sql = "INSERT INTO weight_table ($insert_cols) VALUES ($insert_vals)";
                }

                $stmt = $connect->prepare($sql);
                
                if($update){
                    $stmt->bind_param($types, $animal_id, $animal_type, $animal_sex,
                    $animal_breed, $animal_weight, $remarks);
                }else{
                    $stmt->bind_param($types, $animal_id, $animal_type, $animal_sex,
                    $animal_breed, $animal_weight, $remarks, $animal_record);
                }

                //execute command
                $stmt->execute();

                if($update)
                    $message = "Details of <strong>$animal_id</strong> updated successfully";
                else
                    $message = "Weight details of <strong>$animal_id</strong> was added successfully";
            }
        }elseif($submit == "delete_item"){
            $table = $_REQUEST["table"];
            $row_id = $_REQUEST["row_id"];

            if(intval($row_id) || $row_id != ""){
                if($table == "performance_table" || $table == "records_table")
                    $sql = "DELETE FROM $table WHERE row_id = $row_id";
                elseif($table == "weight_table")
                    $sql = "DELETE FROM $table WHERE id = $row_id";

                if($connect->query($sql)){
                    $message = "Selected animal detail have been deleted";
                }else{
                    $message = "Animal details could not be deleted. Please try again";
                    $error = true;
                }
            }else{
                $message = "A row was not selected";
                $error = true;
            }
            
        }
    }else{
        $message = "No submit request sent";
        $error = true;
    }

    //return response
    $response = [
        "error" => $error,
        "message" => $message
    ];

    echo json_encode($response);
?>