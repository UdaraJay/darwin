<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <meta property="og:url" content="{{Request::fullUrl()}}" />
        <meta property="og:description" content="All this app does is test you daily with questions from anything you're learning." />
        <meta property="og:image" content="https://todarwin.com/image/darwin-banner-2.png" />
        <meta property="fb:app_id" content="650259121840757"/>

        <title>Darwin: A simple active learning tool</title>
        <link rel="shortcut icon" type="image/png" href="/image/darwin.png"/>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

        <!-- jQuery -->

        <!-- Selectize-->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="{{ asset('selectize/js/standalone/selectize.js') }}"></script>
        <link href="{{ asset('selectize/css/selectize.css') }}" rel="stylesheet">

        <!-- jBox -->
        <script src="{{ asset('jBox/jBox.js') }}"></script>
        <link href="{{ asset('jBox/jBox.css') }}" rel="stylesheet">

    </head>
    <body>

      <div id="wrapper">
        <div id="header">
          <a href="/"><div class="logo"></div></a>
          @if(Auth::check())
          <input type="text" id="searchBar" class="searchBar" name="search" placeholder="Search courses & subjects...">
          <div class="how" id="how-works">How it works?</div>

          <div class="avatar" id="avatar_menu" style="background:#e2e2e2 url({{Auth::user()->avatar}}) no-repeat;">
            <div id="avatar_menu_drop" class="menu">
              <!-- <li><a href="">courses</a></li> -->
              <!-- <li><a href="">account</a></li> -->
              <li><a href="/logout">logout</a></li>
            </div>
          </div>
          @endif

        </div>

        @yield('content')
      </div>

      <div id="footer">
        <div id="wrapper">toDarwin.com • Created by Udara Jay.</div>
        </div>

    </body>

<script>

    new jBox('Modal', {
        width: 500,
        attach: $('#how-works'),
        content: 'Create your own courses. Add your own questions.<br></br>In each course page we\'ll let you know if other people have created questions under the same course and if you\'d like to incorporate them in your quizzes and/or flashcards. <br></br>  Note: Flash cards (coming soon...) are automatically generated using your question and the correct answer. <br></br>Simple.'
    });

  $( "#avatar_menu" ).on( "click", function()
    {
        $( "#avatar_menu_drop" ).stop().fadeToggle( "fast" );
    });

    $(document).click(function(event) {
        if(!$(event.target).closest('#avatar_menu').length &&
           !$(event.target).is('#avatar_menu')) {
            if($('#avatar_menu_drop').is(":visible")) {
                $('#avatar_menu_drop').hide();
            }
        }
    })

    @if(Auth::check())
      var $search = $('#searchBar').selectize({
          valueField: 'id',
          labelField: 'name',
          searchField: ['name'],
          maxOptions: 10,
          maxItems:1,
          create: false,
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
                window.location.replace("/course/" + {{Auth::user()->id}} + '/' + value);
  					}
      });
    @endif

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '650259121840757',
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

   //Facebook share
   function shareDarwin() {
     FB.ui({
    method: 'share_open_graph',
    action_type: 'og.likes',
    action_properties: JSON.stringify({
      object:'https://toDarwin.com',
    })
    }, function(response){
      // Debug response (optional)
      console.log(response);
    });
   }

   //Facebook messages
   function shareDarwinMessage() {
      FB.ui({
     method: 'send',
     link: 'https://toDarwin.com',
   });
   }


</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89665166-1', 'auto');
  ga('send', 'pageview');

</script>
</html>
