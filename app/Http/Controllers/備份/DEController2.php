<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Models\Episode;
use App\Models\Lesson;
use App\Models\Question;
use App\Http\Controllers\VuforiaController;
use App\Http\Controllers\_Vuforiacontroller;
class DBController extends Controller
{
    public function __construct(_Vuforiacontroller $_vws)
    {
        $this->_VWS = $_vws;
    }

    function add_episode(Request $req) {
        $req->validate(
            [
                'episode_name' => "required",
                'episode_description' => "required",
                'episode_image' => "required|file"
            ],
            [
                'required' => "*此為必填項目"
            ]
        );
        $newEpisode = new Episode;
        $newEpisode->episode_name = $req->episode_name;
        $newEpisode->episode_description = $req->episode_description;

        // Store image
        $name = $req->file('episode_image')->getClientOriginalName();
        $name = pathinfo($name, PATHINFO_FILENAME);
        $extension = $req->file('episode_image')->getClientOriginalExtension();
        $newName = $name.'_'.time().'.'.$extension;
        $path = $req->file('episode_image')->storeAs(
            'public/image', $newName
        );
        $newEpisode->episode_image = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image/".$newName;
        $newEpisode->episode_author = session()->get('user')->user_id;
        $newEpisode->participants = '[]';
        $newEpisode->save();

        $authorized_episode = str_replace(array( '[', ']' ), '', session()->get('user')->authorized_episode);
        if ($authorized_episode == "")
            $newAuthorized_episode = "[".strval($newEpisode->id)."]";
        else
            $newAuthorized_episode = "[".$authorized_episode.",".strval($newEpisode->id)."]";
        $user = DB::table('users')
            ->where('user_id', '=', session()->get('user')->user_id)
            ->update(['authorized_episode' => $newAuthorized_episode]);
        session([
            'user' => DB::table('users')
                ->where('user_id', '=', session()->get('user')->user_id)
                ->first()
        ]);

        return redirect()->route('home');
    }
    function add_lesson(Request $req) {
        $req->validate(
            [
                'lesson_name' => "required",
                'lesson_description' => "required",
                'lesson_image' => "required|file"
            ],
            [
                'required' => "*此為必填項目"
            ]
        );
        // DB::table('lessons')
        $newLesson = new Lesson;
        $newLesson->episode_id = $req->episode_id;
        $newLesson->lesson_id = $this->assign_lesson_id($req->episode_id);
        $newLesson->lesson_name = $req->lesson_name;
        $newLesson->lesson_description = $req->lesson_description;

        // Store image
        $name = $req->file('lesson_image')->getClientOriginalName();
        $name = pathinfo($name, PATHINFO_FILENAME);
        $extension = $req->file('lesson_image')->getClientOriginalExtension();
        $newName = $name.'_'.time().'.'.$extension;
        $path = $req->file('lesson_image')->storeAs(
            'public/image', $newName
        );
        $newLesson->lesson_image = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image/".$newName;

        $newLesson->save();
        return redirect()->route('lesson', [
            'episode_id' => $req->episode_id,
            'episode_name' => $req->episode_name,
        ]);
    }
////// function add_question(Request $req) {
    //     $req->validate(
    //         [
    //             'question_level' => "required",
    //             'image_url' => "required|file",
    //             'question' => "required",
    //             'hint_1' => "required",
    //             'hint_2' => "required",
    //             'answer' => "required",
    //             'chinese_answer' => "required"
    //         ],
    //         [
    //             'required' => "*此為必填項目"
    //         ]
    //     );

    //     $newQuestion = new Question;
    //     $newQuestion->question_id = 0;
    //     $newQuestion->episode_id = $req->episode_id;
    //     $newQuestion->lesson_id = $req->lesson_id;
    //     $newQuestion->question_level = $req->question_level;

    //     // Store image
    //     $name = $req->file('image_url')->getClientOriginalName();
    //     $name = pathinfo($name, PATHINFO_FILENAME);
    //     $extension = $req->file('image_url')->getClientOriginalExtension();
    //     $newName = $name.'_'.time().'.'.$extension;
    //     $path = $req->file('image_url')->storeAs(
    //         'public/image', $newName
    //     );
    //     $newQuestion->image_url = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image/".$newName;
    //     $vuforiaClient = new VuforiaController;
    //     $vuforiaMetaData = "test";
    //     $vuforiaTargetData = $vuforiaClient->addTarget(
    //         'storage/image',
    //         $newName,
    //         $vuforiaMetaData
    //     );
    //     $newQuestion->vuforia_id = $vuforiaTargetData->target_id;

    //     $newQuestion->question = $req->question;
    //     $newQuestion->hint_1 = $req->hint_1;
    //     $newQuestion->hint_2 = $req->hint_2;
    //     $newQuestion->answer = $req->answer;
    //     $newQuestion->chinese_answer = $req->chinese_answer;

