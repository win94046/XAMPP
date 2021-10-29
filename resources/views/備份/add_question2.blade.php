@extends('layouts.app')
@section('title', 'AR Trivia | Add Questions')
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
                            <h3>在{{$lesson_name}}增加題目</h3>
                            <form action="{{route('add.question')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="episode_id" name="episode_id" value="{{$episode_id}}">  
                                <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson_id}}">
                                <input type="hidden" id="lesson_name" name="lesson_name" value="{{$lesson_name}}">
                                <div class="form-group">
                                    <select name="question_level">
                                    <option selected value="" disabled hidden>Choose Level</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    </select>
                                    <span>@error('question_level'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <select name="animal_model">
                                    <option selected value="NULL" disabled hidden>NULL</option>
                                    <option value="bear">bear</option>
                                    <option value="cat">cat</option>
                                    <option value="cow">cow</option>
                                    </select>
                                    <span>@error('question_level'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="validatedCustomFile" name="image_url" accept=" " data-target='preview_img'>
                                        <span>@error('image_url'){{$message}}@enderror</span>

                                        <label class="custom-file-label text-left text-muted" for="validatedCustomFile" id="image_label">Question AR Image</label>
                                        <!-- <script>
                                            
                                        </script> -->
                                    </div>
                                    <img class="card-img" style="padding-bottom: 10px;" alt="..." id="preview_img" src="https://www.templaza.com/components/com_easyblog/themes/wireframe/images/placeholder-image.png"/>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="question" placeholder="Question">
                                    <span>@error('question'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="hint_1" placeholder="Hint 1" >
                                    <span>@error('hint_1'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="hint_2" placeholder="Hint 2">
                                    <span>@error('hint_2'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="answer" placeholder="Answer">
                                    <span>@error('answer'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="chinese_answer" placeholder="Chinese Answer">
                                    <span>@error('chinese_answer'){{$message}}@enderror</span>
                                </div>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="modelCustomFile" name="model_url"  data-target='model_img'>
                                        <span>@error('image_url'){{$message}}@enderror</span>
                                        <label class="custom-file-label text-left text-muted" for="modelCustomFile" id="model_label">Question model</label>
                                        <script>
                                            var input = document.querySelector('input[name=image_url]');
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

                                            var input2 = document.querySelector('input[name=model_url]');
                                            input2.addEventListener('change', function(e){
                                                labelFileName2(e.target);
                                            });
                                            function labelFileName2(input2){
                                                var label2 = document.getElementById('model_label');
                                                var fullPath2 = document.getElementById('modelCustomFile').value;
                                                if (fullPath2) {
                                                    var startIndex2 = (fullPath2.indexOf('\\') >= 0 ? fullPath2.lastIndexOf('\\') : fullPath2.lastIndexOf('/'));
                                                    var filename2 = fullPath2.substring(startIndex2);
                                                    if (filename2.indexOf('\\') === 0 || filename2.indexOf('/') === 0) {
                                                        filename2 = filename2.substring(1);
                                                    }
                                                    label2.innerHTML = filename2;
                                                }
                                            }
                                        </script>
                                    </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="submit">Add Questions</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End About Section -->
    </main><!-- End #main -->
@endsection