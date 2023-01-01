<?php 
    include_once("functions.php");

    $host = "localhost";
    $host_username = "root";
    $host_password = "";
    $host_db = "farms";

    //the connection string
    $connect = new mysqli($host, $host_username, $host_password, $host_db);

    //check for an error
    if($connect->connect_error){
        die("Error connecting to database: " . $connect->connect_error);
        exit(1);
    }

    //creating a default root path for finding php documents
    $rootPath = $_SERVER["DOCUMENT_ROOT"]."/farms";

    //creating a default url for folder files
    //grabbing protocol
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== "off" || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    //adding the domain name
    $domain_name = $_SERVER['HTTP_HOST'];

    //$url = $protocol.$domain_name;
    $url = $protocol.$domain_name."/farms";

    //start user session
    if(session_status() == PHP_SESSION_DISABLED || session_status() == PHP_SESSION_NONE)
        session_start();

    //user data
    if(isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0){
        $user_data = getUserData($_SESSION["user_id"]);

        if(!is_array($user_data)){
            echo $user_data;
            exit(1);
        }else{
            $superadmin = false;
            //check if user is a superadmin
            if($user_data["department_id"] == 0){
                $superadmin = true;
            }
        }
    }else{
        //refer user to login
        $activePage = getActivePageName();

        if($activePage != "submit")
            header("location: ./");
    }
?>