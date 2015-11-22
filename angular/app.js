var jmApp = angular.module('jordan_muir_app', ['ngRoute', 'ngAnimate']);

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
    };

    $rootScope.$on("$routeChangeSuccess", function ( ) {
        $('html, body').animate({
            scrollTop: $("jm-header").offset().top,
            easing: 'easeInOutCirc'
        }, 1200);
    });

}]);

//todo: Don't think we should be using template directory in the routing, bypassing template cache?

jmApp.config(['$routeProvider', function($routeProvider) {

    $routeProvider
        .when('/', {
            templateUrl: template_directory+'/angular/views/project-listing.html',
            controller: 'projectListingController',
            resolve: {
                projects: function(wp) {
                    return wp.getProjects();
                }
            }
        })
        .when('/project/:project_slug/', { // NOTE: The '/' at end of URL has affect on ng-leave and ng-enter
            templateUrl: template_directory+'/angular/views/project.html',
            controller: 'projectController',
            resolve: {
                project: function(wp, $route) {
                    return wp.getProjectWithSlug($route.current.params.project_slug);
                }
            }
        })
        .when('/error', {
            templateUrl: template_directory+'/angular/views/404.html',
            controller: 'errorController'
        })
        .otherwise({
            redirectTo: '/error'
        });

    //$locationProvider.html5Mode(false);
}]);
