<!DOCTYPE html>
<html>

<script type="text/javascript">
    var template_directory = "<?php bloginfo('template_directory');?>";
</script>

<head>
    <title>Jordan Muir</title>
    <!-- todo: Consider deferring imports once they're local -->
    <!-- bower:js -->
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/jquery/dist/jquery.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular/angular.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular-route/angular-route.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular-animate/angular-animate.js"></script>
    <!-- endbower -->

    <!-- bower:css -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/bower_components/font-awesome/css/font-awesome.css" />
    <!-- endbower -->

    <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>-->

    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/dist/dist-app.js" defer ></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/jordanMuir.js" defer ></script>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css" />
</head>

<body ng-app="jordan_muir_app" >

    <header>
        <div id="about-container">
            <span id="about-container-link" ng-click="aboutModal.openModal()">About</span>
        </div>

        <div id="logo-container">
            <a href="#/">
                <h1>Jordan Muir</h1>
            </a>
        </div>

        <div id="media-icon-container">
            <a class="media-icon" href="http://www.linkedin.com/pub/jordan-muir/75/447/896" target="_blank">
                <i class="fa fa-linkedin fa-lg"></i>
            </a>
        </div>
    </header>


    <div id="content" class="{{pageClass}}" ng-view>
    </div>

    <div id="about-modal" class="fadeInOut" ng-show="aboutModal.visible" ng-keypress="($event.which === 72) ? aboutModal.closeModal() : null">
        <!--Get esc. to close modal-->

        <span id="about-modal-close" ng-click="aboutModal.closeModal()">
            <i class="fa fa-times fa-4x"></i>
        </span>

        <div id="about-modal-container">
            <h1 id="about-page-title">About</h1>
            <p id="about-page-content" ng-bind-html="aboutModal.content | extractSurroundingTags:'p' | trustAsHtml">
            </p>
        </div>
    </div>

</body>

</html>
