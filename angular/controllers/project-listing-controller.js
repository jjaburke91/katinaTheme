jmApp.controller('projectListingController', ["$scope", "$rootScope", "wp", "projects", function( $scope, $rootScope, wp, projects) {
    var pageTitle = "Jordan Muir";
    $rootScope.page_title = pageTitle;

    $scope.projects = projects;

    gtag('config', $rootScope.gaTrackingId, {
        'page_title': pageTitle,
        'page_path': window.location.href.replace("/#", ''),
        'page_location': window.location.href
    });

    setTimeout($rootScope.clearHeaderTrim(), 300);

    window.setTimeout( function() {
        $rootScope.headerTrimWidth = '100%';
        $rootScope.$digest();
    }, 800);
}]);