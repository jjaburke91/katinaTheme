jmApp.controller('projectController', ['$scope', '$rootScope', 'project', function( $scope, $rootScope, project) {
    $rootScope.page_title = project.title;
    $scope.project = project;

    $scope.project_highlight = "text-highlight-" + Math.floor( (Math.random()*6)+1); // make sure this is the same as highlight-colours available in stylesheet.


    console.log(project);

    window.scrollBy(0,0);


}]);
