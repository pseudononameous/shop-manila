app.factory('Item', ['$http',
    function($http) {
        return {

            getStoresForUser: function() {
                var promise = $http.get(siteUrl + 'admin/items/getStoresForUser');

                return promise;

            },

            displayProducts: function(storeUrl, currentPage) {

                var promise = $http.get(siteUrl + 'items/displayProducts/' + storeUrl + '/' + currentPage);
                return promise;
            },

            displayProductsByCategory: function(category, offset, limit) {

                var promise = $http.get(siteUrl + 'items/displayProductsByCategory/' + category + '/' + offset + '/' + limit);
                return promise;
            },

            getItemSizes: function(itemId) {

                var promise = $http.get(siteUrl + 'item/get-item-sizes/' + itemId);
                return promise;
            },
            getAssignedItemSize: function(itemId) {

                var promise = $http.get(siteUrl + 'item/get-assigned-item-size/' + itemId);
                return promise;
            }


        };
    }
]);

app.factory('ItemEvent', function ($http) {

    return {

        saveItemEvents: function (itemId, data) {

            var promise = $http.post(siteUrl + 'item-event/save-item-events/' + itemId, data);
            return promise;
        },
    };
});

app.factory('ItemResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + 'admin/merchant-items/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);