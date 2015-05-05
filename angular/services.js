jmApp.factory('wp', function($http) {
    return {
        getPosts: function() {
            return $http.get("wp-json/posts");
        },
        getPost: function(post_id) {
            return $http.get("wp-json/posts/" + post_id);
        }
    }
});
