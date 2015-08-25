jmApp.controller('aboutController', function( $scope, $rootScope, wp) {
    $scope.aboutModal.content = wp.getAboutPage();

});
