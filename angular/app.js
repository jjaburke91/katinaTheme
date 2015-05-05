var jmApp = angular.module('jordan_muir_app', [
    'ngRoute'
]);


jmApp.config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'project-listing.html',
                controller: 'projectListingController'
            })
            .when('/post/:postId', {
                templateUrl: 'project.html',
                controller: 'projectController'
            })
            .when('/about', {
                templateUrl: 'about.html',
                controller: 'aboutController'
            })
            .when('/error', {
                templateUrl: '404.html',
                controller: 'errorController'
            })
            .otherwise({
                redirectTo: '/error'
            });

        //$locationProvider.html5Mode(false);
    }]);
