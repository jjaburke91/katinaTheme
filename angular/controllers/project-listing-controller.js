jmApp.controller('projectListingController', ["$scope", "$rootScope", "wp", "projects", function( $scope, $rootScope, wp, projects) {
    $scope.pageClass = "project-listing";
    $scope.projects = projects;
    //console.log(projects);
    //console.log(template_directory+'/angular/directives/project-listing-item/project-listing-item.html');

    //wp.getProjects()
    //    .success( function(response) {
    //        $scope.projects = response;
    //        console.log($scope.projects);
    //    })
    //    .error( function() {
    //        console.error("projectListingController: Error retrieving projects.")
    //    });

}]);