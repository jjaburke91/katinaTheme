jmApp.controller('projectListingController', ["$scope", "$rootScope", "wp", "projects", function( $scope, $rootScope, wp, projects) {
    $rootScope.page_title = "Jordan Muir";

    $scope.projects = projects;

    console.log(projects);

    setTimeout($rootScope.clearHeaderTrim(), 300);

    // Stops bug where masonry aligns the images before the content has actually been retrieved.
    // $scope.masonryLoaded = false;
    // var $container = $('.listing-grid');
    // window.setTimeout( function() {
    //     $container.imagesLoaded( function(){
    //         $container.masonry({
    //             itemSelector : '.grid-item',
    //             columnWidth: 200,
    //             isAnimated: true,
    //             isFitWidth: true,
    //             transitionDuration: '0.3s'
    //         });
    //     });
    //     $scope.masonryLoaded = true;
    //     $scope.$digest();
    // }, 500);

    window.setTimeout( function() {
        $rootScope.headerTrimWidth = '100%';
        $rootScope.$digest();
    }, 800);

}]);