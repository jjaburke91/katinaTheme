jmApp.controller('aboutController', function( $scope, $rootScope, wp) {
    wp.getAboutPage().then(
        function success(response) {
            $scope.aboutModal.content = response.content;
        },
        function error(response){
            console.error("Error retrieving about page.");
        }
    );

});
