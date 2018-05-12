jmApp.controller('projectController', ['$scope', '$rootScope', 'project', function( $scope, $rootScope, project) {
    var pageTitle = 'Jordan Muir - ' + project.title;
    $rootScope.page_title = pageTitle;
    $scope.project = project;
    $scope.showProjectInformation = true;

    gtag('config', $rootScope.gaTrackingId, {
        'page_title': pageTitle,
        'page_path': window.location.href.replace("/#", ''),
        'page_location': window.location.href
    });

    $scope.informationHeight = $('#project-page-title-container').height() + 7;

    $scope.project_highlight = "text-highlight-" + Math.floor( (Math.random()*6)+1); // make sure this is the same as highlight-colours available in stylesheet.

    var viewWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    $scope.desktopAnimations = viewWidth > 1000;
    
    // Sets border trim feature
    setTimeout( function() {
        $rootScope.projectTitleColour = $scope.project_highlight;

        if ($scope.desktopAnimations) {
            $rootScope.projectTitleWidth = ($('#project-page-title').width() || 0) + 'px';
            $scope.projectDescriptionHeight = $('#project-page-description').height();
        } else {
            $rootScope.projectTitleWidth = '100%';
        }

        $rootScope.$digest();
    }, 1400);

    $scope.toggleProjectInformation = function() {
        $scope.showProjectInformation = !$scope.showProjectInformation;
    };

    function detectScrollToMoveProjectArrows() {
        var previousScrollTop = 0;
        var projectInformationScrollTop = $('#project-page-information-container').scrollTop() + 16;
        var projectInformationHeight = $('#project-page-information-container').height();

        return function() {
            var thisScrollTop = $(this).scrollTop();
            var hide = thisScrollTop >= (projectInformationHeight + projectInformationScrollTop);
            if ( hide && (previousScrollTop < thisScrollTop) && $scope.showProjectInformation) {
                $scope.showProjectInformation = false;
                $scope.$digest();
            } else if( (previousScrollTop > thisScrollTop) && !$scope.showProjectInformation) {
                $scope.showProjectInformation = true;
                $scope.$digest();
            }
            previousScrollTop = thisScrollTop;
        }
    }

    if ($scope.desktopAnimations) {
        $(window).scroll(
            _.throttle( detectScrollToMoveProjectArrows(), 50)
        );
    }
}]);
