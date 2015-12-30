jmApp.controller('projectController', ['$scope', '$rootScope', 'project', function( $scope, $rootScope, project) {
    $rootScope.page_title = project.title;
    $scope.project = project;
    $scope.showProjectInformation = true;
    console.log(project);

    $scope.project_highlight = "text-highlight-" + Math.floor( (Math.random()*6)+1); // make sure this is the same as highlight-colours available in stylesheet.

    // Sets border trim feature
    setTimeout( function() {
        $rootScope.projectTitleColour = $scope.project_highlight;
        $rootScope.projectTitleWidth = $('#project-page-title').width() || 0;

        $rootScope.$digest();
    }, 1400);

    $scope.toggleProjectInformation = function() {
        $scope.showProjectInformation = !$scope.showProjectInformation;
    };

/*    function detectScrollToMoveProjectArrows() {
     var projectInformationScrollTop = $('#project-page-information-container').scrollTop() + 16,
     isFixed = false;

     return function() {
     if ( $(this).scrollTop() >= projectInformationScrollTop && !isFixed) {
     $('.project-changer').addClass('fixed-project-changer');
     isFixed = true;
     } else if( $(this).scrollTop() <= projectInformationScrollTop && isFixed) {
     $('.project-changer').removeClass('fixed-project-changer');
     isFixed = false;
     }
     }
     }

     $(window).scroll(
     _.throttle( detectScrollToMoveProjectArrows(), 500)
     );*/
}]);
