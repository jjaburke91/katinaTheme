jmApp.factory('wp', function($http) {
    return {
        getProjects: function() {
            console.log("wp: Getting projects.");
            return $http.get("wp-json/posts?type[]=jm_project&json_unescaped_unicode=1");
        },
        getProjectWithId: function(post_id) {
            console.log("wp: Getting project with id " + post_id + ".");
            return $http.get("wp-json/posts/" + post_id);
        },
        getAboutPage: function() {
            console.log("wp: Getting About page.");
            return $http.get("wp-json/posts/4");
        }
    }
});