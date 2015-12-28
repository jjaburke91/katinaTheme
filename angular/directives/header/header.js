jmApp.directive('jmHeader', function() {

    function controller($scope, $rootScope, $state) {
        $scope.template_dir = $rootScope.template_directory;

        $scope.isHomePage = $state.current;
        console.log($state.current);

        function detectScrollDirection() {
            var lastScrollTop = $(this).scrollTop(),
                headerHeight = $('header').outerHeight(),
                headerIsHidden = false;

            return function() {
                var currentScrollTop = $(this).scrollTop();

                if (currentScrollTop > headerHeight || headerIsHidden) {
                    if (lastScrollTop < currentScrollTop && !headerIsHidden) {
                        $('header').addClass('hide-header');
                        headerIsHidden = true;
                    } else if (lastScrollTop > currentScrollTop && headerIsHidden) {
                        $('header').removeClass('hide-header');
                        headerIsHidden = false;
                    }
                }

                lastScrollTop = currentScrollTop;
            }
        }

        //$(window).scroll(_.throttle( detectScrollDirection(), 500) );
    }

    return {
        restrict: 'E',
        scope: true,
        templateUrl: template_directory+'/angular/directives/header/header.html',
        controller: controller
    }
});
