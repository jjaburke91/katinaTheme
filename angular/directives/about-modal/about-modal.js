jmApp.directive('aboutModal', function() {

    function controller($scope, $rootScope, wp) {
        console.log("aboutModal loading");

        wp.getAboutPage().then(
            function success(response) {
                $scope.aboutModal.content = response.content;
            },
            function error(response){
                console.error("Error retrieving about page.");
            }
        );
    }

    return {
        restrict: 'E',
        scope: false,
        templateUrl: template_directory+'/angular/directives/about-modal/about-modal.html',
        controller: controller
    }
});
