var jmApp = angular.module('jordan_muir_app', [
    'ngAnimate',
    'ui.router'
]);

jmApp.run( ["$rootScope", function($rootScope) {
    $rootScope.template_directory = template_directory;

    $rootScope.aboutModal = {
        visible: false,
        openModal: function() {
            $rootScope.aboutModal.visible = true;
        },
        closeModal: function() {
            $rootScope.aboutModal.visible = false;
        }
    };

    $rootScope.contactModal = {
        visible: false,
        openModal: function() {
            $rootScope.contactModal.visible = true;
        },
        closeModal: function() {
            $rootScope.contactModal.visible = false;
        }
    };

    $rootScope.keypress = function(event) {
        if (event.keyCode === 27) {
            $rootScope.aboutModal.closeModal();
            $rootScope.contactModal.closeModal();
        }
        if (event.keyCode === 74) {
            $rootScope.comingSoon = false
        }

    };

    $rootScope.$on("$routeChangeSuccess", function ( ) {
        $('html, body').animate({
            scrollTop: $("jm-header").offset().top,
            easing: 'easeInOutCirc'
        }, 1200);
    });

    $rootScope.clearHeaderTrim = function() {
        $rootScope.projectTitleColour = null;
        $rootScope.projectTitleWidth = 0;
    };

    $rootScope.comingSoon = false;
}]);

//todo: Don't think we should be using template directory in the routing, bypassing template cache?
jmApp.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise('/');

    $stateProvider
        .state('project-listing', {
            url: '/',
            controller: 'projectListingController',
            templateUrl: template_directory+'/angular/views/project-listing.html',
            resolve: {
                projects: function(wp) {
                    return wp.getProjects();
                }
            },
            onExit: function($rootScope) {
                $rootScope.headerTrimWidth = '0px';
            }
        })
        .state('project', { // NOTE: The '/' at end of URL has affect on ng-leave and ng-enter
            url: '/project/:project_slug/',
            templateUrl: template_directory+'/angular/views/project.html',
            controller: 'projectController',
            resolve: {
                project: function(wp, $stateParams) {
                    return wp.getProjectWithSlug($stateParams.project_slug);
                }
            },
            onExit: function($rootScope) {
                $rootScope.projectTitleWidth = 0;
            }
        });
}]);


/** Filters **/

jmApp.filter('trustAsResourceUrl', ['$sce', function($sce) {
    return function(val) {
        return $sce.trustAsResourceUrl(val);
    };
}]);
;/**
 * Remember! Every filter using in a bind will be executed during each digest cycle.
 * Think about efficiency here, I bet a lot of this doesn't need to be dynamically generated.
 */

jmApp.filter('extractSurroundingTags', function() {
    /**
     * @deprecated ng-bind-html and $sce can sort this issue out.
     */
    return function(input, tag) {
        var result = "";
        if ( typeof input === 'string' ) {
            input = input || '';

            var leadingSearchString = "<" + tag + ">";
            var closingSearchString = "</" + tag + ">";

            result = input.replace(leadingSearchString, "");
            result = result.replace(closingSearchString, "");
        } else {
            console.error("extractSurroundingTags: input is not a string:");
            //console.error(input);
        }

        return result;
    }
});

