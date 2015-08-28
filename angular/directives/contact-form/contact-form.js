jmApp.directive('contactForm', function() {
    return {
        restrict: 'E',
        scope: {}, // isolating scope
        templateUrl: template_directory+'/angular/directives/contact-form/contact-form.html'
    }
});