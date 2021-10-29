<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DBController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/auth', [MainController::class, 'auth'])->name('auth');
Route::post('/regis', [MainController::class, 'register'])->name('regis');

Route::group(['middleware' => 'loginCheck'], function() {
    Route::get('/', function() {
        return redirect()->route('login');
    });
    Route::view('/login', 'login')->name('login');
    Route::view('/register', 'register')->name('register');
    Route::get('/logout', [MainController::class, 'logout'])->name('logout');

    Route::get('/home', [MainController::class, 'home'])->name('home');
    Route::get('/lesson', [MainController::class, 'lesson'])->name('lesson');
    Route::get('/question', [MainController::class, 'question'])->name('question');
    Route::view('/add_episode', 'add_episode')->name('add.episode.view');
    Route::get('/add_lesson', function(Request $req) {
        return view('add_lesson', [
            'episode_name' => $req->episode_name,
            'episode_id' => $req->episode_id
        ]);
    })->name('add.lesson.view');
    Route::get('/add_question', function(Request $req) {
        return view('add_question', [
            'episode_id' => $req->episode_id,
            'lesson_id' => $req->lesson_id,
            'lesson_name' => $req->lesson_name
        ]);
    })->name('add.question.view');
    
    Route::get('/edit_episode', function(Request $req) {
        return view('edit_episode', [
            'episode_name' => $req->episode_name,
            'episode_id' => $req->episode_id,
            'episode_description' =>$req->episode_description,
            'episode_image'=>$req->episode_image
        ]);
    })->name('edit.episode.view');
    Route::get('/edit_lesson', function(Request $req) {
        $result=DB::table('lessons')->where('episode_id' ,$req->episode_id)
            ->where('lesson_id' ,$req->lesson_id)->first();
        $lesson_name=$result->lesson_name;
        $lesson_description=$result->lesson_description;
        $lesson_image=$result->lesson_image;
        // foreach($result as $value){
        //     $lesson_name
        // }
        return view('edit_Lesson', [
            'episode_name' =>$req->episode_name,
            'lesson_name' =>$lesson_name,
            'lesson_id' => $req->lesson_id,
            'episode_id'=> $req->episode_id,
            'lesson_name'=> $lesson_name,
            'lesson_description'=>$lesson_description,
            'lesson_image' =>$lesson_image
        ]);
    })->name('edit.lesson.view');

    Route::get('/edit_question', function(Request $req) {
        $result=DB::table('questions')
            ->where('episode_id' ,$req->episode_id)
            ->where('lesson_id' ,$req->lesson_id)
            ->where('question_id' ,$req->question_id)->first();
        $question_level=$result->question_level;
        $animal_model = $result->animal_model;
        $image_url=$result->image_url;
        $question=$result->question;
        $hint_1=$result->hint_1;
        $hint_2=$result->hint_2;
        $answer=$result->answer;
        $chinese_answer = $result->chinese_answer;
        //1016+
        $Choose = $result->Choose;
        ////獲得model name
        $model_url = $result->model_url;
        if($model_url != null){
            $model_name = substr($model_url, strrpos($model_url, "/") + 1);
        }
        else{
            $model_name =null;
        }
        $youtube_url = $result->youtube_url;
        //+

        //獲取圖片名稱
        $image_name = substr($image_url, strrpos($image_url, '/') + 1);

        
        return view('edit_question', [
            'episode_id'=> $req->episode_id,
            'lesson_id' => $req->lesson_id,
            'lesson_name'=> $req->lesson_name,
            'question_id' => $req->question_id,
            'question_level'=> $question_level,
            "animal_model"=>$animal_model,
            'image_url' => $image_url,
            'question'=> $question,
            'hint_1' => $hint_1,
            'hint_2'=> $hint_2,
            'answer' => $answer,
            'chinese_answer'=> $chinese_answer,
            //1016+
            'Choose'=> $Choose,
            'model_name'=> $model_name,
            'youtube_url'=> $youtube_url,  
            //+
        ]);
    })->name('edit.question.view');

    Route::post('/add/episode', [DBController::class, 'add_episode'])->name('add.episode');
    Route::post('/delete/episode', [DBController::class, 'delete_episode'])->name('delete.episode');
    Route::post('/edit/episode', [DBController::class, 'edit_episode'])->name('edit.episode');
    
    Route::post('/add/lesson', [DBController::class, 'add_lesson'])->name('add.lesson');
    Route::post('/delete/lesson', [DBController::class, 'delete_lesson'])->name('delete.lesson');
    Route::post('/edit/lesson', [DBController::class, 'edit_lesson'])->name('edit.lesson');

    Route::post('/add/question', [DBController::class, 'add_question'])->name('add.question');
    Route::post('/delete/question', [DBController::class, 'delete_question'])->name('delete.question');
    Route::post('/reupload/question', [DBController::class, 'reupload_question'])->name('reupload.question');
    Route::post('/edit/question', [DBController::class, 'edit_question'])->name('edit.question');
    Route::post('/add/question/csv', [DBController::class, 'add_question_csv'])->name('add.question.csv');
    //Route::get('/testDB', [DBController::class, 'testDB']);



});
