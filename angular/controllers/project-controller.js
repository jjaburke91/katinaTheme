jmApp.controller('projectController', function( $scope, $routeParams, wp) {
    $scope.pageClass = "project";

    var projectName = $routeParams.postName.replace('-', ' ');
    projectName = projectName.replace('-', ' ');
    console.log("Project Name: " + projectName);

    // todo: Search by slug instead!!!!
    wp.getProjectWithName( projectName )
        .success( function(response) {
            var project = response;

            // Handles scenario where the post name query returns multiple projects. Checking for matching length should be sufficient.
            if (response.length > 1) {
                for (var i=0; i < response.length; i++) {
                    if (response[i].title.length == projectName.length) {
                        project = response[i];
                        break;
                    }
                }
            }

            $scope.project = project;
            console.log($scope.project);
        })
        .error( function() {
            console.error("projectController: Error retrieving project with postName '" + projectName + "'.");
        });

});
