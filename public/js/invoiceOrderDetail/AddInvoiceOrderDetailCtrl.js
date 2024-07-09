app.controller('AddInvoiceOrderDetailCtrl', ['$scope', 'Swal', 'InvoiceOrderDetailResource', 'InvoiceOrderDetail',
    function ($scope, Swal, InvoiceOrderDetailResource, InvoiceOrderDetail) {


        $scope.data = {
            orderDetailId: js.orderDetailId,
            coupon : js.couponPrice
        };

        $scope.options = {};

        $scope.save = function () {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/invoices';
            }

            InvoiceOrderDetailResource.save($scope.data, function (returnValue) {

                $scope.data.id = returnValue.id;

                var sendEmailMerchant = function () {
                        return InvoiceOrderDetail.emailMerchant($scope.data.id);
                    },
                    success = function () {
                        Swal.save(cb);
                    };

                sendEmailMerchant().then(success);


            }, function (errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };

        $scope.computeAmountToInvoice = function (qty, price) {

            return qty * price;

        };

        var retrieveInvoiceForm = function () {

            return InvoiceOrderDetail.getInvoiceForm($scope.data.orderDetailId).then(function (returnValue) {

                $scope.data.orderDetails = returnValue.data;
            });

        };

        retrieveInvoiceForm();


    }
]);