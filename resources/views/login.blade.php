@extends('layouts.app')
@section('title', 'AR Trivia | Login')
@section('main')
    <main id="main">
        <div class="container d-md-flex py-4"></div>

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container">
                <div class="section-title">
                    <h2>AR Trivia</h2>
                </div>
                <div class="row" id="row_style">
                    <div class="container box">
                        <div class="text-center">
                            <h3>歡迎登入</h3>
                            <form action="{{route('auth')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <h6>測試帳號 test9527</h6>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" placeholder="登入帳號" value="{{ old('username') }}" >
                                    <span>@error('username'){{$message}}@enderror</span>
                                </div>
                                <h6>測試密碼 test9527</h6>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="登入密碼">
                                    <span>@error('password'){{$message}}@enderror</span>
                                    <p style="text-align:left;">
                                    <a class="text-right" href="{{route('register')}}">註冊帳號</a>
                                    <span style="float:right;">
                                    <!-- <a href="recover.html">忘記密碼?</a></span> -->
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">登入</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End About Section -->
    </main><!-- End #main -->
@endsection