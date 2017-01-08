
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

  <div class="section">
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


  <div id="courses">
    <div class="min-title">Your courses & subjects</div>
    <div id="courseList">
      @if(Auth::user()->courses->count() > 0)
        @foreach(Auth::user()->courses as $course)
          <a href="/course/{{Auth::user()->id}}/{{$course->id}}">
            <div id="course-{{$course->id}}" class="course">
              {{ $course->name }}
              <div class="buttons">
                <i id="delete-course-{{$course->id}}" class="close material-icons" data-confirm="Do you really want to remove <b>{{$course->name}}</b>?" rel="{{$course->id}}">close</i>
              </div>
            </div>
          </a>

          <script type="text/javascript">
            $('#delete-course-{{$course->id}}').each(function(){
                new jBox('Confirm',{
                  attach: $(this),
                  confirmButton: 'Delete',
                  cancelButton: 'Cancel',
                  closeOnConfirm: 1,
                  preventDefault:1,
                  confirm: function(el){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/course/remove',
                        data: { 'course': {{$course->id}} },
                        type: 'POST',
                        dataType: 'json',
                        success: function (response) {
                            $('#course-' + response.course.id).fadeOut('slow');
                            new jBox('Notice', {
                                preloadAudio:1,
                                audio: '/jBox/audio/bling1',
                                content: 'Course deleted: <b>' + response.course.name +'</b>',
                                color: 'red',
                                autoClose: 5000
                            });
                        }
                    });
                  },
                  cancel: function(){
                  }

                });
              });
          </script>
        @endforeach
      @else
        <p>Nothing yet. Add a question to a course below and refresh the page to get started.</p>
      @endif
    </div>
  </div>

  <div id="createQuestion">
    <div class="min-title">Add a new question</div>
    <form id="questionForm">
      <div class="min-title">Question</div>
      <textarea type="text" name="question" placeholder="type your question here..."></textarea>
      <div class="responses">
        <div class="min-title">Answers</div>
        <div class="input-group">
          <input class="correct" type="text" name="correct_answer" placeholder="type the correct answer here...">
        </div>
        <div class="wrong-answers-wrap">
          <div class="wrong_input_group">
            <input type="text" class="wrong" name="wrong_answers[]" placeholder="type wrong answer here...">
            <button class="add-field-button"><i class="material-icons">add_circle</i></button>
          </div>
        </div>
      </div>

      <div class="tag-group" style="display:block;">
        <div class="half" style="width:100%;">
          <label>Select (or add) a course/subject</label>
          <input id="courseTag" class="left" name="course" placeholder="Type to search...">
        </div>
        <div class="half" style="width:100%; margin-top:20px;">
          <label>Select (or add) a topic under your course</label>
          <input id="topicTag" class="right" name="topic" placeholder="Type to search...">
        </div>
      </div>
      <div class="buttons">
        <button id="add_question" type="submit" class="button">Add question</button>
      </div>
    </form>
  </div>

</div>

<script type="text/javascript">
var xhr;
var select_course, $select_course;
var select_topic, $select_topic;

var $select_course = $('#courseTag').selectize({
    valueField: 'id',
    labelField: 'name',
    searchField: ['name'],
    maxOptions: 10,
    maxItems:1,
    create: function (input, callback) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/search/create/course',
            data: { 'name': input },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                new jBox('Notice', {
                    preloadAudio:1,
                    audio: '/jBox/audio/bling1',
                    content: 'Created course: <b>' + response.course.name +'</b>',
                    color: 'blue',
                    autoClose: 5000
                });
                return callback(response.course);

            }
        });
    },
    render: {
        option: function (item, escape) {
            return '<div>' + escape(item.name) + '</div>';
        }
    },
    load: function (query, callback) {
        if (!query.length) return callback();
        $.ajax({
            url: '/search/courses.json?query=' + query,
            type: 'GET',
            dataType: 'json',
            data: {
                maxresults: 10
            },
            error: function () {
                callback();
            },
            success: function (res) {
                callback(res.courses);
            }
        });
    },
    onChange: function(value) {
						if (!value.length) return;
            select_topic.disable();
						select_topic.clearOptions();
						select_topic.load(function(callback) {
							xhr && xhr.abort();
							xhr = $.ajax({
								url: '/search/topic.json?course=' + value,
								success: function(results) {
									select_topic.enable();
									callback(results.topics);
								},
								error: function() {
									callback();
								}
							})
						});
					}
});

$select_topic = $('#topicTag').selectize({
    valueField: 'id',
    labelField: 'name',
    searchField: ['name'],
    maxOptions: 10,
    maxItems:1,
    create: function (input, callback) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/search/create/topic',
            data: { 'name': input, 'course': select_course.getValue() },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                new jBox('Notice', {
                    preloadAudio:1,
                    audio: '/jBox/audio/bling1',
                    content: 'Created topic: <b>' + response.topic.name +'</b>',
                    color: 'blue',
                    autoClose: 5000
                });
                return callback(response.topic);

            }
        });
    }
});

select_topic  = $select_topic[0].selectize;
select_course  = $select_course[0].selectize;

// Add and remove wrong answers
$(document).ready(function() {
    var max_fields      = 5; //maximum input boxes allowed
    var wrapper         = $(".wrong-answers-wrap"); //Fields wrapper
    var add_button      = $(".add-field-button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="wrong_input_group"><input type="text" class="wrong newWrong" name="wrong_answers[]" placeholder="type wrong answer here..."/><a href="#" class="remove_field"><i class="material-icons">remove_circle</i></a></div>'); //add input box
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

$("#questionForm").submit(function(e) {
    $('#add_question').addClass('button--loading');
    var url = "/question/create"; // the script where you handle the form input.
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
           type: "POST",
           url: url,
           data: $("#questionForm").serialize(), // serializes the form's elements.
           success: function(data)
           {
               new jBox('Notice', {
                   preloadAudio:1,
                   audio: '/jBox/audio/bling1',
                   content: 'Question saved to <b>' + data.course +'</b>',
                   color: 'blue',
                   autoClose: 5000
               });

               var trans = $('#add_question').removeClass('button--loading');
               $('#add_question').html('Saved!');
               setTimeout(function() {
                 $('#add_question').html('Add question');
               }, 2000);
               $('#questionForm').trigger("reset");

           },
           error: function(data)
           {
             $('#add_question').removeClass('button--loading');
             var errors = $.parseJSON(data.responseText);

              $.each(errors, function(index, value) {
                new jBox('Notice', {
                    preloadAudio:1,
                    audio: '/jBox/audio/bling1',
                    content: '' + value +'',
                    color: 'red',
                    autoClose: 5000
                });
              });
           },
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});

</script>

@if(Auth::user()->questions()->count() > 0)
  <script type="text/javascript">
    var quizJSON = (function () {
        var quizJSON = null;
        $.ajax({
            'async': false,
            'global': false,
            'url': '/quiz/refresher',
            'dataType': "json",
            'success': function (data) {
                quizJSON = data;
            }
        });
        return quizJSON;
    })();
    </script>
@else
  <script type="text/javascript">
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
          'data': { 'course': 1 },
          'type': 'POST',
          'dataType': "json",
          'success': function (data) {
              quizJSON = data;
          }
      });
      return quizJSON;
  })();
  </script>
@endif

<script src="{{ asset('quiz/js/slickQuiz.js') }}"></script>
<script src="{{ asset('quiz/js/master.js') }}"></script>
@endsection
