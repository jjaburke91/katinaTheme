var jmApp = angular.module('jordan_muir_app', ['ngRoute', 'ngAnimate'])
    .run( function($rootScope) {
        $rootScope.template_directory = template_directory;
    });

//todo: Don't think we should be using template directory in the routing, bypassing template cache

jmApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: template_directory+'/angular/views/project-listing.html',
                controller: 'projectListingController'
            })
            .when('/project/:postName', {
                templateUrl: template_directory+'/angular/views/project.html',
                controller: 'projectController'
            })
            .when('/about', {
                templateUrl: template_directory+'/angular/views/about.html',
                controller: 'aboutController'
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
