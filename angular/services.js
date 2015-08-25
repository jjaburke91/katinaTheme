jmApp.factory('wp', function($http) {
    return {
        getProjects: function() {
            return $http.get("wp-json/posts?type[]=jm_project&json_unescaped_unicode=1").then(
                function success(response) {
                    return response.data;
                },
                function error() {
                    console.error("wp: Error retrieving projects.");
                }
            );
        },
        getProjectWithId: function(post_id) {
            return $http.get("wp-json/posts/" + post_id).then(
                function success(response) {
                    return response.data;
                },
                function error() {
                    console.error("wp: Error retrieving project with ID " + post_id + ".");
                }
            );
        },
        getProjectWithName: function(post_name) {
            return $http.get("wp-json/posts?type[]=jm_project&filter[s]=\"" + post_name + "\"").then(
                function success(response) {
                    return response.data;
                },
                function error() {
                    console.error("wp: Error retrieving project with name " + post_name + ".");
                }
            );
        },
        getAboutPage: function() {
            return $http.get("wp-json/posts/4").then(
                function success(response) {
                    return response.data;
                },
                function error() {
                    console.error("wp: Error retrieving About Page content.");
                }

            );
        }
    }
});