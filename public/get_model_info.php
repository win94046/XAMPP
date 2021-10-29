<?php
    //$datas = array();
    
    if (isset($_POST["episode_id"]) && !empty($_POST["episode_id"]) && 
        isset($_POST["lesson_id"]) && !empty($_POST["lesson_id"])&&
        isset($_POST["question_id"]) && !empty($_POST["question_id"])
        ){
        get_model_info($_POST["episode_id"], $_POST["lesson_id"] , $_POST["question_id"]);
    }
    else{
        get_model_info( 73 , 1 , 1);
    }

    function get_model_info( int $episode_id , int $lesson_id , int $question_id){
        //echo $episode_id."+".$lesson_id."+".$question_id;
        $servername = "134.208.3.123";
    	$server_username = "mitlabA323";
    	$server_password = "csieA323";
    	$dbname = "ar_english_learning";  
        $conn = mysqli_connect($servername, $server_username, $server_password, $dbname);

        $sql = "SELECT Model_setting_ratotion_x,Model_setting_ratotion_y , Model_setting_ratotion_z , Model_setting_size , Model_setting_position_x ,
        Model_setting_position_y , Model_setting_position_z FROM questions 
        WHERE questions.episode_id= '$episode_id' AND questions.lesson_id = '$lesson_id' AND questions.question_id = '$question_id' ";
        $result = mysqli_query($conn,$sql);
            /////////用json顯示$request
        if ($result) {
            // echo "Join successfully";
            if (mysqli_num_rows($result)>0) {
                while ($row = mysqli_fetch_assoc($result)) {
                // 每跑一次迴圈就抓一筆值，最後放進data陣列中
                    $datas[] = $row;
                }
                //echo json_encode($datas);
                foreach ($datas as $key => $value){

                    // echo $value['Model_setting_ratotion_x'];
                    // echo $value['Model_setting_ratotion_y'];
                    // echo $value['Model_setting_ratotion_z'];
                    // echo $value['Model_setting_size'];
                    ////用標點符號把每個value隔開，然後用unity去抓UnityWebRequest.text//////////////////////////////
                    echo $value['Model_setting_ratotion_x']."&".$value['Model_setting_ratotion_y']."&".$value['Model_setting_ratotion_z']."&".$value['Model_setting_size']
                    ."&".$value['Model_setting_position_x']."&".$value['Model_setting_position_y']."&".$value['Model_setting_position_z'];



                }
            //mysqli_free_result($result);
            }
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



        // //////用表單形式顯示$request
        // echo "<p> 表單 </p>";
        // echo "<table border = '2'><tr align='center'>";
        // while ($meta = mysqli_fetch_field($result)) {
        //     echo "<td> $meta->name </td>";
        // }
        // echo "</tr>";
        // while($row=mysqli_fetch_row($result)) {
        //     echo "<tr>";
        //     for($j=0; $j<mysqli_num_fields($result); $j++) {
        //         echo "<td>$row[$j]</td>";
        //     }
        //     echo "</tr>";
        // }
        // echo "</table>";
        mysqli_close($conn);



    }



?>