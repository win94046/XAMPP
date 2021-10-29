@extends('layouts.app')
@section('title', 'AR Trivia | Edit Lesson')
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
                <h3>編輯 {{$episode_name}}課程</h3>
                <form action="{{route('edit.lesson')}}" method="post" enctype="multipart/form-data">
                @csrf  
                <input type="hidden" id="lesson_id" name="lesson_id" value='{{$lesson_id}}'>
                  <input type="hidden" id="episode_id" name="episode_id" value='{{$episode_id}}'>
                  <input type="hidden" id="episode_name" name="episode_name" value='{{$episode_name}}'>
                  <div class="form-group">
                    <input type="text" class="form-control" name="lesson_name" placeholder="Lesson Name" value="{{$lesson_name}}" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="lesson_description" placeholder="Lesson Description" value="{{$lesson_description}}" required>
                  </div>
                  <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="validatedCustomFile" name="lesson_image" accept="image/jpg,image/png,image/jpeg" data-target='preview_img'>
                                        <span>@error('episode_image'){{$message}}@enderror</span>
                                        <label class="custom-file-label text-left text-muted" for="validatedCustomFile" id="image_label">Episode Image</label>
                                        <script>
                                            var input = document.querySelector('input[name=lesson_image]');
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
                                    <img class="card-img" style="padding-bottom: 10px;" alt="..." id="preview_img" src='{{$lesson_image}}'/>
                                </div>
                  <div class="form-group">
                    <button type=submit class="btn btn-primary" id="submit">Edit Lesson</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section><!-- End About Section -->
    </main><!-- End #main -->
@endsection