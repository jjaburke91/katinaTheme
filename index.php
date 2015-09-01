<!DOCTYPE html>
<html ng-app="jordan_muir_app" ng-keydown="keypress($event)">

<script type="text/javascript">
    var template_directory = "<?php bloginfo('template_directory');?>";
</script>

<head>
    <title>{{page_title}}</title>

    <!-- bower:js -->
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/jquery/dist/jquery.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular/angular.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular-route/angular-route.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/bower_components/angular-animate/angular-animate.js"></script>
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

    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/dist/dist-app.js" defer ></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/jordanMuir.js" defer ></script>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css" />
</head>

<body >

    <header>
        <div id="about-container">
            <span id="about-container-link" ng-click="aboutModal.openModal()">About</span>
        </div>

        <div id="contact-link-container">
            <span id="contact-link" ng-click="contactModal.openModal()">Contact</span>
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


    <div id="content" class="view-transition" ng-view>
    </div>


    <div id="about-modal" class="modal" ng-show="aboutModal.visible" >

        <span class="modal-close"
              ng-click="aboutModal.closeModal()">
            <i class="fa fa-times fa-4x"></i>
        </span>

        <!-- <button id="about-modal-close-button" class="fadeInOut"
                ng-click="aboutModal.closeModal()">
            Close
        </button> -->

        <div id="about-modal-container">
            <h1>About</h1>
            <!--<p id="about-page-content" ng-bind-html="aboutModal.content | extractSurroundingTags:'p' | trustAsHtml"></p>-->
        </div>
    </div>


    <div id="contact-modal" class="modal" ng-show="contactModal.visible">

        <span class="modal-close"
              ng-click="contactModal.closeModal()">
            <i class="fa fa-times fa-4x"></i>
        </span>

        <div id="contact-modal-container">
            <contact-form></contact-form>
        </div>

    </div>

</body>

</html>
