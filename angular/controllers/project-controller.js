jmApp.controller('projectController', ['$scope', 'project', function( $scope, project) {
    $scope.pageClass = "project";
    $scope.project = project;
    console.log(project);


    // TODO: Following iteration through images is UNORDERED. Perhaps consider giving key values to response object.
    // http://stackoverflow.com/questions/1129216/sort-array-of-objects-by-string-property-value-in-javascript
    // Opportunity for some fun functional programming here!

    $scope.images = project.attachments;
    $scope.imageSliderIndex = 0;

    $scope.nextImage = function() {
        if ($scope.imageSliderIndex == $scope.images.length-1 )
            $scope.imageSliderIndex = 0;
        else
            $scope.imageSliderIndex++;
    };
    $scope.previousImage = function() {
        if ($scope.imageSliderIndex == 0)
            $scope.imageSliderIndex = $scope.images.length-1;
        else
            $scope.imageSliderIndex--;
    };



}]);
