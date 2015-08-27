jmApp.factory('wp', function($http) {
    var projects_url = "wp-json/katinaAPI/projects/";
    var project_by_slug_url = "wp-json/katinaAPI/project/";

    return {
        getProjects: function() {
            return $http.get(projects_url).then(
                function success(response) {
                    return response.data;
                },
                function error() {
                    console.error("wp: Error retrieving projects.");
                }
            );
        },

        getProjectWithSlug: function(project_slug) {
            return $http.get(project_by_slug_url + project_slug).then(
                function success(response) {
                    return response.data;
                },
                function error() {
                    console.error("wp: Error retrieving project with name " + project_slug + ".");
                }
            );
        },

        // TODO: Hate how this is done - fix this.
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