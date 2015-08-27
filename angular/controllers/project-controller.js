jmApp.controller('projectController', ['$scope', 'project', function( $scope, project) {
    $scope.pageClass = "project";
    $scope.project = project;
    console.log(project);

}]);
