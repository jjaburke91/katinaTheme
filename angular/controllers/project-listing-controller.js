jmApp.controller('projectListingController', function( $scope, $rootScope, wp) {
    $scope.pageClass = "project-listing";

    wp.getProjects()
        .success( function(response) {
            $scope.projects = response;
            console.log($scope.projects);
        })
        .error( function() {
            console.error("projectListingController: Error retrieving projects.")
        });

});