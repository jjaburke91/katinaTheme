jmApp.controller('projectListingController', ["$scope", "$rootScope", "wp", "projects", function( $scope, $rootScope, wp, projects) {
    $scope.pageClass = "project-listing";
    $scope.projects = projects;
    console.log(projects);



    // TODO: Healthy containing this content in a controller?
    var $container = $('.listing-grid');

    $container.imagesLoaded( function(){
        $container.masonry({
            itemSelector : '.grid-item',
            columnWidth: 200,
            isAnimated: true,
            isFitWidth: true
        });
    });

}]);