var jmApp = angular.module('jordan_muir_app', ['ngRoute', 'ngAnimate']);

jmApp.run( ["$rootScope", function($rootScope) {
    $rootScope.template_directory = template_directory;

    // About Modal functions, could this be exported to a service or factory?
    $rootScope.aboutModal = {};
    $rootScope.aboutModal.visible = false;
    $rootScope.aboutModal.openModal = function() {
        $rootScope.aboutModal.visible = true;
        console.log($rootScope.aboutModal.visible);
    };
    $rootScope.aboutModal.closeModal = function() {
        $rootScope.aboutModal.visible = false;
    };

    $rootScope.contactModal = {};
    $rootScope.contactModal.visible = false;
    $rootScope.contactModal.openModal = function() {
        $rootScope.contactModal.visible = true;
    };
    $rootScope.contactModal.closeModal = function() {
        $rootScope.contactModal.visible = false;
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
