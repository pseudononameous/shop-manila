app.factory('Tag', ['$http',
    function($http) {
        return {

            saveItemTags: function(tags) {
                var promise = $http.post(siteUrl + 'admin/tags/save-item-tags', tags);

                return promise;

            },

        };
    }
]);