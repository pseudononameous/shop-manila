app.factory('ShipmentResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + 'admin/shipments/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);

app.factory("Shipment", function($http) {

    return {

        getShipmentForm: function(orderHeaderId){

            var promise = $http.get(siteUrl + 'admin/shipment/getShipmentForm/' + orderHeaderId);
            return promise;
        },

        markAsEmailSent: function(shipmentHeaderId){

            var data = {
                shipmentHeaderId: shipmentHeaderId
            };

            var promise = $http.post(siteUrl + 'admin/shipment/mark-as-email-sent', data);
            return promise;
        }

    };

});