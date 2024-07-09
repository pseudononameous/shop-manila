app.factory('InvoiceOrderDetailResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + 'admin/invoice-order-details/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);

app.factory("InvoiceOrderDetail", function($http) {

    return {

        getInvoiceForm: function(orderDetailId){

            var promise = $http.get(siteUrl + 'admin/invoice-order-detail/get-invoice-form/' + orderDetailId);
            return promise;
        },

        markAsEmailSent: function(invoiceHeaderId){

            var data = {
                invoiceHeaderId: invoiceHeaderId
            };

            var promise = $http.post(siteUrl + 'admin/invoice/mark-as-email-sent', data);
            return promise;

        },

        emailMerchant : function (invoiceHeaderId){
            var data = {
                invoiceHeaderId: invoiceHeaderId
            };

            var promise = $http.post(siteUrl + 'admin/email/invoice/email-merchant', data);
            return promise;
        }



    };

});