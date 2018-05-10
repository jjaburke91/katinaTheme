<!DOCTYPE html>
<html ng-app="jordan_muir_app" ng-keydown="keypress($event)">

<script type="text/javascript">
    var template_directory = "<?php bloginfo('template_directory');?>";
</script>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- bower:js -->
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/jquery/dist/jquery.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular/angular.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular-route/angular-route.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular-animate/angular-animate.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/underscore/underscore.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular-ui-router/release/angular-ui-router.js"></script>
    <!-- endbower -->

    <script src="http://imagesloaded.desandro.com/imagesloaded.pkgd.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.js"></script>

    <!-- Zoom dependencies-->
    <script src="<?php bloginfo('template_directory'); ?>/lib/zoom/transition.js" type="text/javascript"></script>
    <script src="<?php bloginfo('template_directory'); ?>/lib/zoom/zoom.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/lib/zoom/zoom.css" />

    <!-- bower:css -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/bower_components/font-awesome/css/font-awesome.css" />
    <!-- endbower -->

    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/dist/app.min.js" defer ></script>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css" />

    <title ng-cloak>{{page_title}}</title>

</head>

<body ng-class="{'hide-overflow': aboutModal.visible || contactModal.visible}">
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
