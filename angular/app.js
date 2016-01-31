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
