jmApp.controller('projectController', ['$scope', '$rootScope', 'project', function( $scope, $rootScope, project) {
    $rootScope.page_title = project.title;
    $scope.project = project;
    console.log(project);

    window.scrollBy(0,0);


}]);
