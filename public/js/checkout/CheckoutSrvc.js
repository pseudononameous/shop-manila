app.factory('Checkout', function($http) {

    return {
        getOrderTemp: function(){

            var promise = $http.get(siteUrl + 'checkout/getOrderTemp');
            return promise;

        },            

        getCustomer: function(){

            var promise = $http.get(siteUrl + 'customer/get-record/' + 0 );
            return promise;

        },     

        getPaymentOptions: function(){

            var promise = $http.get(siteUrl + 'checkout/getPaymentOptions');
            return promise;

        },        
        getShippingOptions: function(subtotal){

            var promise = $http.get(siteUrl + 'checkout/getShippingOptions/' + subtotal);
            return promise;

        },        
        getShippingRate: function(id){

            var promise = $http.get(siteUrl + 'checkout/getShippingRate/' + id);
            return promise;

        },

        computeSubtotal: function(orderDetails){

            var subtotal = 0;

            angular.forEach(orderDetails, function(i) {
                subtotal += (parseFloat(i.price) * parseFloat(i.qty));
            });

            return subtotal;
        },

        placeOrder: function(data){

            var promise = $http.post(siteUrl + 'checkout/place-order', data);
            return promise;
        },

        getOrder: function(data){
            var promise = $http.post(siteUrl + 'checkout/post-order', data);
            return promise;
        },

        postOrder: function(data){
            var promise = $http.get(siteUrl + 'checkout/post-order', data);
            return promise;
        },

        verifyPlaceOrder: function(data){
            var promise = $http.post(siteUrl + 'checkout/verify-order', data);
            return promise;
        }




    };
});