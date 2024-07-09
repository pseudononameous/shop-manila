app.factory('InvoiceResource', ['$resource',
    function($resource) {

        return $resource(siteUrl + 'admin/invoices/:id', {
            id : '@id'
        },{
            'query': {method: 'GET', isArray: false },
            'update': {method: 'PUT' }
        });

    }
]);

app.factory("Invoice", function($http) {

    return {

        getInvoiceForm: function(orderHeaderId){

            var promise = $http.get(siteUrl + 'admin/invoice/getInvoiceForm/' + orderHeaderId);
            return promise;
        },

        markAsEmailSent: function(invoiceHeaderId){

            var data = {
                invoiceHeaderId: invoiceHeaderId
            };

            var promise = $http.post(siteUrl + 'admin/invoice/mark-as-email-sent', data);
            return promise;
            
        }
        //void: function(route, invoiceHeaderId){
        //
        //    var promise = $http.post(siteUrl + route + '/void/' + invoiceHeaderId);
        //    return promise;
        //}

    };

});