jmApp.filter('trustAsHtml', function($sce){
    return function(input){
        return $sce.trustAsHtml(input);
    }
});;jmApp.factory('wp', function($http) {
    var projects_url = "wp-json/katinaAPI/projects/";
    var project_by_slug_url = "wp-json/katinaAPI/project/";
    var contact_form_post_url = "wp-json/katinaAPI/contact/";

    return {
        getProjects: function() {
            return $http.get(projects_url).then(
                function success(response) {
                    return response.data;
                },
                function error() {
                    console.error("wp: Error retrieving projects.");
                }
            );
        },

        getProjectWithSlug: function(project_slug) {
            return $http.get(project_by_slug_url + project_slug).then(
                function success(response) {
                    return response.data;
                },
                function error() {
                    console.error("wp: Error retrieving project with name " + project_slug + ".");
                }
            );
        },

        postContactForm: function(data) {
            console.log("Posting following contact data");
            console.log(data);
            return $http.post(contact_form_post_url, data).then(
                function success(response) {
                    console.log(response);
                },
                function error(response) {
                    console.error(response);
                }
            )
        },

        // TODO: Hate how this is done - fix this.
        getAboutPage: function() {
            var aboutPageId = window.location.hostname.indexOf('.dev') > 0 ? 9 : 323;

            return $http.get("wp-json/pages/" + aboutPageId).then(
                function success(response) {
                    return response.data;
                },
                function error() {
                    console.error("wp: Error retrieving About Page content.");
                }

            );
        }
    }
});;jmApp.controller('errorController', function( $scope, $routeParams, $log, wp) {
    console.log($routeParams);

});;jmApp.controller('projectController', ['$scope', '$rootScope', 'project', function( $scope, $rootScope, project) {
    $rootScope.page_title = project.title;
    $scope.project = project;
    $scope.showProjectInformation = true;
    console.log(project);

    $scope.informationHeight = $('#project-page-title-container').height() + 7;

    $scope.project_highlight = "text-highlight-" + Math.floor( (Math.random()*6)+1); // make sure this is the same as highlight-colours available in stylesheet.

    // Sets border trim feature
    setTimeout( function() {
        $rootScope.projectTitleColour = $scope.project_highlight;
        $rootScope.projectTitleWidth = $('#project-page-title').width() || 0;

        $scope.projectDescriptionHeight = $('#project-page-description').height();

        $rootScope.$digest();
    }, 1400);

    $scope.toggleProjectInformation = function() {
        $scope.showProjectInformation = !$scope.showProjectInformation;
    };

    function detectScrollToMoveProjectArrows() {
        var previousScrollTop = 0;
        var projectInformationScrollTop = $('#project-page-information-container').scrollTop() + 16;
        var projectInformationHeight = $('#project-page-information-container').height();
        isFixed = false;

        return function() {
            var thisScrollTop = $(this).scrollTop();
            var hide = thisScrollTop >= (projectInformationHeight + projectInformationScrollTop);
            if ( hide && (previousScrollTop < thisScrollTop) && $scope.showProjectInformation) {
                console.log("hiding info");
                $scope.showProjectInformation = false;
                // $scope.informationHeight = $('#project-page-title-container').height() + 7;
                $scope.$digest();
            } else if( (previousScrollTop > thisScrollTop) && !$scope.showProjectInformation) {
                console.log("showing info");
                $scope.showProjectInformation = true;
                $scope.$digest();
            }
            previousScrollTop = thisScrollTop;
        }
    }

    $(window).scroll(
        _.throttle( detectScrollToMoveProjectArrows(), 500)
    );
}]);
;jmApp.controller('projectListingController', ["$scope", "$rootScope", "wp", "projects", function( $scope, $rootScope, wp, projects) {
    $rootScope.page_title = "Jordan Muir";

    $scope.projects = projects;

    console.log(projects);

    setTimeout($rootScope.clearHeaderTrim(), 300);

    // Stops bug where masonry aligns the images before the content has actually been retrieved.
    // $scope.masonryLoaded = false;
    // var $container = $('.listing-grid');
    // window.setTimeout( function() {
    //     $container.imagesLoaded( function(){
    //         $container.masonry({
    //             itemSelector : '.grid-item',
    //             columnWidth: 200,
    //             isAnimated: true,
    //             isFitWidth: true,
    //             transitionDuration: '0.3s'
    //         });
    //     });
    //     $scope.masonryLoaded = true;
    //     $scope.$digest();
    // }, 500);

    window.setTimeout( function() {
        $rootScope.headerTrimWidth = '100%';
        $rootScope.$digest();
    }, 800);

}]);;jmApp.directive('aboutModal', function() {

    function controller($scope, $rootScope, wp) {
        wp.getAboutPage().then(
            function success(response) {
                $scope.aboutModal.content = response.content;
            },
            function error(response){
                console.error("Error retrieving about page.");
            }
        );
    }

    return {
        restrict: 'E',
        scope: false,
        templateUrl: template_directory+'/angular/directives/about-modal/about-modal.html',
        controller: controller
    }
});
;jmApp.directive('contactForm', function() {
    return {
        restrict: 'E',
        scope: {}, // isolating scope
        templateUrl: template_directory+'/angular/directives/contact-form/contact-form.html',
        controller: "contactFormController"
    }
});


