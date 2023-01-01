<?php 
    /**
     * The function below would be used to get all departments in the database
     * @param string|int $key This is the name or id of the department specified. It defaults at all
     * @param boolean $convert_name This removes hyphens in department names
     * @param string $column This is the name of the column(s) to be selected
     * 
     * @return string|int|array Depending on the key, the result will differ
     */
    function getDepartment($key = "all", $convert_name=false, $column = null){
        global $connect;
        $response = null;

        if(!intval($key) && $key != "all" && $key != 0){
            if(!is_null($column)){
                $sql = "SELECT $column FROM departments WHERE dep_name='$key'";
            }else{
                $sql = "SELECT id FROM departments WHERE dep_name='$key'";
            }            
        }elseif($key == 0 || (!intval($key) && $key == "all")){
            $sql = "SELECT * FROM departments";
        }else{
            if(!is_null($column)){
                $sql = "SELECT $column FROM departments WHERE id=$key";
            }else{
                $sql = "SELECT dep_name FROM departments WHERE id=$key";
            }
        }

        $query = $connect->query($sql);

        if($query->num_rows > 0){
            if($key != "all" && $key != 0 && is_null($column)){
                if($convert_name && intval($key)){
                    $response = formatString($query->fetch_assoc()["dep_name"], "-", true);
                }else{
                    $response = $query->fetch_assoc()["id"];
                }
            }else{
                $response = [];
                while($row = $query->fetch_assoc()){
                    if($convert_name){
                        $row["dep_name"] = formatString($row["dep_name"], "-", true);
                    }

                    array_push($response, $row);
                }
            }

            if(is_array($response)){
                array_push($response, array(
                    "error" => false,
                    "message" => "Results returned from the department table were successful"
                ));
            }
            
        }else{
            $response = array(
                "error" => true,
                "message" => "Requested department key was not found. Please add it or prompt admin of the error"
            );
        }

        return $response;
    }

    /**
     * This function is used to convert strings into human readable formats
     * @param string $subject This is the string to be formatted
     * @param string $separator This defines the separator of the words
     * @param boolean $isProper This defines if the results should be made into proper form
     * 
     * @return string The final form is the formatted subject
     */
    function formatString($subject, $separator, $isProper = false){
        $separated = count(explode($separator, $subject));
        $subject = str_replace($separator," ",$subject);

        //capitalize
        if($isProper && $separated){
            $subject = ucwords($subject);
        }elseif($isProper){
            $subject = ucfirst($subject);
        }

        return $subject;
    }

    /**
     * This function returns the file name of the current active page
     * @return string The name of the current active page
     */
    function getActivePageName(){
        //get current path
        $current_path = $_SERVER["REQUEST_URI"];

        //extract script
        $script = explode("/",$current_path);

        //grab last element in the script array
        $script_name = end($script);

        //return only the first name before the dot
        return explode(".",$script_name)[0];
    }

    /**
     * This function is used to extract the information of a user from the database
     * @param int $user_id This is the user id to be used to retrieve the information
     * @param string $column This is an optional variable to determine which column(s) to retrieve
     * 
     * @return array|string Returns an array of results or a single result
     */
    function getUserData($user_id, $column = "all"){
        global $connect;

        $response = null;
        $sql = "";

        if($column == "all"){
            $sql = "SELECT * FROM users_table WHERE user_id = $user_id";
        }else{
            $sql = "SELECT $column FROM users_table WHERE user_id = $user_id";
        }

        $query = $connect->query($sql);

        if($query->num_rows == 1){
            $response = $query->fetch_assoc();
        }else{
            $response = "Requested user was not found";
        }
        
        return $response;
    }

    /**
     * This function is used to get the total number of an animal type
     * @param string $animal_type This is the type of animal to count
     * @param string $table This receives a specified table to make the count on
     * 
     * @return integer The total number of specified animal type
     */
    function countAnimalType($animal_type, $table="weight_table"){
        global $connect;

        $sql = "SELECT DISTINCT COUNT(animal_id) as total FROM $table WHERE animal_type = '$animal_type'";
        $query = $connect->query($sql);

        return intval($query->fetch_assoc()["total"]);
    }

    /**
     * This function returns a percentage count of the animal population rise
     * @param string $animal_type This is the animal type to check
     * @param string $table This is the table to make the count from
     * @param integer $month_count This receives the number of months to start from
     * 
     * @return string Returns a percentage format of the population rize
     */
    function populationRise($animal_type, $table = "weight_table", $month_count = 1){
        global $connect;
        
        //get last month
        $current_month = intval(date("n"));
        $current_year = intval(date("Y"));
        $last_year = $current_year;

        //prevent the provided month from being invalid
        if($month_count > 12){
            $last_year -= intval($month_count / 12);
            $month_count = $month_count % 12;
        }

        $last_month = $current_month - $month_count;

        if($last_month <= 0){
            $last_month += 12;
            $last_year -= 1;
        }

        $last_f_date = date("$last_year-$last_month-01");
        $last_l_date = date("Y-m-t", strtotime("$last_year-$last_month-01"));
        $this_f_date = date("Y-m-01");
        $this_l_date = date("Y-m-t");

        $psql = "SELECT COUNT(animal_id) as total FROM $table WHERE animal_type='$animal_type' AND (record_date >= '$last_f_date' AND record_date <= '$last_l_date')";
        $csql = "SELECT COUNT(animal_id) as total FROM $table WHERE animal_type='$animal_type' AND (record_date >= '$this_f_date' AND record_date <= '$this_l_date')";

        $pQuery = $connect->query($psql);
        $cQuery = $connect->query($csql);

        $final = $cQuery->fetch_assoc()["total"]; $init = $pQuery->fetch_assoc()["total"];
        $div = $init;

        if($div == 0){
            $div = 1;
        }

        return number_format((($final - $init) / $div) * 100, 2) . "%";
    }

    /**
     * This function would be used to determine the average weight of inputs
     * @param string $animal_type This is the type of animal to be checked on
     * @param string $table This is the table to be used to determine the average weight from
     * @param string $avg_column This is the column to be used to calculate the average weight
     * 
     * @return float returns the average weight
     */
    function getAverageWeight($animal_type, $table = "weight_table", $avg_column="animal_weight") {
        global $connect;

        $sql = "SELECT AVG($avg_column) as average FROM $table WHERE animal_type ='$animal_type'";
        $query = $connect->query($sql);

        return number_format($query->fetch_assoc()["average"], 2);
    }
?>