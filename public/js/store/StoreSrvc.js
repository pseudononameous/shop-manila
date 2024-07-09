app.factory('StoreResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + 'admin/stores/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);

app.factory('Store', function($http) {

    return {

        getStores: function() {

            var promise = $http.get(siteUrl + 'store/get-stores');

            return promise;

        }
    };
});

app.factory('StoreVideo', function($http) {

    return {

        saveStoreVideos: function(storeId, data) {

            var promise = $http.post(siteUrl + 'store-video/save-store-videos/' + storeId, data);
            return promise;

        }
    };
});