jmApp.controller('contactFormController', ["$scope", "wp", function($scope, wp) {

    $scope.contactFormData = {
        name: "",
        email: "",
        subject: "",
        message: ""
    };

    $scope.submitContactForm = function(valid) {
        if (valid) {
            wp.postContactForm($scope.contactFormData);
        }
    }

}]);;jmApp.directive('jmHeader', function() {

    function controller($scope, $rootScope, $state) {
        $scope.template_dir = $rootScope.template_directory;

        //function detectScrollDirection() {
        //    var lastScrollTop = $(this).scrollTop(),
        //        headerHeight = $('header').outerHeight(),
        //        headerIsHidden = false;
        //
        //    return function() {
        //        var currentScrollTop = $(this).scrollTop();
        //
        //        if (currentScrollTop > headerHeight || headerIsHidden) {
        //            if (lastScrollTop < currentScrollTop && !headerIsHidden) {
        //                $('header').addClass('hide-header');
        //                headerIsHidden = true;
        //            } else if (lastScrollTop > currentScrollTop && headerIsHidden) {
        //                $('header').removeClass('hide-header');
        //                headerIsHidden = false;
        //            }
        //        }
        //
        //        lastScrollTop = currentScrollTop;
        //    }
        //}

        //$(window).scroll(_.throttle( detectScrollDirection(), 500) );
    }

    return {
        restrict: 'E',
        scope: true,
        templateUrl: template_directory+'/angular/directives/header/header.html',
        controller: controller
    }
});
;jmApp.directive('projectListingItem', function() {
    return {
        restrict: 'E',
        scope: {
            project: "=project"
        },
        templateUrl: template_directory+'/angular/directives/project-listing-item/project-listing-item.html'
    }
});;angular.module('templates-dist', ['../angular/views/404.html', '../angular/views/project-listing.html', '../angular/views/project.html', '../angular/directives/about-modal/about-modal.html', '../angular/directives/contact-form/contact-form.html', '../angular/directives/header/header.html', '../angular/directives/project-listing-item/project-listing-item.html']);

angular.module("../angular/views/404.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("../angular/views/404.html",
    "<h1>Page not found.</h1>");
}]);

angular.module("../angular/views/project-listing.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("../angular/views/project-listing.html",
    "<div id=\"project-listing-margin\">\n" +
    "    <div id=\"project-listing-container\" class=\"listing-grid\" >\n" +
    "\n" +
    "        <span class=\"project-listing-item-container\"\n" +
    "              ng-repeat=\"project in projects\">\n" +
    "            <project-listing-item\n" +
    "                    class=\"grid-item\"\n" +
    "                    project=\"project\"\n" +
    "                    >\n" +
    "            </project-listing-item>\n" +
    "        </span>\n" +
    "    </div>\n" +
    "\n" +
    "</div>");
}]);

