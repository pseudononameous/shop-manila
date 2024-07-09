app.factory('Report', ['$http',
    function($http) {
        return {

            getSales: function(filter) {
                var promise = $http.get(siteUrl + 'report/get-sales-report/' + filter)

                return promise;

            },



        };
    }
]);