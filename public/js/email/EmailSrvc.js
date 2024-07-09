app.factory('Email', function($http) {

    return {
        placeOrder: function(orderHeaderId){

            var promise = $http.post(siteUrl + 'email/place-order/' + orderHeaderId );
            return promise;

        },
        invoice: function(invoiceHeaderId){

            var promise = $http.post(siteUrl + 'email/invoice/' + invoiceHeaderId );
            return promise;

        },
        shipment: function(shipmentHeaderId){

            var promise = $http.post(siteUrl + 'email/shipment/' + shipmentHeaderId );
            return promise;

        },         
        contact: function(data){

            var promise = $http.post(siteUrl + 'email/contact', data );
            return promise;

        }

    };
});