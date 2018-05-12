jmApp.controller('projectListingController', ["$scope", "$rootScope", "wp", "projects", function( $scope, $rootScope, wp, projects) {
    $rootScope.page_title = "Jordan Muir";

    $scope.projects = projects;

    setTimeout($rootScope.clearHeaderTrim(), 300);

    window.setTimeout( function() {
        $rootScope.headerTrimWidth = '100%';
        $rootScope.$digest();
    }, 800);
}]);