app.factory("Customer", function($http) {

    return {

        login: function() {

            var promise = $http.post(siteUrl + 'customer/login');
            return promise;
        },
        getOrders: function(customerId) {

            var promise = $http.get(siteUrl + 'customer/getOrders/' + customerId);
            return promise;
        }

    };

});

app.factory('CustomerResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + '/admin/customer/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);


app.factory('CustomerAccountResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + '/account/customer/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);