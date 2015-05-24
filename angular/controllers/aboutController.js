jmApp.controller('aboutController', function( $scope, $rootScope, wp) {

    wp.getAboutPage()
        .success( function(response) {
            $scope.aboutModal.content = response.content;
        })
        .error( function() {
            console.error("aboutController: Error retrieving about page.");
        });

});
