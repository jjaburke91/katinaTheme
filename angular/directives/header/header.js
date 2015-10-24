jmApp.directive('jmHeader', function() {

    function controller($scope, $rootScope) {
        $scope.template_dir = $rootScope.template_directory;

    }

    return {
        restrict: 'E',
        scope: true,
        templateUrl: template_directory+'/angular/directives/header/header.html',
        controller: controller
    }
});
