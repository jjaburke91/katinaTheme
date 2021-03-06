<!DOCTYPE html>
<html ng-app="jordan_muir_app" ng-keydown="keypress($event)">

<script type="text/javascript">
    var template_directory = "<?php bloginfo('template_directory');?>";
</script>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charSet="utf-8"/>

    <!-- bower:js -->
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular/angular.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular-route/angular-route.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular-animate/angular-animate.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/underscore/underscore-min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>
    <!-- endbower -->

    <script type="text/javascript" src="http://imagesloaded.desandro.com/imagesloaded.pkgd.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>

    <!-- Zoom dependencies-->
    <script src="<?php bloginfo('template_directory'); ?>/lib/zoom/transition.js" type="text/javascript"></script>
    <script src="<?php bloginfo('template_directory'); ?>/lib/zoom/zoom.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/lib/zoom/zoom.css" />

    <!-- bower:css -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/bower_components/font-awesome/css/font-awesome.min.css" />
    <!-- endbower -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119130508-1"></script>
    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-119130508-1', { 'send_page_view': false });
    </script>

    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/dist/app.min.js" defer ></script>
    <!-- <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/dist/app.js" defer ></script> -->

    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css" />

    <title ng-cloak>{{page_title}}</title>
    <link rel="canonical" href="http://www.jordanmuir.co.uk" />
    <meta name="description" content="Jordan Muir. I am a creative freelance spatial & environmental designer based in London. I graduated from Duncan of Jordanstone College of Art and Design in 2014. Completing a degree in Interior and Environmental Design." />
    <meta property="og:description" content="Jordan Muir. I am a creative freelance spatial & environmental designer based in London. I graduated from Duncan of Jordanstone College of Art and Design in 2014. Completing a degree in Interior and Environmental Design." />
    <meta property="og:site_name" content="Jordan Muir" />
    <meta property="og:title" content="Jordan Muir - 3D / Spatial Designer" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://www.jordanmuir.co.uk" />
    <meta property="og:image:alt" content="Jordan Muir - 3D / Spatial Designer" />
</head>

<body class="hide-overflow" ng-class="{'hide-overflow': aboutModal.visible || contactModal.visible}">
    <jm-header></jm-header>

    <div id="content-container">
        <div id="content" class="view-transition" ui-view> </div>
    </div>

    <about-modal></about-modal>

    <div id="contact-modal" class="modal modal-transition" ng-show="contactModal.visible">
        <span class="modal-close"
              ng-click="contactModal.closeModal()">
            <i class="fa fa-times fa-4x"></i>
        </span>

        <div id="contact-modal-container">
            <contact-form ng-show="contactModal.visible"></contact-form>
        </div>
    </div>

    <div class="coming-soon-overlay">
        <div class="coming-soon-container">
            <h1>Jordan Muir<h1>
            <h2>update coming soon</h2>
        </div>
    </div>
</body>

</html>
