jmApp.directive('contactForm', function() {
    return {
        restrict: 'E',
        scope: {}, // isolating scope
        templateUrl: template_directory+'/angular/directives/contact-form/contact-form.html',
        controller: "contactFormController"
    }
});


jmApp.controller('contactFormController', ["$scope", "wp", function($scope, wp) {

    $scope.contactFormData = {
        name: "name",
        email: "email@email.com",
        subject: "bla bla",
        message: "bla bla bla bla "
    };

    $scope.submitContactForm = function(valid) {
        if (valid) {
            wp.postContactForm($scope.contactFormData);
        }
    }

}]);