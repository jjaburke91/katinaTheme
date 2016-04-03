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

        $scope.projectDescriptionHeight = $('#project-page-description').height();

        $rootScope.$digest();
    }, 1400);

    $scope.toggleProjectInformation = function() {
        $scope.showProjectInformation = !$scope.showProjectInformation;
    };

    function detectScrollToMoveProjectArrows() {
        var previousScrollTop = 0;
        var projectInformationScrollTop = $('#project-page-information-container').scrollTop() + 16;
        var projectInformationHeight = $('#project-page-information-container').height();
        isFixed = false;

        return function() {
            var thisScrollTop = $(this).scrollTop();
            var hide = thisScrollTop >= (projectInformationHeight + projectInformationScrollTop);
            if ( hide && (previousScrollTop < thisScrollTop) && $scope.showProjectInformation) {
                console.log("hiding info");
                $scope.showProjectInformation = false;
                $scope.$digest();
            } else if( (previousScrollTop > thisScrollTop) && !$scope.showProjectInformation) {
                console.log("showing info");
                $scope.showProjectInformation = true;
                $scope.$digest();
            }
            previousScrollTop = thisScrollTop;
        }
    }

    $(window).scroll(
        _.throttle( detectScrollToMoveProjectArrows(), 500)
    );
}]);
