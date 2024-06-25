<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<title>Panel Administrativo</title>
<link rel="icon" type="image/x-icon" href="{{ Asset('assets/img/logo.png') }}"/>
<link rel="icon" href="{{ Asset('assets/img/logo.png') }}" type="image/png" sizes="16x16">

<!-- NewsStyles -->
<!-- Bundle -->
<link href="{{ Asset('assets/css/bundle.min.css') }}" rel="stylesheet">
    <!-- Plugin Css -->

    <link href="{{ Asset('assets/css/line-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ Asset('assets/css/revolution-settings.min.css') }}" rel="stylesheet">
    <link href="{{ Asset('assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ Asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ Asset('assets/css/cubeportfolio.min.css') }}" rel="stylesheet">
    <link href="{{ Asset('assets/css/LineIcons.min.css') }}" rel="stylesheet">
    <link href="{{ Asset('assets/css/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ Asset('assets/css/slick.css') }}" rel="stylesheet">
    <link href="{{ Asset('assets/css/wow.css') }}" rel="stylesheet">

    <!-- Style Sheet -->
    <link href="{{ Asset('assets/css/nouislider.min.css') }}" rel="stylesheet">
    <link href="{{ Asset('assets/css/range-slider.css') }}" rel="stylesheet">
    <link href="{{ Asset('assets/css/style.css?v=') }}<?php echo time(); ?>" rel="stylesheet">
<!-- NewsStyles -->
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="90">



<!--login start-->
<section class="p-lg-0 login-sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12 position-relative d-flex align-items-center bg-1" style="height: 100vh;">
                
                <div class="wrap_cap_opa"></div>
                <div class="background_wrap" style="background-image: url('{{ Asset('assets/img/bg-store.png') }}')"></div>


                <div class="login-content text-center">

                    <img src="{{ asset('assets/img/logo.png') }}" class="logo_log">

                    <div class="wrap_log">
                         <!--title-->
                        <div class="title d-inline-block mb-4">
                            <h3 class="mb-3 heading">Panel de control</h3>
                            <p class="text">Ingresa Tus Accesos Administrativos.</p>
                        </div>

                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" style="background-color:#8e1313 !important;border-color:#8e1313;color:#fff !important;" role="alert">
                                <strong>ERROR : </strong> {{ Session::get('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                        @endif

                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissible fade show" style="background-color:#01a540 !important;border-color:#01a540 !important;color:#fff !important;" role="alert">
                                <strong>SUCCESS : </strong> {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif

                        <!--form-->
                        <form class="needs-validation" action="{{ $form_url }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-12">
                                <input class="form-control" type="text" name="username" placeholder="Username" required="required">
                            </div>
                            <div class="col-12">
                                <input class="form-control" type="password" name="password" placeholder="Contraseña" required="required">
                            </div>
                        </div>
                            <div class="form-button">
                                <button id="submit" type="submit" class="btn btn-large rounded-pill main-btn">Iniciar Sesión</button>
                            </div>
                        </form>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
</section>
<!--adress end-->


<!-- JavaScript -->
<script src="{{ Asset('assets/js/bundle.min.js') }}"></script>
<!-- Plugin Js -->
<script src="{{ Asset('assets/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ Asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ Asset('assets/js/parallaxie.min.js') }}"></script>
<script src="{{ Asset('assets/js/wow.min.js') }}"></script>
<!-- REVOLUTION JS FILES -->
<script src="{{ Asset('assets/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ Asset('assets/js/jquery.themepunch.revolution.min.js') }}"></script>
<!-- SLIDER REVOLUTION EXTENSIONS -->
<script src="{{ Asset('assets/js/extensions/revolution.extension.actions.min.js') }}"></script>
<script src="{{ Asset('assets/js/extensions/revolution.extension.carousel.min.js') }}"></script>
<script src="{{ Asset('assets/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
<script src="{{ Asset('assets/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{ Asset('assets/js/extensions/revolution.extension.migration.min.js') }}"></script>
<script src="{{ Asset('assets/js/extensions/revolution.extension.navigation.min.js') }}"></script>
<script src="{{ Asset('assets/js/extensions/revolution.extension.parallax.min.js') }}"></script>
<script src="{{ Asset('assets/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
<script src="{{ Asset('assets/js/extensions/revolution.extension.video.min.js') }}"></script>
<!--Tilt Js-->
<script src="{{ Asset('assets/js/TweenMax.min.js') }}"></script>
<!-- custom script-->
<script src="{{ Asset('assets/js/nouislider.min.js') }}"></script>
<script src="{{ Asset('assets/js/slick.min.js') }}"></script>
<script src="{{ Asset('assets/js/contact_us.js') }}"></script>
<script src="{{ Asset('assets/js/script.js') }}"></script>
</body>
</html>