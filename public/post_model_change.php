<?php
    //$datas = array();
    
    change_model_info((float)$_POST["Model_ratotion_x"], (float)$_POST["Model_ratotion_y"],(float)$_POST["Model_ratotion_z"],(float)$_POST["Model_size"],(float)$_POST["Model_position_x"]
         ,(float)$_POST["Model_position_y"] , (float)$_POST["Model_position_z"] , $_POST["episode_id"],$_POST["lesson_id"] ,$_POST["question_id"] );
    // if (
    //     isset($_POST["episode_id"]) && !empty($_POST["episode_id"]) &&
    //     isset($_POST["lesson_id"]) && !empty($_POST["lesson_id"]) &&
    //     isset($_POST["question_id"]) && !empty($_POST["question_id"]) &&
    //     isset($_POST["Model_ratotion_x"]) && !empty($_POST["Model_ratotion_x"]) && 
    //     isset($_POST["Model_ratotion_y"]) && !empty($_POST["Model_ratotion_y"])&&
    //     isset($_POST["Model_ratotion_z"]) && !empty($_POST["Model_ratotion_z"])&&
    //     isset($_POST["Model_size"]) && !empty($_POST["Model_size"])&&
    //     isset($_POST["Model_position_x"]) && !empty($_POST["Model_position_x"])&&
    //     isset($_POST["Model_position_y"]) && !empty($_POST["Model_position_y"])&&
    //     isset($_POST["Model_position_z"]) && !empty($_POST["Model_position_z"])
        
    //     ){
    //     change_model_info((float)$_POST["Model_ratotion_x"], (float)$_POST["Model_ratotion_y"],(float)$_POST["Model_ratotion_z"],(float)$_POST["Model_size"],(float)$_POST["Model_position_x"]
    //     ,(float)$_POST["Model_position_y"] , (float)$_POST["Model_position_z"] , $_POST["episode_id"],$_POST["lesson_id"] ,$_POST["question_id"] );

    // }
    // else{
    //     echo (float)$_POST["Model_ratotion_x"]."  and  " .(float)$_POST["Model_ratotion_y"]."  and  " .(float)$_POST["Model_ratotion_z"]."  and  " .(float)$_POST["Model_size"]."  and  " .(float)$_POST["Model_position_x"]
    //     ."  and  " .(float)$_POST["Model_position_y"]."  and  " . (float)$_POST["Model_position_z"] ."  and  " . $_POST["episode_id"]."  and  " .$_POST["lesson_id"] ."  and  " .$_POST["question_id"]  ;
    //     //change_model_info( 0 , 190 , 0, 200 , 316.2935 , -110.6849, -54.96169 , 73 , 1 , 1 );
    // }

    function change_model_info( float $Model_ratotion_x , float $Model_ratotion_y , float $Model_ratotion_z , float $Model_setting_size , float $Model_position_x , float $Model_position_y , float $Model_position_z , int $episode_id
    , int $lesson_id , int $question_id){
        //echo $episode_id."+".$lesson_id."+".$question_id;
        $servername = "134.208.3.123";
    	$server_username = "mitlabA323";
    	$server_password = "csieA323";
    	$dbname = "ar_english_learning";  
        $conn = mysqli_connect($servername, $server_username, $server_password, $dbname);

        $sql = "UPDATE questions SET Model_setting_ratotion_x = '$Model_ratotion_x' ,Model_setting_ratotion_y='$Model_ratotion_y', Model_setting_ratotion_z='$Model_ratotion_z' 
        , Model_setting_size='$Model_setting_size' , Model_setting_position_x='$Model_position_x' ,
        Model_setting_position_y='$Model_position_y', Model_setting_position_z='$Model_position_z'  
        WHERE questions.episode_id= '$episode_id' AND questions.lesson_id = '$lesson_id' AND questions.question_id = '$question_id' ";
        $result = mysqli_query($conn,$sql);
            /////////用json顯示$request
        if ($result) {
            //  echo "update successfully ".$Model_ratotion_x."+".$Model_ratotion_y."+".$Model_ratotion_z."+".$Model_setting_size."+".
            //  $Model_position_x."+".$Model_position_y."+".$Model_position_z;
            echo "update successfully ";
        }
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        // foreach ($datas as $key => $value){
        //     //echo $datas;
        //     $Model_setting_ratotion_x[] = $value['Model_setting_ratotion_x'];
        //     $Model_setting_ratotion_y[] = $value['Model_setting_ratotion_y'];
        //     $Model_setting_ratotion_z[] = $value['Model_setting_ratotion_z'];
        //     $Model_setting_size[] = $value['Model_setting_size'];
        // }
        // echo json_encode($datas);    

        mysqli_close($conn);
    }

    //mysqli_close($conn);

?>