app.factory('UserResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + 'admin/users/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);

app.factory('User', ['$http',
    function($http) {
        return {

            attachRole: function(userId, role) {

                var data = {
                    userId: userId,
                    role: role
                };

                var promise = $http.post(siteUrl + 'user/attach-role', data);

                return promise;

            },
            removeAttachedRole: function(userId) {
                var promise = $http.get(siteUrl + 'action-user/remove-attached-role/' + userId);

                return promise;

            },
            /**
             * Change password
             * @param  {string} newPassword
             * @return {void}
             */
            changePassword: function(data){

                var promise = $http.post(siteUrl + 'admin/execute-change-password', data);

                return promise;
            },

        };
    }
]);


