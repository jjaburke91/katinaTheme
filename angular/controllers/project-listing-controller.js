jmApp.controller('projectListingController', ["$scope", "$rootScope", "wp", "projects", function( $scope, $rootScope, wp, projects) {
    $scope.pageClass = "project-listing";
    $scope.projects = projects;
    console.log(projects);

}]);