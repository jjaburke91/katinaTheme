jmApp.factory('wp', function($http) {
    return {
        getProjects: function() {
            return $http.get("wp-json/wp/v2/posts");
        },
        getProjectWithId: function(post_id) {
            return $http.get("wp-json/wp/v2/posts/" + post_id);
        },
        getAboutPage: function() {
            return $http.get("wp-json/wp/v2/pages/4");
        }
    }
});
