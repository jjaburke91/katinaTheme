jmApp.directive('projectListingItem', function() {
    return {
        restrict: 'E',
        scope: {
            project: "=project"
        },
        templateUrl: template_directory+'/angular/directives/project-listing-item/project-listing-item.html',
        controller: "testController"
    }
});

jmApp.controller('testController', ["$scope",  function($scope) {
    console.log("testContr been hit.");
}]);