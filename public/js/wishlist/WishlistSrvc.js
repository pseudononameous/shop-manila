//app.factory('Item', ['$http',
//    function($http) {
//        return {
//
//
//        };
//    }
//]);



app.factory('WishlistResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + '/account/wishlist/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);