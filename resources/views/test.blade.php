episode name: {{$episode->episode_name}}
@foreach ($lessons as $lesson)
lesson: {{$lesson->lesson_name}}<br>
@endforeach
@foreach ($questions as $question)
chi: {{$question->chinese_answer}}<br>
@endforeach