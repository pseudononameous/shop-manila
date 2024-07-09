app.controller('AddInvoiceCtrl', ['$scope', 'Swal', 'InvoiceResource' , 'Invoice',
    function($scope, Swal, InvoiceResource, Invoice) {


        $scope.data = {
            order_header_id: js.orderHeaderId
        };
        $scope.options = {};

        $scope.save = function() {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/invoices';
            }

            InvoiceResource.save($scope.data, function(returnValue) {

                $scope.data.id = returnValue.id;

                Swal.save(cb);


            }, function(errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };

        $scope.computeAmountToInvoice = function (qty, price) {

            return qty * price;

        };

        var retrieveInvoiceForm = function(){

            return Invoice.getInvoiceForm($scope.data.order_header_id).then(function(returnValue){

                $scope.data.orderDetails = returnValue.data;
            });

        };

        retrieveInvoiceForm();


    }
]);