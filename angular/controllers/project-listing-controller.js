jmApp.controller('projectListingController', function( $scope, $rootScope, wp) {

    wp.getProjects()
        .success( function(response) {
            $scope.projects = response;
            console.log($scope.projects);
        })
        .error( function() {
            console.error("projectListingController: Error retrieving projects.")
        });

});