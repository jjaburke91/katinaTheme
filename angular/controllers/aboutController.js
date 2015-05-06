jmApp.controller('aboutController', function( $scope, wp) {

    wp.getAboutPage()
        .success( function(response) {
            $scope.page = response;
            console.log( $scope.page);
        })
        .error( function() {
            console.error("aboutController: Error retrieving about page.");
        });

});