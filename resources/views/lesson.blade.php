@extends('layouts.app')
@section('title', 'AR Trivia | Lessons')
@section('main')
    <main id="main">
        <div class="container d-md-flex py-4"></div>

        <!-- ======= Popular Courses Section ======= -->
        <section id="popular-courses" class="courses">
            <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>AR Trivia Lesson</h2>
                <p>{{$episode->episode_name}} 課程</p>
            </div>

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                @foreach ($lessons as $lesson)
                    <div class="col-md-6 col-6 align-items-stretch">
                        <div class="course-item">
                            <div class="course-item-img">
                                <img src="{{$lesson->lesson_image}}" alt="...">
                            </div>
                            <div class="course-content">
                                <h3>{{$lesson->lesson_name}}</h3>
                                <p>{{$lesson->lesson_description}}</p>
                                <div class="trainer d-flex justify-content-between align-items-center">
                                    <div class="form-group col-4">
                                        <form action="{{route('question')}}" method="get" enctype="multipart/form-data">
                                            <input type="hidden" id="episode_id" name="episode_id" value="{{$episode->episode_id}}">
                                            <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson->lesson_id}}">
                                            <input type="hidden" id="lesson_name" name="lesson_name" value="{{$lesson->lesson_name}}">
                                            <button type="submit" class="btn btn-primary" id="submit">進入</button>
                                        </form>
                                    </div>
                                    <div class="form-group col-4">
                                        <form action="{{route('edit.lesson.view')}}" method="get" enctype="multipart/form-data">
                                            <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson->lesson_id}}">
                                            <input type="hidden" id="episode_id" name="episode_id" value="{{$episode->episode_id}}">
                                            <input type="hidden" id="episode_name" name="episode_name" value="{{$episode->episode_name}}">
                                            <button type="submit" class="btn btn-primary" id="submit">修改</button>
                                        </form>
                                    </div>
                                    <div class="form-group col-4">
                                        <form action="{{route('delete.lesson')}}" method="post" onsubmit="return confirm('Are you sure you want to delete the lesson [{{$lesson->lesson_name}}]?');">
                                            @csrf
                                            <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson->lesson_id}}">
                                            <input type="hidden" id="episode_name" name="episode_name" value="{{$episode->episode_name}}">
                                            <input type="hidden" id="episode_id" name="episode_id" value="{{$episode->episode_id}}">
                                            <button type="submit" class="btn btn-primary" id="submit" name="delete">刪除</button>
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
                                    <form action="{{route('add.lesson.view')}}" method="get">
                                        @csrf
                                        <input type="hidden" id="episode_name" name="episode_name" value="{{$episode->episode_name}}">
                                        <input type="hidden" id="episode_id" name="episode_id" value="{{$episode->episode_id}}">
                                        <button type="submit" id="submit" class="twitter" style="border-width: 0px; background-color: transparent;"><i class="icofont-plus"></i></button>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                </div>
            </div>

            </div>
        </section>
    </main><!-- End #main -->
    <style>
        #submit {
            display: block;
            margin: auto;
        }
    </style>
@endsection