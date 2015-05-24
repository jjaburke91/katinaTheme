var jmApp = angular.module('jordan_muir_app', ['ngRoute', 'ngAnimate'])
    .run( function($rootScope, wp) {
        $rootScope.template_directory = template_directory;

        // About Modal functions, could this be exported to a service or factory?
        $rootScope.aboutModal = {};
        $rootScope.aboutModal.visible = false;
        $rootScope.aboutModal.openModal = function() {
            $rootScope.aboutModal.visible = true;
            $('body').css('overflow-y', 'hidden');
        };
        $rootScope.aboutModal.closeModal = function() {
            $rootScope.aboutModal.visible = false;
            $('body').css('overflow-y', 'scroll');
        };
        $rootScope.aboutModal.toggleModal = function() {
            $rootScope.aboutModal.visible = !$rootScope.aboutModal.visible;
        };
        $rootScope.aboutModal.isItVisible = function() {
            console.log($rootScope.aboutModal.visible);
        };

        wp.getAboutPage()
            .success( function(response) {
                $rootScope.aboutModal.content = response.content;
            })
            .error( function() {
                console.error("aboutController: Error retrieving about page.");
            });

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
            .when('/error', {
                templateUrl: template_directory+'/angular/views/404.html',
                controller: 'errorController'
            })
            .otherwise({
                redirectTo: '/error'
            });

        //$locationProvider.html5Mode(false);
    }]);
