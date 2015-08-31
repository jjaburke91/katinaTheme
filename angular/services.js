jmApp.factory('wp', function($http) {
    var projects_url = "wp-json/katinaAPI/projects/";
    var project_by_slug_url = "wp-json/katinaAPI/project/";
    var contact_form_post_url = "wp-json/katinaAPI/contact/";

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

        postContactForm: function(data) {
            console.log("Posting following contact data");
            console.log(data);
            return $http.post(contact_form_post_url, data).then(
                function success(response) {
                    console.log(response);
                },
                function error(response) {
                    console.error(response);
                }
            )
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