angular.module("../angular/views/project.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("../angular/views/project.html",
    "<div id=\"project-page-container\">\n" +
    "\n" +
    "    <div id=\"project-page-information-container\" class=\"zoom--custom\">\n" +
    "\n" +
    "        <div id=\"project-page-information-center\" >\n" +
    "            <a class=\"prev-project-container project-changer\" ng-show=\"project.previous_post\" href=\"{{project.previous_post}}\" >\n" +
    "                <i class=\"fa fa-angle-left fa-3x\"></i>\n" +
    "            </a>\n" +
    "\n" +
    "            <!--<div id=\"project-page-information-content\" style=\"min-height: {{informationHeight}}px\">-->\n" +
    "            <div id=\"project-page-information-content\" ng-class=\"{'hide': !showProjectInformation}\" >\n" +
    "                <div id=\"project-page-title-container\" ng-click=\"toggleProjectInformation()\">\n" +
    "                    <h1 id=\"project-page-title\" class=\"{{project_highlight}}\">{{project.title}}</h1>\n" +
    "                </div>\n" +
    "\n" +
    "                <div id=\"project-page-description\"\n" +
    "                     style=\"max-height: {{(projectDescriptionHeight || 300) + 14}}px;\"\n" +
    "                     ng-bind-html=\"project.description | trustAsHtml\"></div>\n" +
    "\n" +
    "                <div class=\"see-more-information\" ng-click=\"toggleProjectInformation()\" ng-if=\"!showProjectInformation\">\n" +
    "                    <span class=\"fa fa-circle {{project_highlight}}\" ></span>\n" +
    "                    <span class=\"fa fa-circle {{project_highlight}}\" ></span>\n" +
    "                    <span class=\"fa fa-circle {{project_highlight}}\" ></span>\n" +
    "                </div>\n" +
    "\n" +
    "                <span id=\"title-colour-trim\" class=\"{{projectTitleColour}}\" ng-style=\"{'width': projectTitleWidth+'px' }\"></span>\n" +
    "            </div>\n" +
    "\n" +
    "            <a class=\"next-project-container project-changer\" ng-show=\"project.next_post\" href=\"{{project.next_post}}\" >\n" +
    "                <i class=\"fa fa-angle-right fa-3x\"></i>\n" +
    "            </a>\n" +
    "        </div>\n" +
    "    </div>\n" +
    "\n" +
    "    <div id=\"project-page-media\">\n" +
    "        <div class=\"project-page-image-content-container project-image-col-width-{{project_media.column_width}}\"\n" +
    "             ng-repeat=\"project_media in project.attachments | orderBy: 'order'\">\n" +
    "\n" +
    "            <div class=\"project-video-container project-youtube-video\" ng-if=\"project_media.type == 'video' && (project_media.src.indexOf('.youtube.') > -1)\">\n" +
    "                <iframe type=\"text/html\" frameborder=\"0\"\n" +
    "                        ng-src=\"{{project_media.src + '?origin=www.jordanmuir.co.uk&controls=2&showinfo=0&rel=0&iv_load_policy=3&fs=1' | trustAsResourceUrl}}\"></iframe>\n" +
    "            </div>\n" +
    "\n" +
    "            <div class=\"project-video-container project-vimeo-video\" ng-if=\"project_media.type == 'video' && (project_media.src.indexOf('.vimeo.') > -1)\">\n" +
    "                <iframe ng-src=\"{{project_media.src + '?badge=0&byline=0&portrait=0&title=0' | trustAsResourceUrl}}\"\n" +
    "                        frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>\n" +
    "            </div>\n" +
    "\n" +
    "            <div class=\"project-page-image-container\" ng-if=\"project_media.type == 'image'\">\n" +
    "                <img src=\"{{project_media.img}}\" data-action=\"zoom\"/>\n" +
    "                <p ng-bind=\"project_media.caption\" ng-if=\"project_media.type == 'image'\"></p>\n" +
    "            </div>\n" +
    "        </div>\n" +
    "\n" +
    "    </div>\n" +
    "    <div id=\"mobile-project-changer\">\n" +
    "        <a id=\"mobile-prev-project\" ng-show=\"project.previous_post\" href=\"{{project.previous_post}}\" >Previous Project</a>\n" +
    "        <a id=\"mobile-next-project\" ng-show=\"project.next_post\" href=\"{{project.next_post}}\" >Next Project</a>\n" +
    "    </div>\n" +
    "</div>");
}]);

angular.module("../angular/directives/about-modal/about-modal.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("../angular/directives/about-modal/about-modal.html",
    "<div id=\"about-modal\" class=\"modal modal-transition\"\n" +
    "     ng-show=\"aboutModal.visible\">\n" +
    "\n" +
    "    <span class=\"modal-close\"\n" +
    "          ng-click=\"aboutModal.closeModal()\">\n" +
    "        <i class=\"fa fa-times fa-4x\"></i>\n" +
    "    </span>\n" +
    "\n" +
    "    <!-- <button id=\"about-modal-close-button\" class=\"fadeInOut\"\n" +
    "            ng-click=\"aboutModal.closeModal()\">\n" +
    "        Close\n" +
    "    </button> -->\n" +
    "\n" +
    "    <div id=\"about-modal-container\">\n" +
    "        <h1>About</h1>\n" +
    "        <div id=\"about-left-panel\">\n" +
    "            <p id=\"about-page-content\" ng-bind-html=\"aboutModal.content | trustAsHtml\"></p>\n" +
    "            <div id=\"about-media-links\">\n" +
    "                <a href=\"mailto:hello@jordanmuir.co.uk\">\n" +
    "                    <img class=\"media-icon\" src=\"{{template_directory}}/img/media-icons/Email.svg\" />\n" +
    "                </a>\n" +
    "                <a href=\"https://www.linkedin.com/pub/jordan-muir/75/447/896\" target=\"_blank\">\n" +
    "                    <img class=\"media-icon\" src=\"{{template_directory}}/img/media-icons/linkin.svg\" />\n" +
    "                </a>\n" +
    "                <a href=\"{{template_directory}}/share/Jordan Muir CV.pdf\" download>\n" +
    "                    <img class=\"media-icon-less-padding\" src=\"{{template_directory}}/img/media-icons/CV.svg\" />\n" +
    "                </a>\n" +
    "                <a href=\"{{template_directory}}/share/Jordan Muir Portfolio.pdf\" download>\n" +
    "                    <img class=\"media-icon-less-padding\" src=\"{{template_directory}}/img/media-icons/Folio.svg\" />\n" +
    "                </a>\n" +
    "            </div>\n" +
    "        </div>\n" +
    "\n" +
    "        <div id=\"about-photo-container\">\n" +
    "            <!--<img src=\"{{template_directory}}/img/jordancheeser.png\"/>-->\n" +
    "        </div>\n" +
    "    </div>\n" +
    "\n" +
    "\n" +
    "</div>");
}]);

