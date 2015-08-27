var jmApp = angular.module('jordan_muir_app', ['ngRoute', 'ngAnimate']);

jmApp.run( function($rootScope, wp, $templateCache) {

        $templateCache.removeAll();

        $rootScope.template_directory = template_directory;

        // About Modal functions, could this be exported to a service or factory?
        $rootScope.aboutModal = {};
        $rootScope.aboutModal.visible = false;
        $rootScope.aboutModal.openModal = function() {
            $rootScope.aboutModal.visible = true;
        };
        $rootScope.aboutModal.closeModal = function() {
            $rootScope.aboutModal.visible = false;
        };

        $rootScope.keypress = function(event) {
            if (event.keyCode === 27) {
                $rootScope.aboutModal.closeModal();
            }
        }

    });

//todo: Don't think we should be using template directory in the routing, bypassing template cache

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
        .when('/project/:project_slug', {
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
