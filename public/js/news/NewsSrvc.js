app.factory('NewsResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + 'admin/news/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);