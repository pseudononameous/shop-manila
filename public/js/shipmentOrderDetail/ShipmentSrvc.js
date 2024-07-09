app.factory('ShipmentOrderDetailResource', ['$resource',
    function ($resource) {

        return $resource(siteUrl + 'admin/shipment-order-details/:id', {
            id: '@id'
        }, {
            'query': {method: 'GET', isArray: false},
            'update': {method: 'PUT'}
        });

    }
]);

app.factory("ShipmentOrderDetail", function ($http) {

    return {

        getShipmentForm: function (orderDetailId) {

            var promise = $http.get(siteUrl + 'admin/shipment-order-detail/get-shipment-form/' + orderDetailId);
            return promise;
        },

        markAsEmailSent: function (shipmentHeaderId) {

            var data = {
                shipmentHeaderId: shipmentHeaderId
            };

            var promise = $http.post(siteUrl + 'admin/shipment/mark-as-email-sent', data);
            return promise;

        },
        emailMerchant: function (shipmentHeaderId) {

            var data = {
                shipmentHeaderId: shipmentHeaderId
            };

            var promise = $http.post(siteUrl + 'admin/email/shipment/email-merchant', data);
            return promise;
        }

    };

});