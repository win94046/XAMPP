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
              <h3>編輯{{$lesson_name}}的題目</h3>
                <form action="{{route('edit.question')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="question_id" name="question_id" value="{{$question_id}}">
                <input type="hidden" id="episode_id" name="episode_id" value="{{$episode_id}}">
                <input type="hidden" id="lesson_id" name="lesson_id" value="{{$lesson_id}}">
                <input type="hidden" id="lesson_name" name="lesson_name" value="{{$lesson_name}}">
                <div class="form-group">
                  <select name="question_level" >
                    <option selected value="" disabled hidden>Choose Level</option>
                    <option value="A" {{$question_level == "A" ? 'selected' : '' }} >A</option>
                    <option value="B" {{$question_level == "B" ? 'selected' : '' }} >B</option>
                    <option value="C" {{$question_level == "C" ? 'selected' : '' }}>C</option>
                  </select>
                  <span>@error('question_level'){{$message}}@enderror</span>
                </div>
                  <div class="form-group">
                       <select name="animal_model" >
                       <option selected value="" disabled hidden>Choose animal</option>
                        <option value="bear" {{$animal_model == "bear" ? 'selected' : '' }}>bear</option>
                        <option value="cat"  {{$animal_model == "cat" ? 'selected' : '' }}>cat</option>
                        <!-- <option value="cow"  {{$animal_model == "cow" ? 'selected' : '' }}>cow</option>
                        <option value="ElephantA" {{$animal_model == "ElephantA" ? 'selected' : '' }}>ElephantA</option>
                        <option value="Hippo"{{$animal_model == "Hippo" ? 'selected' : '' }}>Hippo</option>
                        <option value="Lion"{{$animal_model == "Lion" ? 'selected' : '' }}>Lion</option>
                        <option value="Pig"{{$animal_model == "Pig" ? 'selected' : '' }}>Pig</option>
                        <option value="Rabbit"{{$animal_model == "Rabbit" ? 'selected' : '' }}>Rabbit</option>
                        <option value="Rhino"{{$animal_model == "Rhino" ? 'selected' : '' }}>Rhino</option>
                        <option value="Dog"{{$animal_model == "Dog" ? 'selected' : '' }}>Dog</option> -->
                        <!-- <option value="Alpaca"{{$animal_model == "Alpaca" ? 'selected' : '' }}>Alpaca</option> -->
                        <!-- <option value="Deer"{{$animal_model == "Deer" ? 'selected' : '' }}>Deer</option>
                        <option value="Giraffe"{{$animal_model == "Giraffe" ? 'selected' : '' }}>Giraffe</option>
                        <option value="Zebra"{{$animal_model == "Zebra" ? 'selected' : '' }}>Zebra</option>
                        <option value="Horse"{{$animal_model == "Horse" ? 'selected' : '' }}>Horse</option>
                        <option value="Chicken"{{$animal_model == "Chicken" ? 'selected' : '' }}>Chicken</option>
                        <option value="Chick"{{$animal_model == "Chick" ? 'selected' : '' }}>Chick</option>
                        <option value="Duck"{{$animal_model == "Duck" ? 'selected' : '' }}>Duck</option> -->
                        </select>
                         <span>@error('question_level'){{$message}}@enderror</span>
                   </div>           
                   <div class="form-group">
                        <div class="custom-file">
                        <input type="file" class="custom-file-input" id="validatedCustomFile" name="image_url"  data-target='preview_img'>
                        <span>@error('image_url'){{$message}}@enderror</span>
                        <label class="custom-file-label text-left text-muted" for="validatedCustomFile" id="image_label">Question AR Image</label>
                        <!-- <script>
                                            
                         </script> -->
                         </div>
                        <img class="card-img" style="padding-bottom: 10px;" alt="..." id="preview_img" src='{{$image_url}}'/>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="question" placeholder="Question" value='{{$question}}' required>
                    <span>@error('question'){{$message}}@enderror</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="hint_1" placeholder="Hint 1" value='{{$hint_1}}' required>
                    <span>@error('hint_1'){{$message}}@enderror</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="hint_2" placeholder="Hint 2" value='{{$hint_2}}' required>
                    <span>@error('hint_2'){{$message}}@enderror</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="answer" placeholder="Answer" value='{{$answer}}' required>
                    <span>@error('answer'){{$message}}@enderror</span>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="chinese_answer" placeholder="Chinese Answer" value='{{$chinese_answer}}' required>
                    <span>@error('chinese_answer'){{$message}}@enderror</span>
                  </div>

                  
                  <div class="form-group">
                      <select name="Choose" id="unityshow_type">
                      <option value="NULL"{{$Choose == "NULL" ? 'selected' : '' }}>NULL</option>
                      <option value="youtube_url"{{$Choose == "youtube_url" ? 'selected' : '' }}>youtube影片網址</option>
                      <option value="model"{{$Choose == "model" ? 'selected' : '' }}>3D模型</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <input type="url"  class="form-control" name='youtube_url' id='youtubeURL' placeholder="youtube URL" value='{{$youtube_url}}' style="display: none" />
                  </div>
    
                  <div class="form-group">
                  <div class="custom-file" id = 'model' style="display: none">
                  <input type="file" class="custom-file-input" id="modelCustomFile" name="model_url"  data-target='model_img'>
                  <span>@error('image_url'){{$message}}@enderror</span>
                  <label class="custom-file-label text-left text-muted" for="modelCustomFile" id="model_label">Question model</label>
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                  @if($Choose == "youtube_url")
                  <script>
                    //console.log("youtube_url");
                    var youtubeURL;                    
                    youtubeURL = $('#youtubeURL');
                    youtubeURL.show();
                    //console.log('{{$youtube_url}}');
                  </script>
                  @elseif($Choose == "model")
                  <script>
                    console.log("model");
                    var model;
                    model = $('#model')
                    var model_label;
                    
                    model.show();
                    model_label = document.getElementById('model_label');
                    model_label.innerHTML = '{{$model_name}}'
                    console.log('{{$model_name}}');
                    
                  </script>
                  @endif
                  
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
                                          //處理要哪種模式(影片/模型)
                                            var youtubeURL;
                                            var model;
                                            var serviceTypeInput = $('#unityshow_type');
                                            serviceTypeInput.on('change', function() {
                                            youtubeURL = $('#youtubeURL');
                                            model = $('#model')
                                            if (serviceTypeInput.val() == "youtube_url") {
                                                //console.log("youtube_url");
                                                youtubeURL.show();
                                                model.hide();
                                            }
                                            else if (serviceTypeInput.val() == "model") {
                                                model.show();
                                                
                                                youtubeURL.hide();
                                            }
                                            else {
                                                youtubeURL.hide();
                                                model.hide();
                                            }
                                            });
                                      </script>
                                  </div>
                  <div class="form-group">
                    <button type=submit class="btn btn-primary" id="submit">Edit Question</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section><!-- End About Section -->
    </main><!-- End #main -->
@endsection