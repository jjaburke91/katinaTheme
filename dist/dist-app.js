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

    $rootScope.$on('$stateChangeStart', function() {
        setTimeout( function() {
            // $('html, body').animate({
            //     scrollTop: $("jm-header").offset().top,
            //     easing: 'easeInOutCirc'
            // }, 1200);
            window.scrollTo(0, 0);
        }, 700);
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

    var viewWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    $scope.desktopAnimations = viewWidth > 1000;
    
    // Sets border trim feature
    setTimeout( function() {
        $rootScope.projectTitleColour = $scope.project_highlight;


        if ($scope.desktopAnimations) {
            $rootScope.projectTitleWidth = ($('#project-page-title').width() || 0) + 'px';
            $scope.projectDescriptionHeight = $('#project-page-description').height();
        } else {
            $rootScope.projectTitleWidth = '100%';
        }

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

    if ($scope.desktopAnimations) {
        $(window).scroll(
            _.throttle( detectScrollToMoveProjectArrows(), 500)
        );
    }
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
});