app.factory('Newsletter', ['$http',
    function($http) {
        return {

            sign: function(data) {
                var promise = $http.post(siteUrl + 'subscribe', data);

                return promise;

            }


        };
    }
]);
