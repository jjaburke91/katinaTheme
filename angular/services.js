jmApp.factory('wp', function($http) {
    return {
        getProjects: function() {
            return $http.get("wp-json/posts?type[]=jm_project");
        },
        getProjectWithId: function(post_id) {
            return $http.get("wp-json/posts/" + post_id);
        },
        getAboutPage: function() {
            return $http.get("wp-json/posts/4");
        }
    }
});
