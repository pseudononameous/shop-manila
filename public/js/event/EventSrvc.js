app.factory('Event', ['$http',
    function($http) {
        return {

            getEvents: function() {
                var promise = $http.get(siteUrl + 'event/get-events');

                return promise;

            }

        };
    }
]);

app.factory('EventResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + 'admin/events/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);