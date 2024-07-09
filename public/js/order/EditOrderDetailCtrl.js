app.controller('EditOrderDetailCtrl', ['$scope', 'Swal', 'OrderResource', 'Initialize', 'Order',
    function ($scope, Swal, OrderResource, Initialize, Order) {

        $scope.data = {
            id: js.id
        };

        $scope.options = {};

        $scope.invoice = function (orderDetailId) {

            window.location.href = siteUrl + 'admin/invoice-order-details/create?orderDetailId=' + orderDetailId;

        };

        $scope.verify = function (orderDetailId) {
            Order.verify(orderDetailId).then(function(returnValue){
                
                if(returnValue.data.status == 'success'){

                    function cb(){
                        window.location.reload();
                    }

                    Swal.update(cb);
                }
            });
        };
        
        $scope.paid = function (orderDetailId) {
            Order.paid(orderDetailId).then(function(returnValue){
                
                if(returnValue.data.status == 'success'){

                    function cb(){
                        window.location.reload();
                    }

                    Swal.update(cb);
                }
            });
        };

        $scope.refund = function (orderDetailId) {
            Order.refund(orderDetailId).then(function(returnValue){

                if(returnValue.data.status == 'success'){

                    function cb(){
                        window.location.reload();
                    }

                    Swal.update(cb);
                }
            });
        };

        $scope.exchange = function (orderDetailId) {
            Order.exchange(orderDetailId).then(function(returnValue){

                if(returnValue.data.status == 'success'){

                    function cb(){
                        window.location.reload();
                    }

                    Swal.update(cb);
                }
            });
        };

        $scope.forPickup = function (orderDetailId) {

            window.location.href = siteUrl + 'admin/shipment-order-details/create?orderDetailId=' + orderDetailId;
        };

        $scope.save = function () {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/orders';
            }

            OrderResource.update($scope.data, function (returnValue) {

                $scope.data.id = returnValue.id;

                Swal.update(cb);

            }, function (errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };

        // $scope.delete = function (id) {
        //
        //     function cb() {
        //
        //         Order.delete({orderHeaderId: id});
        //
        //     }
        //
        //     Swal.delete(cb);
        //
        // };

        var getRecord = function () {

            return Initialize.getRecord('order', $scope.data.id).then(function (returnValue) {

                var res = returnValue.data;

                $scope.data = res;

            });

        };

        // getRecord();

    }
]);