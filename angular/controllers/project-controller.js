jmApp.controller('projectController', ['$scope', '$rootScope', 'project', function( $scope, $rootScope, project) {
    $rootScope.page_title = project.title;
    $scope.project = project;

    $scope.project_highlight = "text-highlight-" + Math.floor( (Math.random()*6)+1); // make sure this is the same as highlight-colours available in stylesheet.

    setTimeout( function() {
        $rootScope.projectTitleColour = $scope.project_highlight;
        $rootScope.projectTitleWidth = $('#project-page-title').width() || 0;

        console.log("setting colour and width");
        console.log($rootScope.projectTitleWidth);

        $rootScope.$digest();
    }, 2000);

    function detectScrollToMoveProjectArrows() {
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

    $(window).scroll(_.throttle( detectScrollToMoveProjectArrows(), 500) );
}]);
