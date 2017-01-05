@extends('layouts.app')

@section('content')

<div id="content">

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

  <div id="shareBar">
    <div class="min-title">Share with your friends.<br>Ask them to add questions to the same course – We'll then automatically incorporate them into your quizzes.</div>
    <div class="shareButton facebook" onclick="shareDarwin()">Share on Facebook</div>
    <div class="shareButton messenger" onclick="shareDarwinMessage()">Send with Messenger</div>
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
