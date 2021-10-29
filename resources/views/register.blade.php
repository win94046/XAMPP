@extends('layouts.app')
@section('title', 'AR Trivia | Register')
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
                        <h3>歡迎註冊</h3>
                        <form action="{{route('regis')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" placeholder="電子信箱帳號">
                                <span>@error('email'){{$message}}@enderror</span>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="登入帳號">
                                <span>@error('username'){{$message}}@enderror</span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="登入密碼">
                                <span>@error('password'){{$message}}@enderror</span>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="確認密碼">
                                <span>@error('password_confirmation'){{$message}}@enderror</span>
                                <p style="text-align:left;">
                                <a class="text-right" href="{{route('login')}}">登入帳號</a>
                                <span style="float:right;">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="submit">註冊帳號</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End About Section -->
</main><!-- End #main -->
@endsection