jmApp.factory('wp', function($http) {
    return {
        getPosts: function() {
            return $http.get("wp-json/posts");
        },
        getPost: function(post_id) {
            return $http.get("wp-json/posts/" + post_id);
        },
        getAboutPage: function() {
            return $http.get("wp-json/posts/8");
        },
        getRecipes: function() {
            return $http.get("wp-json/posts?type=recipe")
        },
        getRecipeStyles: function() {
            return $http.get("wp-json/taxonomies/recipe_style/terms")
        }
    }
});
