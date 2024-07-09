app.controller('OrderedItemsListCtrl', ['$scope', 'Swal', 'Order','Payment',
    function ($scope, Swal, Order, Payment) {

        $scope.data = {};
        $scope.options = {};

        $scope.accept = function (id) {

            function cb() {

                Order.accept(id);

            }

            Swal.accept(cb);
        };

        $scope.reject = function (id) {

            function cb() {

                var form = '<div>';
                form += '<input type="text" class="form-control" id="note">';
                form += '</div>';

                swal({
                    title: 'Reason for rejection',
                    html: form
                }).then(function () {
                    var note = $('#note').val()

                    Swal.loading();

                    Order.reject(id, note).then(function () {
                        swal({
                            title: "Rejected",
                            closeOnConfirm: true,
                            text: "Order sucessfully rejected!",
                            type: "success",
                        }).then(function () {
                            location.reload();
                        });
                    });
                });


            }

            Swal.reject(cb);
        };

        $scope.ship = function (id) {

            function cb() {

                return Order.ship(id).then(function (returnValue) {

                    Order.complete(id).then(function(){
                        window.location.reload();
                    });

                });

            }

            Swal.ship(cb);
        };

        var getPaymentOptions = function () {

            Payment.getPaymentOptions().success(function (returnValue) {
                $scope.options.paymentOptions = returnValue;
            });

        };

        getPaymentOptions();

    }
]);