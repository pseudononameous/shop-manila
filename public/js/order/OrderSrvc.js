app.factory('OrderResource', ['$resource',
    function ($resource) {

        return $resource(siteUrl + 'admin/orders/:id', {
            id: '@id'
        }, {
            'query': {method: 'GET', isArray: false},
            'update': {method: 'PUT'}
        });

    }
]);

app.factory("Order", function ($http) {

    return {

        delete: function (orderHeaderId) {

            var data = {
                orderHeaderId: orderHeaderId
            };

            var promise = $http.post(siteUrl + 'admin/order/delete', data);
            return promise;
        },

        cancel: function (orderHeaderId) {

            var data = {
                orderHeaderId: orderHeaderId
            };

            var promise = $http.post(siteUrl + 'admin/order/cancel', data);
            return promise;
        },

        getOrder: function (orderHeaderId) {

            var promise = $http.get(siteUrl + 'order/get-order/' + orderHeaderId);
            return promise;

        },

        verify: function (orderDetailId) {

            var promise = $http.post(siteUrl + 'admin/order/verify-order-detail/' + orderDetailId);
            return promise;

        },

        paid: function (orderDetailId) {

            var promise = $http.post(siteUrl + 'admin/order/mark-as-paid-order-detail/' + orderDetailId);
            return promise;

        },

        accept: function (orderDetailId) {

            var promise = $http.post(siteUrl + 'admin/order/accept-order-detail/' + orderDetailId);
            return promise;

        },
        
        reject: function (orderDetailId, note) {

            var data = {
                orderDetailId: orderDetailId,
                note: note
            }

            var promise = $http.post(siteUrl + 'admin/order/reject-order-detail/' + orderDetailId, data);
            return promise;

        },
        ship: function (orderDetailId) {

            var promise = $http.post(siteUrl + 'admin/order/ship-order-detail/' + orderDetailId);
            return promise;

        },
        complete: function (orderDetailId) {

            var promise = $http.post(siteUrl + 'admin/order/mark-as-complete/' + orderDetailId);
            return promise;

        },
        refund : function(orderDetailId){

            var promise = $http.post(siteUrl + 'admin/order/refund-order-detail/' + orderDetailId);
            return promise;

        },

        exchange : function(orderDetailId){

            var promise = $http.post(siteUrl + 'admin/order/exchange-order-detail/' + orderDetailId);
            return promise;

        }


    };

});