    //     if ($vuforiaTargetData == 'none') {
    //         Storage::delete($path);
    //         throw ValidationException::withMessages(['image' => "Can't use this image as target. Choose another image instead."]);
    //     } else {
    //         $newQuestion->save();
    //         return redirect()->route('question', [
    //             'episode_id' => $req->episode_id,
    //             'lesson_id' => $req->lesson_id,
    //             'lesson_name' => $req->lesson_name
    //         ]);
    //     }
///// // }

    function add_question(Request $req) {
        
        $req->validate(
            [
                'question_level' => "required",
                'image_url' => "required|file",
                'question' => "required",
                'hint_1' => "required",
                'hint_2' => "required",
                'answer' => "required",
                'chinese_answer' => "required",
                
            ],
            [
                'required' => "*此為必填項目"
            ]
        );
        $newQuestion = new Question;
        $question_id = $this->assign_question_id($req->episode_id,$req->lesson_id);
        $newQuestion->question_id = $question_id;
        //$newQuestion->question_id = 0;
        $newQuestion->episode_id = $req->episode_id;
        $newQuestion->lesson_id = $req->lesson_id;
        $newQuestion->question_level = $req->question_level;
        //0907更改
        if($req->hasfile('model_url')){
            // Store model
            $model_name = $req->file('model_url')->getClientOriginalName();
            $model_name = pathinfo($model_name, PATHINFO_FILENAME);
            $model_extension = $req->file('model_url')->getClientOriginalExtension();
            ////////主檔案名(不包含附檔名)
            $Original_question_modelName = $model_name.'_'.time();
            $newmodel_Name = $Original_question_modelName.'.'.$model_extension;
            /////////////////////////
            $path = $req->file('model_url')->storeAs(
                'public/model', $newmodel_Name
            );
            $new_model_url = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/model/".$newmodel_Name;
        }
        else{
            $new_model_url = null;
        }
        // Store image
        $name = $req->file('image_url')->getClientOriginalName();
        $name = pathinfo($name, PATHINFO_FILENAME);
        $extension = $req->file('image_url')->getClientOriginalExtension();
        ////////主檔案名(不包含附檔名)
        $Original_question_imageName = $name.'_'.time();
        
        /////////////////////////
        $newName = $Original_question_imageName.'.'.$extension;
        $jsonName = $Original_question_imageName.".json";
        
        if(filesize($req->file('image_url')) > 2000000)
        {
            
            $img = $req->file('image_url');
            // Image::make($img)->resize(800, 800, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save(storage_path('app/public/image/'.$newName));
            $new_img = Image::make($img)->orientate();
            $path =Image::make($new_img)->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/image/'.$newName));
           
        }else{
            $img =$req->file('image_url');
            $new_img = Image::make($img)->orientate();
            $path =Image::make($new_img)->save(storage_path('app/public/image/'.$newName));
            //$img =$this->image_fix_orientation($img);
            // $path = $new_img->storeAs(
            // 'public/image', $newName
            // );
        }

        $new_image_url = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image/".$newName;
        $newQuestion->image_url = $new_image_url;
        $vuforiaClient = new VuforiaController;
        $vuforiaMetaData = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/".$jsonName;
        $vuforiaTargetData = $vuforiaClient->addTarget(
            'http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image',
            $newName,
            $vuforiaMetaData
        );
        
        $newQuestion->question = $req->question;
        $newQuestion->hint_1 = $req->hint_1;
        $newQuestion->hint_2 = $req->hint_2;
        $newQuestion->answer = $req->answer;
        $newQuestion->chinese_answer = $req->chinese_answer;
        $newQuestion->animal_model =$req->animal_model;
        $newQuestion->model_url =$new_model_url;
        $newQuestion->Model_setting_ratotion_x =0;
        $newQuestion->Model_setting_ratotion_y =0;
        $newQuestion->Model_setting_ratotion_z =0;
        $newQuestion->Model_setting_position_x =387;
        $newQuestion->Model_setting_position_y =-119;
        $newQuestion->Model_setting_position_z =-55;
        $newQuestion->Model_setting_size =1;
        ///////新增/////////
        $newQuestion->Original_question_imageName = $Original_question_imageName;
        if ($vuforiaTargetData == 'none') {
            Storage::delete($path);
            throw ValidationException::withMessages(['image' => "Can't use this image as target. Choose another image instead."]);
        } else {
            $newQuestion->vuforia_id =$vuforiaTargetData->target_id;
        ////////////如果圖片重複記錄起來/////////
            $id=$vuforiaTargetData->target_id;
            //echo $id;
            //$_vuforiacontroller = new _vuforiacontroller;
            $vws_similar_check = (array)((array)$this->_VWS->DublicateCheck($id))['similar_targets'];
            $DuplicateTarget = false;
            if(count($vws_similar_check))
            {
                //Similar Target
                $DuplicateTarget = true;
            }
            $newQuestion->DuplicateTarget = $DuplicateTarget;
        ///////////////////////////////////////
            
            $newQuestion->save();

            $infodata = array( 
                "episode_id"=>$req->episode_id, 
                "lesson_id"=>$req->lesson_id,
                "question_id"=>$question_id,
                "question_level"=>$req->question_level,
                "image_url"=>$new_image_url ,
                "question"=>$req->question,
                "hint_1"=>$req->hint_1,
                "hint_2"=>$req->hint_2,
                "answer"=>$req->answer,
                "chinese_answer"=>$req->chinese_answer,
                "animal_model"=>$req->animal_model,
                "model_url" =>$new_model_url ,
                "Model_setting_ratotion_x"=>0,
                "Model_setting_ratotion_y"=>0,
                "Model_setting_ratotion_z"=>0,
                "Model_setting_size"=>1
            );
            $jsondata = json_encode($infodata);
            Storage::put($jsonName, $jsondata);
            
            return redirect()->route('question', [
                'episode_id' => $req->episode_id,
                'lesson_id' => $req->lesson_id,
                'lesson_name' => $req->lesson_name
            ]);
        }
    }
    function add_question_csv(Request $req) {
        if (is_null($req->csv_file))
            throw ValidationException::withMessages(['uploadCSV' => "You haven't select a csv file"]);
        
        $file = $req->csv_file->path();
        $delimiter = ',';
        $headerSample = ['question_level','image_url','question','hint_1','hint_2','answer','chinese_answer', 'Question_model'];
        $header = null;
        $data = array();
        if (($handle = fopen($file, 'r')) !== false)
        {
            $fileContent = file_get_contents($file);
            $encoding = mb_detect_encoding($fileContent);
            if ($encoding != "UTF-8")
                throw ValidationException::withMessages(['uploadCSV' => "Please make sure the encoding format is \"UTF-8\""]);
            while (($row = $this->__fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                {
                    $header = $row;
                    $header[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[0]);
                    if ($header !== $headerSample)
                        throw ValidationException::withMessages([
                            'message' => "Please use following words and order as header:",
                            'header_error' => $headerSample
                        ]);

                }
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        $err = FALSE;
        $time = time();
        $counter = 1;
        $failedRows = ["Failed datas in csv file: "];
        foreach($data as $d)
        {
            ///讀取image_url的值(路徑位置)並下載與改名
            $fileOriPath = $d['image_url'];
            //如為空抱錯
            if (!file_exists($fileOriPath)) {
                $err = TRUE;
                array_push($failedRows, $fileOriPath." ---- at row ".($counter + 1).": File-image Not Found");
                continue;
            }
            $image = file_get_contents($fileOriPath);
            $extension = substr($fileOriPath, strrpos($fileOriPath, '.') + 1);
            $name = pathinfo($fileOriPath, PATHINFO_FILENAME);
            $Original_question_imageName = $name.'_'.$time.$counter;
            $newName = $Original_question_imageName.'.'.$extension;
            $jsonName = $Original_question_imageName.".json";
            if (strtolower($extension) != "jpg" && strtolower($extension) != "png" && strtolower($extension) != "jpeg") {
                $err = TRUE;
                array_push($failedRows, $fileOriPath." ---- at row ".($counter + 1).": Invalid File Format");
                continue;
            }
            ///////////////更改儲存方式
            //$path = Storage::disk('image')->put($newName, $image);
            
            $new_img = Image::make($image)->orientate();
            $path =Image::make($new_img)->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
            })->save(storage_path('app/public/image/'.$newName));

            ///以下為讀取Question_model的值(路徑位置)並下載與改名
            $file_model_location = $d['Question_model'];
            //如為空跳過
            if (!file_exists($file_model_location)) {
                // $err = TRUE;
                // array_push($failedRows, $file_model_location." ---- at row ".($counter + 1).": File-model Not Found");
                //continue;
                $new_model_url =null;
                
            }
            else{
                //讀取整個文件進入一個字串符中
                $model = file_get_contents($file_model_location);
                //抓取Question_model的值並抓取最後一個" . "後的字串為副檔名
                $model_extension = substr($file_model_location, strrpos($file_model_location, '.') + 1);
                //獲取檔案名
                $name = pathinfo($file_model_location, PATHINFO_FILENAME);
                //設置model檔案名稱(+上時間搓記)
                $Original_question_modelName = $name.'_'.$time.$counter;
                $model_newName = $Original_question_modelName.'.'.$model_extension;
                //核對副檔名是否為glb gltf
                if (strtolower($model_extension) != "glb" && strtolower($model_extension) != "gltf") {
                    $err = TRUE;
                    array_push($failedRows, $file_model_location." ---- at row ".($counter + 1).": Invalid File Format");
                    continue;
                }
                $model_path = Storage::disk('model')->put($model_newName, $model);
                $new_model_url = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/model/".$model_newName;
            }
            

            $new_image_url = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image/".$newName;
            
            $vuforiaClient = new VuforiaController;
            $vuforiaMetaData = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/".$jsonName;
            
            $vuforiaTargetData = $vuforiaClient->addTarget(
                'http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image',
                $newName,
                $vuforiaMetaData
            );
    
            if ($vuforiaTargetData == 'none')
            {
                Storage::delete($path);
                Storage::delete($model_path);
                $err = TRUE;
                array_push($failedRows, $fileOriPath." ---- at row ".($counter + 1).": Invalid Image");
            }
            else
            {               
                $newQuestion = new Question;
                $question_id = $this->assign_question_id($req->episode_id,$req->lesson_id);
                $newQuestion->question_id = $question_id;
                $newQuestion->episode_id = $req->episode_id;
                $newQuestion->lesson_id = $req->lesson_id;
                $newQuestion->question_level = $d['question_level'];

                $newQuestion->image_url = $new_image_url;
                $newQuestion->vuforia_id = $vuforiaTargetData->target_id;
                ////////////如果圖片重複記錄起來/////////
                $id=$vuforiaTargetData->target_id;
                //echo $id;
                //$_vuforiacontroller = new _vuforiacontroller;
                $vws_similar_check = (array)((array)$this->_VWS->DublicateCheck($id))['similar_targets'];
                $DuplicateTarget = false;
                if(count($vws_similar_check))
                {
                    //Similar Target
                    $DuplicateTarget = true;
                }
                $newQuestion->DuplicateTarget = $DuplicateTarget;
                ///////////////////////////////////////
                
                $newQuestion->question = $d['question'];
                $newQuestion->hint_1 = $d['hint_1'];
                $newQuestion->hint_2 = $d['hint_2'];
                $newQuestion->answer = $d['answer'];
                $newQuestion->chinese_answer = $d['chinese_answer'];
                $newQuestion->model_url = $new_model_url;
                //model ratotion (x y z) size
                $newQuestion->Model_setting_ratotion_x = 0;
                $newQuestion->Model_setting_ratotion_y = 0;
                $newQuestion->Model_setting_ratotion_z = 0;

                $newQuestion->Model_setting_position_x =387;
                $newQuestion->Model_setting_position_y =-119;
                $newQuestion->Model_setting_position_z =-55;
                
                $newQuestion->Model_setting_size = 1;
                $newQuestion->Original_question_imageName = $Original_question_imageName;
    
                $newQuestion->save();
                $infodata = array( 
                    "episode_id"=>$req->episode_id, 
                    "lesson_id"=>$req->lesson_id,
                    "question_id"=>$question_id,
                    "question_level"=>$newQuestion->question_level,
                    "image_url"=>$new_image_url ,
                    "question"=>$newQuestion->question,
                    "hint_1"=>$newQuestion->hint_1,
                    "hint_2"=>$newQuestion->hint_2,
                    "answer"=>$newQuestion->answer,
                    "chinese_answer"=>$newQuestion->chinese_answer,
                    "model_url"=>$new_model_url,
                    "Model_setting_ratotion_x"=>0,
                    "Model_setting_ratotion_y"=>0,
                    "Model_setting_ratotion_z"=>0,
                    "Model_setting_size"=>1
                );
                $jsondata = json_encode($infodata);
                Storage::put($jsonName, $jsondata);
            }
            $counter += 1;
        }
        if ($err)
            throw ValidationException::withMessages([
                'csvErr' => "Can't upload some of the targets.",
                'failedRows' => $failedRows
            ]);
        else
            return redirect()->route('question', [
                'episode_id' => $req->episode_id,
                'lesson_id' => $req->lesson_id,
                'lesson_name' => $req->lesson_name
            ]);
    }

    function delete_episode(Request $req) {
        $episode_id = $req->episode_id;
        ///////////刪除stroage下的圖片/////////////
        $old_episode = DB::table('episodes')->where('episode_id', '=', $episode_id)->first();
        $old_episode_imageurl =$old_episode->episode_image;
        $old_episode_imagename = substr($old_episode_imageurl, strrpos($old_episode_imageurl, "/") + 1);

        Storage::delete('public/image/'.$old_episode_imagename);

        //////////////////////////////////////////
        $episode = DB::table('episodes')->where('episode_id', '=', $episode_id)->delete();


        ///////////刪除stroage下的圖片/////////////
        $old_lesson = DB::table('lessons')->where('episode_id', '=', $episode_id)->get();

        foreach($old_lesson as $value ){
            $old_lesson_imageurl =$value->lesson_image;
            $old_lesson_imagename = substr($old_lesson_imageurl, strrpos($old_lesson_imageurl, "/") + 1);
            Storage::delete('public/image/'.$old_lesson_imagename);
        }

        //////////////////////////////////////////
        $lessons = DB::table('lessons')->where('lessons.episode_id', $episode_id)->delete();

        ///////////刪除stroage下的圖片/////////////
        $old_question = DB::table('questions')->where('episode_id', '=', $req->episode_id)
        ->where('lesson_id', $req->lesson_id)->get();

        foreach($old_question as $value ){
            $old_question_imageurl =$value->image_url;
            $old_question_imagename = substr($old_question_imageurl, strrpos($old_question_imageurl, "/") + 1);
            Storage::delete('public/image/'.$old_question_imagename);
        }

        ///////////////////////////////////////////////////////

        $question = DB::table('questions')->where('questions.episode_id', $episode_id)->delete();
        

        // Update user's authorized_episode
        $user = DB::table('users')
            ->where('user_id', '=', session()->get('user')->user_id)
            ->first();
        $newAuthorized_episode_array = array_map('intval', explode(',', str_replace(array( '[', ']' ), '', $user->authorized_episode)));
        array_splice($newAuthorized_episode_array, array_search($episode_id, $newAuthorized_episode_array), 1);
        $newAuthorized_episode_string = "[";
        foreach($newAuthorized_episode_array as $ep) {
            $newAuthorized_episode_string = $newAuthorized_episode_string.strval($ep).",";
        }
        $newAuthorized_episode_string = rtrim($newAuthorized_episode_string, ", ")."]";
        $user = DB::table('users')
            ->where('user_id', '=', session()->get('user')->user_id)
            ->update(['authorized_episode' => $newAuthorized_episode_string]);
        session([
            'user' => DB::table('users')
                ->where('user_id', '=', session()->get('user')->user_id)
                ->first()
        ]);

        //Storage::delete($path);
        return redirect()->route('home');
    }
    function delete_lesson(Request $req) {

        ///////////刪除stroage下的圖片/////////////
        $old_lesson = DB::table('lessons')->where('episode_id', '=', $req->episode_id)
        ->where('lesson_id', $req->lesson_id)->first();
        $old_lesson_imageurl =$old_lesson->lesson_image;
        $old_lesson_imagename = substr($old_lesson_imageurl, strrpos($old_lesson_imageurl, "/") + 1);

        Storage::delete('public/image/'.$old_lesson_imagename);
        ///////////////////////////////////////////////////////


        ///////////刪除stroage下的圖片/////////////
        $old_question = DB::table('questions')->where('episode_id', '=', $req->episode_id)
        ->where('lesson_id', $req->lesson_id)->get();

        foreach($old_question as $value ){
            $old_question_imageurl =$value->image_url;
            $old_question_imagename = substr($old_question_imageurl, strrpos($old_question_imageurl, "/") + 1);
            Storage::delete('public/image/'.$old_question_imagename);
        }

        ///////////////////////////////////////////////////////
        $lessons = DB::table('lessons')
            ->where('lessons.episode_id', $req->episode_id)
            ->where('lessons.lesson_id', $req->lesson_id)
            ->delete();
        $question = DB::table('questions')
            ->where('questions.episode_id', $req->episode_id)
            ->where('questions.lesson_id', $req->lesson_id)
            ->delete();
        $this->assign_lesson_id($req->episode_id);
        return redirect()->route('lesson', [
            'episode_id' => $req->episode_id,
            'episode_name' => $req->episode_name,
        ]);
    }
    
    function delete_question(Request $req) {

        ///////////刪除stroage下的圖片/////////////
        $old_question = DB::table('questions')->where('episode_id', '=', $req->episode_id)
        ->where('lesson_id', $req->lesson_id)->where('question_id', $req->question_id)->first();
        $old_question_imageurl =$old_question->image_url;
        $old_question_imagename = substr($old_question_imageurl, strrpos($old_question_imageurl, "/") + 1);

        Storage::delete('public/image/'.$old_question_imagename);
        ///////////////////////////////////////////////////////
        $question = DB::table('questions')
            ->where('questions.episode_id', $req->episode_id)
            ->where('questions.lesson_id', $req->lesson_id)
            ->where('questions.question_id', $req->question_id);
        $vuforia_id = $question->first()->vuforia_id;
        $vuforiaClient = new VuforiaController;
        $vuforiaResponse = $vuforiaClient->deleteTarget($vuforia_id);
        $question->delete();
        return redirect()->route('question', [
            'episode_id' => $req->episode_id,
            'lesson_id' => $req->lesson_id,
            'lesson_name' => $req->lesson_name
        ]);
    }
    function edit_episode(Request $req){
        //echo "welcome to edit_episode";
        $episode_name = $req->episode_name;
        $episode_id = $req->episode_id;
        $episode_description = $req->episode_description;
        $episode_image = $req->episode_image;
        
        $name = $req->file('episode_image')->getClientOriginalName();
        $name = pathinfo($name, PATHINFO_FILENAME);
        $extension = $req->file('episode_image')->getClientOriginalExtension();
        $newName = $name.'_'.time().'.'.$extension;
        //storage::put 會創建一個$newName名子的資料夾然後將檔案放到裡面
        //Storage::put($newName, $episode_image);
        $req->file('episode_image')->storeAs(
            'public/image', $newName
        );
        ///////////刪除stroage下的圖片/////////////
        $old_episode = DB::table('episodes')->where('episode_id', '=', $episode_id)->first();
        $old_episode_imageurl =$old_episode->episode_image;
        $old_episode_imagename = substr($old_episode_imageurl, strrpos($old_episode_imageurl, "/") + 1);

        Storage::delete('public/image/'.$old_episode_imagename);

        //////////////////////////////////////////
        

        $episode_image = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image/".$newName;
        $affected = DB::table('episodes')
              ->where('episode_id', $episode_id)
              ->update(['episode_name' => $episode_name,
                        'episode_description' => $episode_description,
                        'episode_image' => $episode_image
                        ]);
        
        
        return redirect()->route('home');
    }
    // function testDB(){
    //     $result=DB::table('lessons')->where('episode_id' ,3)
    //         ->where('lesson_id' ,1)->get();
    //     // $lesson_name = $result->lesson_name;
    //     // $lesson_description = $result->lesson_description;
    //     // $lesson_image = $result->lesson_image;
    //     return $result;
    // }
    function edit_lesson(Request $req){
        //echo "welcome to edit_episode";
        $episode_name = $req->episode_name;
        $lesson_name = $req->lesson_name;
        $lesson_id = $req->lesson_id;
        $episode_id = $req->episode_id;     
        $lesson_description = $req->lesson_description;
        $lesson_image = $req->lesson_image;
        
        $name = $req->file('lesson_image')->getClientOriginalName();
        $name = pathinfo($name, PATHINFO_FILENAME);
        $extension = $req->file('lesson_image')->getClientOriginalExtension();
        $newName = $name.'_'.time().'.'.$extension;
        //storage::put 會創建一個$newName名子的資料夾然後將檔案放到裡面
        //Storage::put($newName, $episode_image);
        $req->file('lesson_image')->storeAs(
            'public/image', $newName
        );
        ///////////刪除stroage下的圖片/////////////
        $old_lesson = DB::table('lessons')->where('episode_id', '=', $req->episode_id)
        ->where('lesson_id', $req->lesson_id)->first();
        $old_lesson_imageurl =$old_lesson->lesson_image;
        $old_lesson_imagename = substr($old_lesson_imageurl, strrpos($old_lesson_imageurl, "/") + 1);

        Storage::delete('public/image/'.$old_lesson_imagename);
        ///////////////////////////////////////////////////////

        $Lesson_image = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image/".$newName;
        $affected = DB::table('lessons')
              ->where('episode_id', $episode_id)->where('lesson_id', $lesson_id)
              ->update(['lesson_image' => $Lesson_image,
                        'lesson_description' => $lesson_description,
                        'lesson_name' => $lesson_name
                        ]);
        
        
         return redirect()->route('lesson', [
            'episode_id' => $episode_id,
            'episode_name' => $episode_name,
        ]);
    }

    function edit_question(Request $req){
        $lesson_name = $req->lesson_name;
        $lesson_id = $req->lesson_id;
        $episode_id = $req->episode_id; 
        $question_id = $req->question_id;
        $question_level = $req->question_level;
        $question = $req->question;
        $hint_1 = $req->hint_1;
        $hint_2 = $req->hint_2;
        $answer = $req->answer;
        $chinese_answer = $req->chinese_answer;
        $animal_model =$req->animal_model;

        $question_info = DB::table('questions')
            ->where('episode_id', $episode_id)
            ->where('lesson_id', $lesson_id)
            ->where('question_id', $question_id)->first();
        ////////////////////////////
            //刪除舊的json黨(目前新增question表中的一格欄位Original_question_imageName來記錄圖片名稱 也方便刪除)
        $Original_question_imageName = $question_info->Original_question_imageName;
        $old_jsonName = $Original_question_imageName.".json";
        Storage::delete($old_jsonName);
        /////////////Store model//////////////////////
        if($req->hasfile('model_url')){

            $model_name = $req->file('model_url')->getClientOriginalName();
            $model_name = pathinfo($model_name, PATHINFO_FILENAME);
            $model_extension = $req->file('model_url')->getClientOriginalExtension();
            ////////主檔案名(不包含附檔名)
            $Original_question_modelName = $model_name.'_'.time();
            $newmodel_Name = $Original_question_modelName.'.'.$model_extension;
            /////////////////////////
            $path = $req->file('model_url')->storeAs(
                'public/model', $newmodel_Name
            );
            $new_model_url = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/model/".$newmodel_Name;
            }
        else{
            
            $new_model_url =$question_info->model_url;

        }
        // Store image
        $image_url = $req->image_url;
        if($req->hasfile('image_url')){
            //刪除vuforia的原圖片
            $vuforia_id = $question_info->vuforia_id;
            $vuforiaClient = new VuforiaController;
            $vuforiaResponse = $vuforiaClient->deleteTarget($vuforia_id);
            //進行圖片處理
            $name = $req->file('image_url')->getClientOriginalName();
            $name = pathinfo($name, PATHINFO_FILENAME);
            $extension = $req->file('image_url')->getClientOriginalExtension();
            $Original_question_imageName = $name.'_'.time();
        
            /////////////////////////
            $newName = $Original_question_imageName.'.'.$extension;
            $jsonName = $Original_question_imageName.".json";
            if(filesize($req->file('image_url')) > 2000000)
            {
                $img = $req->file('image_url');
                $new_img = Image::make($img)->orientate();
                Image::make($new_img)->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/image/'.$newName));
            }
            else{
                $img =$req->file('image_url');
                $new_img = Image::make($img)->orientate();
                $path =Image::make($new_img)->save(storage_path('app/public/image/'.$newName));
            }
            ///////////刪除stroage下的圖片/////////////
            $old_question = DB::table('questions')->where('episode_id', '=', $req->episode_id)
            ->where('lesson_id', $req->lesson_id)->where('question_id', $req->question_id)->first();
            $old_question_imageurl =$old_question->image_url;
            $old_question_imagename = substr($old_question_imageurl, strrpos($old_question_imageurl, "/") + 1);
            Storage::delete('public/image/'.$old_question_imagename);
            ///////////////////////////////////////////////////////
            $new_image_url = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image/".$newName;
            ////獲得table中的image_url
            $image_url = $new_image_url;

            $vuforiaClient = new VuforiaController;
            $vuforiaMetaData = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/".$jsonName;
            $vuforiaTargetData = $vuforiaClient->addTarget(
                'http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image',
                $newName,
                $vuforiaMetaData
            );
            $vuforia_id = $vuforiaTargetData->target_id;
            ////////////如果圖片重複記錄起來/////////
            $id=$vuforiaTargetData->target_id;
            echo $id;
            $vws_similar_check = (array)((array)$this->_VWS->DublicateCheck($id))['similar_targets'];
            ////獲得table中的DuplicateTarget
            $DuplicateTarget = false;
            if(count($vws_similar_check))
                {
                    //Similar Target
                    $DuplicateTarget = true;
                }
            /////////////////////////////////////////
            //json
            if ($vuforiaTargetData == 'none') {
                    Storage::delete($path);
                    throw ValidationException::withMessages(['image' => "Can't use this image as target. Choose another image instead."]);
            } 
            else {
                $infodata = array( 
                    "episode_id"=>$req->episode_id, 
                    "lesson_id"=>$req->lesson_id,
                    "question_id"=>$req->question_id,
                    "question_level"=>$req->question_level,

                    //"image_url"=>$new_image_url ,
                    "image_url"=>$image_url,
                    "question"=>$req->question,
                    "hint_1"=>$req->hint_1,
                    "hint_2"=>$req->hint_2,
                    "answer"=>$req->answer,
                    "chinese_answer"=>$req->chinese_answer,
                    "animal_model" =>$req->animal_model,
                    "model_url" =>$new_model_url ,
                    "Model_setting_ratotion_x"=>123,
                    "Model_setting_ratotion_y"=>0,
                    "Model_setting_ratotion_z"=>0,
                    "Model_setting_size"=>1
                 );
                $jsondata = json_encode($infodata);
                ///////
                Storage::put($jsonName, $jsondata);
            }
        }
        else{
            ////////////如果圖片重複記錄起來/////////
            $vuforia_id=$question_info->vuforia_id;
            //echo $vuforia_id;
            $vws_similar_check = (array)((array)$this->_VWS->DublicateCheck($vuforia_id))['similar_targets'];
            ////獲得table中的DuplicateTarget
            $DuplicateTarget = false;
            if(count($vws_similar_check))
                {
                    //Similar Target
                    $DuplicateTarget = true;
                }
            /////////////////////////////////////////
            $Original_question_imageName = $question_info->Original_question_imageName;
            $image_url = $question_info->image_url;
            //$DuplicateTarget = $question_info->DuplicateTarget;
            $infodata = array( 
                "episode_id"=>$req->episode_id, 
                "lesson_id"=>$req->lesson_id,
                "question_id"=>$req->question_id,
                "question_level"=>$req->question_level,

                //"image_url"=>$new_image_url ,
                "image_url"=>$image_url,
                "question"=>$req->question,
                "hint_1"=>$req->hint_1,
                "hint_2"=>$req->hint_2,
                "answer"=>$req->answer,
                "chinese_answer"=>$req->chinese_answer,
                "animal_model" =>$req->animal_model,
                "model_url" =>$new_model_url ,
                "Model_setting_ratotion_x"=>0,
                "Model_setting_ratotion_y"=>123,
                "Model_setting_ratotion_z"=>0,
                "Model_setting_size"=>1
            );
            $jsondata = json_encode($infodata);
            ///////
            //$jsonName =$question_info->image_url;
            Storage::put($old_jsonName, $jsondata);
            
            ////////
        }
        

        ///////////////////////////////////////

        $affected = DB::table('questions')
        ->where('episode_id', $episode_id)->where('lesson_id', $lesson_id)->where('question_id', $question_id)
        ->update(['question_level' => $question_level,
                    'image_url' => $image_url,
                    'vuforia_id'=> $vuforia_id,
                    'question' => $req->question,
                    'hint_1' => $hint_1,
                    'hint_2' => $hint_2,
                    'answer' => $answer,
                    'chinese_answer' => $chinese_answer,
                    'Original_question_imageName'=>$Original_question_imageName,
                    'animal_model'=>$animal_model,
                    "model_url" =>$new_model_url ,
                    'DuplicateTarget'=>$DuplicateTarget
        ]);
        return redirect()->route('question', [
            'episode_id' => $req->episode_id,
            'lesson_id' => $req->lesson_id,
            'lesson_name' => $req->lesson_name
        ]);
    }
    function reupload_question(Request $req){
        $episode_id = $req->episode_id;
        $lesson_id = $req->lesson_id;
        $question_id = $req->question_id;

        $Oldquestion_info = DB::table('questions')
            ->where('episode_id', $episode_id)
            ->where('lesson_id', $lesson_id)
            ->where('question_id', $question_id)->first();
        //獲得副檔名
        $image_url = $Oldquestion_info->image_url;
        $extension = substr($image_url, strrpos($image_url, '.') + 1);
        //獲得圖片完整名稱(含副檔名)
        $Original_question_imageName = $Oldquestion_info->Original_question_imageName;
        $newName = $Original_question_imageName.'.'.$extension;
        //獲得json檔案名稱
        $jsonName = $Original_question_imageName.'.json';
        //新增資料到vuforia cloud database
        $vuforiaClient = new VuforiaController;
        $vuforiaMetaData = "http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/".$jsonName;
        $vuforiaTargetData = $vuforiaClient->addTarget(
            'http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image',
            $newName,
            $vuforiaMetaData
        );
        $vuforia_id =$vuforiaTargetData->target_id;
        ////////////如果圖片重複記錄起來/////////
        $vws_similar_check = (array)((array)$this->_VWS->DublicateCheck($vuforia_id))['similar_targets'];
        $DuplicateTarget = false;
        if(count($vws_similar_check))
        {
            //Similar Target
            $DuplicateTarget = true;
        }
        $affected = DB::table('questions')
        ->where('episode_id', $episode_id)->where('lesson_id', $lesson_id)->where('question_id', $question_id)
        ->update([
                    'vuforia_id'=> $vuforia_id,
                    'DuplicateTarget'=>$DuplicateTarget
        ]);
        if($affected){
            //echo $vuforia_id;
            return redirect()->route('question', [
                'episode_id' => $req->episode_id,
                'lesson_id' => $req->lesson_id,
                'lesson_name' => $req->lesson_name
            ])->with('alert', 'reupload success!');
        }

    }
    function assign_lesson_id($episode_id) {
        $counter = 1;
        $lessons = DB::table('lessons')
            ->where('episode_id', $episode_id);
        foreach($lessons->get() as $lesson) {
            $OriLesson_id = $lesson->lesson_id;
            $lessons->where('lesson_id', $OriLesson_id)->update(['lesson_id' => $counter]);
            $questions = DB::table('questions')
                ->where('episode_id', $episode_id)
                ->where('lesson_id', $OriLesson_id)
                ->update(['lesson_id' => $counter]);
            $counter += 1;
        }
        return $counter;
    }
    function assign_question_id($episode_id, $lesson_id){
        $counter = 1;
        $questions = DB::table('questions')
            ->where('episode_id', $episode_id)->where('lesson_id', $lesson_id);
        foreach($questions->get() as $question) {
            $Oriquestion_id = $question->question_id;
            $questions->where('question_id', $Oriquestion_id)->update(['question_id' => $counter]);
            // $questions = DB::table('questions')
            //     ->where('episode_id', $episode_id)
            //     ->where('lesson_id', $lesson_id)
            //     ->where('question_id', $Oriquestion_id)
            //     ->update(['question_id' => $counter]);
            $counter += 1;
        }
        return $counter;
    }
    function __fgetcsv(&$handle, $length = null, $d = ",", $e = '"') {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        $eof = false;
        while ($eof != true) {
            $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
            $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
            if ($itemcnt % 2 == 0) {
                $eof = true;
            }
        }
        $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));
     
        $_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];
     
        for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
            $_csv_data[$_csv_i] = preg_replace("/^" . $e . "(.*)" . $e . "$/s", "$1", $_csv_data[$_csv_i]);
            $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
        }
        return empty($_line) ? false : $_csv_data;
    }
    function image_fix_orientation($image){
        //$image = imagecreatefromjpeg($path);
        $exif = exif_read_data($image);
        
        if (!empty($exif['Orientation'])) {
        switch ($exif['Orientation']) {
        case 3:
        $image = imagerotate($image, 180, 0);
        break;
        case 6:
        $image = imagerotate($image, -90, 0);
        break;
        case 8:
        $image = imagerotate($image, 90, 0);
        break;
        }
        return $image;
        }
    }
}