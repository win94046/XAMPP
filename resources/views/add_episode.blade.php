@extends('layouts.app')
@section('title', 'AR Trivia | Add Episode')
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
                            <h3>增加情境</h3>
                            <form action="{{route('add.episode')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" name="episode_name" placeholder="Episode Name">
                                    <span>@error('episode_name'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="episode_description" placeholder="Episode Description" rows="1" style="resize:none;display:block" id="episode_description"></textarea>
                                    <span>@error('episode_description'){{$message}}@enderror</span>
                                    <script>
                                        var episode_description = document.getElementById('episode_description');
                                        episode_description.addEventListener('keyup', function() {
                                            if (this.scrollHeight < 300) {
                                                this.style.height = 0;
                                                this.style.height = (this.scrollHeight + 2) + 'px';
                                            }
                                            else {
                                                this.style.height = '300px';
                                            }
                                        }, false);
                                    </script>
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="validatedCustomFile" name="episode_image" accept="image/jpg,image/png,image/jpeg" data-target='preview_img'>
                                        <span>@error('episode_image'){{$message}}@enderror</span>
                                        <label class="custom-file-label text-left text-muted" for="validatedCustomFile" id="image_label">Episode Image</label>
                                        <script>
                                            var input = document.querySelector('input[name=episode_image]');
                                            input.addEventListener('change', function(e){
                                                readURL(e.target);
                                                labelFileName(e.target);
                                            });
                                            function readURL(input){
                                                if (input.files && input.files[0]){
                                                    var reader = new FileReader();
                                                    reader.onload = (e) => {
                                                        var imgID = input.getAttribute('data-target');
                                                        var img = document.querySelector('#' + imgID);
                                                        img.setAttribute('src', e.target.result);
                                                    }
                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            }
                                            function labelFileName(input){
                                                var label = document.getElementById('image_label');
                                                var fullPath = document.getElementById('validatedCustomFile').value;
                                                if (fullPath) {
                                                    var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                                                    var filename = fullPath.substring(startIndex);
                                                    if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                                                        filename = filename.substring(1);
                                                    }
                                                    label.innerHTML = filename;
                                                }
                                            }
                                        </script>
                                    </div>
                                    <img class="card-img" style="padding-bottom: 10px;" alt="..." id="preview_img" src="http://134.208.3.123/AR_English_Learning_DEMO8_4/storage/app/public/請上傳圖片.jpg"/>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="submit">Add Episode</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End About Section -->
    </main><!-- End #main -->
@endsection