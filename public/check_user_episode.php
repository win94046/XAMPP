<?php
    //isset($_POST["is_teacher"]) && !empty($_POST["is_teacher"])
    // if (isset($_POST["username"]) && !empty($_POST["username"]) && 
    //     isset($_POST["password"]) && !empty($_POST["password"])
    //     ){
        
    // }
    // else{
    //     //Login(23011228, 23011228);
    // }
    check_episode($_POST["username"]);
    function check_episode($username){
        $servername = "134.208.3.123";
        $server_username = "mitlabA323";
        $server_password = "csieA323";
        $dbname = "ar_english_learning";  
        $conn = mysqli_connect($servername, $server_username, $server_password, $dbname);
        //$userpassword =sha1($password);
        $sql = "SELECT * FROM users WHERE 
        user_name = '$username';";		
        $result = mysqli_query($conn,$sql) or die("0:Name check query failed");
        // if (mysqli_num_rows($result)!=1)
        // {
        // 	echo '0:wrong username,please register';
        // 	exit();
        // }
        
        $existinginfo = mysqli_fetch_assoc($result);
        //資料庫使用者的密碼
        // $pass = $existinginfo["user_password"];
        // if (password_verify($password, $pass))
        // {
            
        //     echo $username;
        // }
        // else{
        //     echo "0:Incorrect password";
        //     exit();
        // }
        //新增測試
        
        $json=json_decode($existinginfo["authorized_episode"]);
        $string_array=implode(",",$json);
        echo ",".$string_array.",";
        
    }
    
?>
