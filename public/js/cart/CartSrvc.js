/**
 * Cart
 * Shopping cart functions
 *
 */
app.factory('Cart', function($http) {

    return {
        getCart: function() {
            var promise = $http.get(siteUrl + 'cart/get-cart');
            return promise;
        },        

        add: function(itemId, data) {
            var promise = $http.post(siteUrl + 'cart/add/' + itemId, data);
            return promise;

        },        

        multipleUpdate: function(data) {

            var promise = $http.post(siteUrl + 'cart/multiple-update', data);
            return promise;

        },

        remove: function(id){

            var promise = $http.post(siteUrl + 'cart/remove/' + id);

            return promise;
        },
        getSubtotal: function() {

            var promise = $http.get(siteUrl + 'cart/getSubtotal');
            return promise;
        },
        getGrandtotal: function() {

            var promise = $http.get(siteUrl + 'cart/getGrandtotal');
            return promise;
        },

        checkout: function(data){

            // $http.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
            // var promise = $http.post(siteUrl + 'cart/checkout', data).error(function(data, status, headers, config){
            //     if(status == 403){
            //         window.location.href = siteUrl + 'login?authenticate=true';
            //     }
            // });
            // return promise;
            
            var promise = $http.post(siteUrl + 'cart/checkout', data);
            return promise;

        }

    };
});