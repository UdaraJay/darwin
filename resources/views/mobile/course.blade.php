<style media="screen">

  body{
    margin: 10% 0;
    font-size: 1.2em;
  }
  #wrapper{
    width: 100%;
    padding: 0 4%!important;
  }

</style>
@extends('layouts.mobile')

@section('content')

<div id="content">
  <!-- <a href="/" style="display:block; padding: 15px 12px; border:1px solid #e2e2e2; margin-bottom:20px; border-radius:90px; text-align:center; ">Back</a> -->
  <div class="section">
    <div class="min-title">Course quiz</div>
    <div id="slickQuiz">
        <div class="quizName"><!-- where the quiz name goes --></div>
        <div class="quizArea">
            <div class="quizHeader">
                <!-- where the quiz main copy goes -->
                <a class="button startQuiz" href="#">Get Started!</a>
            </div>
            <!-- where the quiz gets built -->
        </div>
        <div class="quizResults">
            <h3 class="quizScore">You Scored: <span><!-- where the quiz score goes --></span></h3>
            <h3 class="quizLevel"><strong>Ranking:</strong> <span><!-- where the quiz ranking level goes --></span></h3>
            <div class="quizResultsCopy">
                <!-- where the quiz result copy goes -->
            </div>
        </div>
    </div>
  </div>

  <div id="questionsList">
    <div class="min-title">Course questions</div>
    <ul class="questions">
      @foreach($course->topics as $topic)
        <h3>{{$topic->name}}</h3>
        @foreach($topic->questions as $question)
          <li>
            <div class="question">{{$question->question}}</div>
            <div class="correct_answer">{{$question->correctAnswer()->answer}}</div>
          </li>
        @endforeach
      @endforeach
    </ul>
  </div>

</div>

<meta name="course-id" content="{{ $course->id }}" />
<script src="{{ asset('quiz/js/slickQuiz.js') }}"></script>
<script type="text/javascript">
  var courseID = $('meta[name="course-id"]').attr('content');
  var quizJSON = (function () {
      var quizJSON = null;
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          'async': false,
          'global': false,
          'url': '/quiz/course',
          'data': { 'course': courseID },
          'type': 'POST',
          'dataType': "json",
          'success': function (data) {
              quizJSON = data;
          }
      });
      return quizJSON;
  })();

  $(function () {
    $('#slickQuiz').slickQuiz({
        skipStartButton: 1,
        scoreAsPercentage:1,
        events: {
            onStartQuiz: function (options) {},
            onCompleteQuiz: function (options) {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                  url: '/score/record',
                  data: { 'score': options.score, 'course': courseID},
                  type: 'POST',
                  dataType: 'json',
                  success: function (response) {
                      new jBox('Notice', {
                          preloadAudio:1,
                          audio: '/jBox/audio/bling1',
                          content: 'Score recorded',
                          color: 'green',
                          autoClose: 5000
                      });
                      return;
                  }
              });
            }  // reserved: options.questionCount, options.score
        }
    });

    slickQuiz.onCompleteQuiz
});
</script>


@endsection
