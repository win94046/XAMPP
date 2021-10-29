@extends('layouts.app')
@section('title', 'AR Trivia | Home')
@section('main')
    <main id="main">
        <div class="container d-md-flex py-4"></div>
        @csrf
        <!-- ======= Popular Courses Section ======= -->
        <section id="popular-courses" class="courses">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                <h2>AR Trivia Home</h2>
                <p>情境</p>
                </div>

                <div class="row" data-aos="zoom-in" data-aos-delay="100">
                    @foreach ($episodes as $ep)
                        <div class="col-md-6 col-6 align-items-stretch">
                            <div class="course-item">
                                <div class="course-item-img">
                                    <img src="{{$ep->episode_image}}" alt="...">
                                </div>
                                <div class="course-content">
                                    <h3>{{$ep->episode_name}}</h3>
                                    <p>{{$ep->episode_description}}</p>
                                    <div class="trainer d-flex justify-content-between align-items-center">
                                        <!-- <div class="form-group">
                                        <input type="text" class="form-control" placeholder="認列代碼">
                                        </div> -->
                                        <div class="form-group col-4">
                                            <form action="{{route('lesson')}}" method="get" enctype="multipart/form-data">
                                                <input type="hidden" id="episode_id" name="episode_id" value="{{$ep->episode_id}}">
                                                <input type="hidden" id="episode_name" name="episode_name" value="{{$ep->episode_name}}">
                                                <input type="submit" class="btn btn-primary" id="submit" value="進入">
                                            </form>
                                        </div>
                                        <div class="form-group col-4">
                                            <form action="{{route('edit.episode.view')}}" method="get" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" id="episode_id" name="episode_id" value="{{$ep->episode_id}}">
                                                <input type="hidden" id="episode_name" name="episode_name" value="{{$ep->episode_name}}">
                                                <input type="hidden" id="episode_description" name="episode_description" value="{{$ep->episode_description}}">  
                                                <input type="hidden" id="episode_image" name="episode_image" value="{{$ep->episode_image}}">  
                                                <button type="submit" class="btn btn-primary" id="submit">修改</button>
                                            </form>
                                        </div>
                                        <div class="form-group col-4">
                                            <form action="{{route('delete.episode')}}" method="post" 
                                            onsubmit="return confirm('Are you sure you want to delete the episode [{{$ep->episode_name}}]?');">
                                                @csrf
                                                <input type="hidden" id="episode_id" name="episode_id" value="{{$ep->episode_id}}">
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
                                            <form action="{{route('add.episode.view')}}" method="get">
                                                <button type="submit" id="submit" class="twitter" 
                                                style="border-width: 0px; background-color: transparent;"><i class="icofont-plus"></i></button>
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