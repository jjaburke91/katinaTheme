jmApp.controller('projectController', ['$scope', '$rootScope', 'project', function( $scope, $rootScope, project) {
    $rootScope.page_title = project.title;
    $scope.project = project;

    $scope.project_highlight = "text-highlight-" + Math.floor( (Math.random()*6)+1); // make sure this is the same as highlight-colours available in stylesheet.

    function detectScrollToMoveProjectArrows() {
        var projectInformationScrollTop = $('#project-page-information-container').scrollTop() + 16,
            isFixed = false;

        console.log('detecting fixed scrolll');

        return function() {
            console.log( $(this).scrollTop());
            console.log( projectInformationScrollTop);

            if ( $(this).scrollTop() >= projectInformationScrollTop && !isFixed) {
                $('.project-changer').addClass('fixed-project-changer');
                isFixed = true;
                console.log("changing to fixed");
            } else if( $(this).scrollTop() <= projectInformationScrollTop && isFixed) {
                $('.project-changer').removeClass('fixed-project-changer');
                isFixed = false;
                console.log("changing to absolute");
            }
        }
    }

    $(window).scroll(_.throttle( detectScrollToMoveProjectArrows(), 500) );


}]);