angular.module("../angular/directives/contact-form/contact-form.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("../angular/directives/contact-form/contact-form.html",
    "<form id=\"contact-form\" name=\"contactForm\"\n" +
    "      ng-submit=\"submitContactForm(contactForm.$valid)\" novalidate>\n" +
    "\n" +
    "    <div class=\"form-input-container\">\n" +
    "        <label class=\"form-label\" for=\"form-name\">Your Name</label>\n" +
    "        <input id=\"form-name\" name=\"form-name\" type=\"text\"\n" +
    "               ng-class=\"{'form-input-highlight': contactFormData.name != ''}\"\n" +
    "               ng-model=\"contactFormData.name\" />\n" +
    "\n" +
    "        <p class=\"form-error\"></p>\n" +
    "    </div>\n" +
    "\n" +
    "    <div class=\"form-input-container\">\n" +
    "        <label class=\"form-label\" for=\"form-email\">Your Email</label>\n" +
    "        <input id=\"form-email\" name=\"form-email\" type=\"email\"\n" +
    "               ng-class=\"{'form-input-highlight': contactFormData.email != ''}\"\n" +
    "               ng-model=\"contactFormData.email\"/>\n" +
    "\n" +
    "        <p class=\"form-error\"></p>\n" +
    "    </div>\n" +
    "\n" +
    "    <div class=\"form-input-container\">\n" +
    "        <label class=\"form-label\" for=\"form-subject\">Subject</label>\n" +
    "        <input id=\"form-subject\" name=\"form-subject\" type=\"text\"\n" +
    "               ng-class=\"{'form-input-highlight': contactFormData.subject != ''}\"\n" +
    "               ng-model=\"contactFormData.subject\"/>\n" +
    "\n" +
    "        <p class=\"form-error\"></p>\n" +
    "    </div>\n" +
    "\n" +
    "    <div class=\"form-input-container\">\n" +
    "        <label class=\"form-label form-label-message\" for=\"form-message\">Message</label>\n" +
    "        <textarea id=\"form-message\" name=\"form-message\"\n" +
    "                  ng-class=\"{'form-textarea-highlight': contactFormData.message != ''}\"\n" +
    "                  ng-model=\"contactFormData.message\"></textarea>\n" +
    "\n" +
    "        <p class=\"form-error\"></p>\n" +
    "    </div>\n" +
    "\n" +
    "    <button type=\"submit\" class=\"contact-form-button\" ng-class=\"{'form-button-valid': (contactForm.$valid == true)}\">\n" +
    "        Send\n" +
    "    </button>\n" +
    "\n" +
    "</form>");
}]);

angular.module("../angular/directives/header/header.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("../angular/directives/header/header.html",
    "<header id=\"header\" class=\"zoom--custom\">\n" +
    "    <div id=\"header-content\">\n" +
    "        {{isHomePage}}\n" +
    "         <div id=\"title-container\">\n" +
    "            <a ui-sref=\"project-listing\">\n" +
    "                <h2>Jordan Muir</h2>\n" +
    "            </a>\n" +
    "        </div>\n" +
    "        <div id=\"subtitle-container\">\n" +
    "            <h2>3D / Spatial Designer</h2>\n" +
    "        </div>\n" +
    "\n" +
    "        <div id=\"about-contact-container\" >\n" +
    "            <h2 id=\"about-link\" ng-click=\"aboutModal.openModal()\">About</h2>\n" +
    "            <h2 id=\"contact-link\" ng-click=\"contactModal.openModal()\">Contact</h2>\n" +
    "        </div>\n" +
    "\n" +
    "        <span id=\"header-colour-trim\" ng-style=\"{'width': headerTrimWidth }\"></span>\n" +
    "    </div>\n" +
    "</header>");
}]);

angular.module("../angular/directives/project-listing-item/project-listing-item.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("../angular/directives/project-listing-item/project-listing-item.html",
    "<a href=\"{{project.url}}\">\n" +
    "    <img class=\"grid-img listing-item-text-container\"\n" +
    "         ng-if=\"project.thumbnail_img\"\n" +
    "         src=\"{{project.thumbnail_img}}\"\n" +
    "     />\n" +
    "</a>");
}]);
