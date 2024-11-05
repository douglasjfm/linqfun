<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--<![endif]-->
<head>
    <title>Linq.Fun</title>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HPV6B5YYJF"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-HPV6B5YYJF');
    </script>
    <!--<script src="https://www.google.com/recaptcha/api.js?render=6LdcGdQZAAAAAHhiBdurDCj9OPbHcR7p4Wmj_TaC"></script>-->
    <!-- Analytics -->
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!--GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <!--BOOTSTRAP MAIN STYLES -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--FONTAWESOME MAIN STYLE -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <!--PRETTYPHOTO MAIN STYLE -->
    <link href="assets/css/prettyPhoto.css" rel="stylesheet" />
    <!--CUSTOM STYLE -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!--END NAV SECTION -->
    <!--SLIDE CAROUSEL SECTION 
    <section id="slide-head" class="carousel">
        <div class="carousel-inner">
            <div class="item active">
                <div class="container">
                    <div class="carousel-content">
                        <h1>linq.fun - redirecting in 3s...</h1>
                        <p class="lead">
                        </p>
                    </div>
                </div>
            </div>
            <-- ./ first active div >
            <div class="item">
                <div class="container">
                    <div class="carousel-content" id="ll">
                    </div>
                </div>
            </div>
        </div>
        
    </section>-->
    <h1>linq.fun - redirecting in 2s...</h1><br/>
    <div id="ll">
        <a href="{{$link}}"> {{$link}}</a>
    </div>
    <!--END CONTACT SECTION -->
    <!--FOOTER SECTION -->
    <footer id="footer">
        <script type="text/javascript">
            setTimeout(function () {
                window.location.href = '{{$link}}';
                }, 2000);
            </script>
        </script>
    </footer>
    <!--END FOOTER SECTION -->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY LIBRARY -->
    <script src="assets/js/jquery.js"></script>
    <!-- BOOTSTRAP SCRIPTS LIBRARY -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- PRETTYPHOTO  SCRIPTS  LIBRARY-->
    <script src="assets/js/jquery.prettyPhoto.js"></script>
     <!-- SCROLL REVEL  SCRIPTS  LIBRARY-->
    <script src="assets/js/scrollReveal.js"></script>
    <!-- CUSTOM SCRIPT-->
    <script src="assets/scripts/custom.js"></script>
</body>
</html>
