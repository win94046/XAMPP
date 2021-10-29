@extends('layouts.app')
@section('title', 'AR Trivia | Lessons')
@section('main')
    <main id="main">
        <div class="container d-md-flex py-4"></div>

        <!-- ======= Popular Courses Section ======= -->
        <section id="popular-courses" class="courses">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>AR Trivia Questions</h2>
                    <p>{{$lesson->lesson_name}} 題目</p>
                </div>

                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                @foreach ($questions as $question)
                    <div class="col-lg-6 col-12 align-items-stretch">
                        <div class="course-item">
                            <div class="course-item-img">
                                <img src="{{$question->image_url}}" alt="...">
                            </div>
                            <div class="course-content">
                            @if($question->DuplicateTarget == 1 )
                            <p style="color: red"><b>已存在相同的目標圖，請進入修改頁面更換</b></p>
                            @else
                                <h3>{{$question->question}}</h3>
                                <p>{{$question->answer}}<br>
                                    {{$question->chinese_answer}}
                                </p>
                            @endif
                            <div class="trainer d-flex justify-content-between align-items-center">
                                    <div class="form-group col-4">
                                        <form action="{{route('edit.question.view')}}" method="get" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="question_id" name="question_id" value="{{$question->question_id}}">
                                            <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson->lesson_id}}">
                                            <input type="hidden" id="episode_id" name="episode_id" value="{{$episode->episode_id}}">
                                            <input type="hidden" id="lesson_name" name="lesson_name" value="{{$lesson->lesson_name}}">
                                            <button type="submit" class="btn btn-primary" id="submit">修改</button>
                                        </form>
                                    </div>
                                    <div class="form-group col-4">
                                        <form action="{{route('delete.question')}}" method="post" onsubmit="return confirm('Are you sure you want to delete the question [{{$question->question}}]?');">
                                            @csrf
                                            <input type="hidden" id="question_id" name="question_id" value="{{$question->question_id}}">
                                            <input type="hidden" id="lesson_name" name="lesson_name" value="{{$lesson->lesson_name}}">
                                            <input type="hidden" id="episode_id" name="episode_id" value="{{$episode->episode_id}}">
                                            <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson->lesson_id}}">
                                            <button type="submit" class="btn btn-primary" id="submit" name="delete">刪除</button>
                                        </form>
                                    </div>
                                    <div class="form-group col-4">
                                        <form action="{{route('reupload.question')}}" method="post" onsubmit="return confirm('Are you sure you want to reupload the question [{{$question->question}}]?');">
                                            @csrf
                                            <input type="hidden" id="question_id" name="question_id" value="{{$question->question_id}}">
                                            <input type="hidden" id="episode_id" name="episode_id" value="{{$episode->episode_id}}">
                                            <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson->lesson_id}}">
                                            <button type="submit" class="btn btn-primary" id="submit" name="delete">重新上傳</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-6 col-12 align-items-stretch">
                    <div class="course-item" style="width:100%;">
                        <div class="course-content">
                            <section id="contact" class="contact" style="padding: 45%; ">
                                <div class="info">
                                    <div class="address text-center">
                                        <form action="{{route('add.question.view')}}" method="get">
                                            @csrf
                                            <input type="hidden" id="episode_id" name="episode_id" value="{{$episode->episode_id}}">
                                            <input type="hidden" id="lesson_name" name="lesson_name" value="{{$lesson->lesson_name}}">
                                            <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson->lesson_id}}">
                                            <button type="submit" id="submit" class="twitter" style="border-width: 0px; background-color: transparent;"><i class="icofont-plus"></i></button>                       
                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 align-items-stretch">
                    <div class="course-item" style="width:100%;">
                        <div class="course-content">
                            <section id="contact" class="contact" style="padding: 45%; ">
                                <div class="info">
                                    <div class="address text-center">
                                        <h1>CSV Upload</h1>
                                        <form action="{{route('add.question.csv')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="episode_id" name="episode_id" value="{{$episode->episode_id}}">
                                            <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson->lesson_id}}">
                                            <input  type="file"  id="formFile" name="csv_file" accept=".csv">
                                            <input type="submit" id="submit"
                                            style="background-image:url(http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/image/csv_button.png);
                                            width:80px;height:25px;
                                            background-size:80px 25px;">

                                                                   
                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <style>
        #submit {
        display: block;
        margin: auto;
        }
    </style>
@endsection