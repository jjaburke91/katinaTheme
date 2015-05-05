var jmApp = angular.module('jordan_muir_app', [
    'ngRoute'
]);

console.log("Hello from app.js");

jmApp.config(['$routeProvider', '$templateCache',
    function($routeProvider, $templateCache) {
        $routeProvider
            .when('/', {
                templateUrl: '<?php bloginfo(\'template_directory\'); ?>/project-listing.html',
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
