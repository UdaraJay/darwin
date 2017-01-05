<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta property="og:url" content="https://todarwin.com" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Darwin: A simple active learning tool for you and your friends" />
        <meta property="og:description" content="All this app does is test you daily with questions from anything you're learning." />
        <meta property="og:image" content="https://todarwin.com/image/darwin-banner-2.png" />
        <meta property="fb:app_id" content="650259121840757"/>

        <title>Darwin: A simple active learning tool</title>
        <link rel="shortcut icon" type="image/png" href="/image/darwin.png"/>

        <!-- Styles -->
        <link href="/css/home.css" rel="stylesheet">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    <body>

      <div id="wrapper">
        <div id="header">
          <div class="logo"></div>
          <div class="des">A simple active learning tool for you and your friends.
          <div class="sub">All this app does is test you daily with questions from anything you're learning.</div></div>

          <a href="/redirect"><div class="facebook">Login with Facebook</div></a>


          <div class="foot">
            <div class="app-icons">
              <a href="https://play.google.com/store/apps/details?id=com.todarwin.darwin"><img src="./image/google-play-app.png" height="50px"></a>
            </div>
            Costs zero dollars. Pay by contributing questions.</div>
        </div>
        <div id="footer">Created by <a href="https://udarajay.com">Udara Jay.</a> <span style="margin:0 5px; font-size:0.9em;">•</span> <b>{{$user_count}}</b> people are using Darwin to complement their learning</div>
      </div>

    </body>

    <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '650259121840757',
      xfbml      : true,
      version    : 'v2.8'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
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
