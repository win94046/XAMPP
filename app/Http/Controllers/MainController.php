<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Episode;
use App\Models\Lesson;
use App\Models\Question;
use App\Http\Controllers\VuforiaController;


use App\Http\Controllers\_VuforiaWebServices;



class MainController extends Controller
{  
    



    // User authentication
    function auth(Request $req)
    {
        $req->validate(
            [
                'username' => "required",
                'password' => "required"
            ],
            [
                'username.required' => '*請輸入帳號',
                'password.required' => '*請輸入密碼'
            ]
        );

        // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
        $user = DB::table('users')
            ->where('user_name', '=', $req->username)
            ->first();
        if ($user) {

            //if (Hash::check($req->password, $user->user_password))
            if (password_verify($req->password, $user->user_password))
            {
                session(['user' => $user]);
                return redirect()->route('home');
            } else {
                throw ValidationException::withMessages(['password' => "*輸入密碼錯誤"]);
            }
        }
        else {
            throw ValidationException::withMessages(['username' => "*沒有此帳號"]);
        }
    }
    function register(Request $req)
    {
        $req->validate(
            [
                'email' => "required|email",
                'username' => "required|unique:users,user_name",
                'password' => "required|min:8|confirmed"
            ],
            [
                'email.required' => '*請輸入電子信箱帳號',
                'email.email' => '*非有效電子信箱帳號',
                'username.required' => '*請輸入帳號',
                'username.unique' => '*帳號已存在，請另設帳號',
                'password.required' => '*請輸入密碼',
                'password.min' => '*密碼請至少8位',
                'password.confirmed' => "*確認密碼位與密碼相同"
            ]
        );
        
        $newUser = new User;
        $newUser->user_name = $req->username;
        //用php的加密
        $user_password = password_hash(
            $req->password,
            PASSWORD_DEFAULT,
            ['cost' => 10]
          );
        //$newUser->user_password = Hash::make($req->password);
        $newUser->user_password = $user_password;
        $newUser->email = $req->email;
        $newUser->authorized = 1; // 1 means registed from web
        $newUser->user_episode = "[]";
        $newUser->authorized_episode = "[]";
        $saved = $newUser->save();

        if ($saved){
            session([
                'user' => DB::table('users')
                    ->where('email', '=', $req->email)
                    ->first()
            ]);
            return redirect()->route('home');
        } else {
            return back()->with('Failed', "Could not save data");
        }
    }
    function logout() {
        session()->pull('user');
        return redirect()->route('login');
    }

    // Home page
    function home() {
        $user = DB::table('users')->where('user_id', '=', session()->get('user')->user_id)->first();
        $authorized_episode = array_map('intval', explode(',', str_replace(array( '[', ']' ), '', $user->authorized_episode)));
        
        $episodes = array();
        foreach ($authorized_episode as $ep) {
            $ep_data = DB::table('episodes')->where('episode_id', '=', $ep)->first();
            if ($ep_data)
                array_push($episodes, $ep_data);
        }
        return view('home', [
            'episodes' => $episodes
        ]);
    }

    // Lesson page
    function lesson(Request $req) {
        $episode = DB::table('episodes')->where('episode_id', '=', $req->episode_id)->first();
        $lessons = DB::table('lessons')
            ->where('lessons.episode_id', $episode->episode_id)
            ->orderby('lesson_id')
            ->get();
        return view('lesson', [
            'episode' => $episode,
            'lessons' => $lessons
        ]);
    }

    // Question page
    function question(Request $req) {
        
        $episode = DB::table('episodes')
            ->where('episode_id', '=', $req->episode_id)
            ->first();
        $lesson = DB::table('lessons')
            ->where('episode_id', '=', $req->episode_id)
            ->where('lesson_id', '=', $req->lesson_id)
            ->first();
        $questions = DB::table('questions')
            ->where('questions.episode_id', $episode->episode_id)
            ->where('questions.lesson_id', $lesson->lesson_id)
            ->get();
        return view('question', [
            'episode' => $episode,
            'lesson' => $lesson,
            'questions' => $questions
        ]);
    }
}
