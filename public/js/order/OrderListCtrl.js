app.controller('OrderListCtrl', ['$scope', 'Payment', 'Swal', 'Order',
    function($scope, Payment, Swal, Order) {

        $scope.options = {};

        $scope.delete = function (id) {

            function cb() {

                Order.delete(id);

            }

            Swal.del(cb);
        };

        $scope.cancel = function (id) {

            function cb() {

                Order.cancel(id);

            }

            Swal.cancel(cb);
        };

        var getPaymentOptions = function () {

            Payment.getPaymentOptions().success(function (returnValue) {
                $scope.options.paymentOptions = returnValue;
            });

        };

        //$scope.verify = function (orderDetailId) {
        //
        //    Order.verify(orderDetailId).then(function(returnValue){
        //
        //        if(returnValue.data.status == 'success'){
        //
        //            function cb(){
        //                window.location.reload();
        //            }
        //
        //            Swal.update(cb);
        //        }
        //    });
        //};
        //
        //getPaymentOptions();

    }
]);