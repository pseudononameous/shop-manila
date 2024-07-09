app.controller('AddShipmentOrderDetailCtrl', ['$scope', 'Swal', 'ShipmentOrderDetail' , 'ShipmentOrderDetailResource',
    function($scope, Swal, ShipmentOrderDetail, ShipmentOrderDetailResource) {


        $scope.data = {
            orderDetailId: js.orderDetailId
        };
        $scope.options = {};

        $scope.save = function() {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/shipments';
            }

            ShipmentOrderDetailResource.save($scope.data, function(returnValue) {

                $scope.data.id = returnValue.id;

                var sendEmailMerchant = function () {
                        return ShipmentOrderDetail.emailMerchant($scope.data.id);
                    },
                    success = function () {
                        Swal.save(cb);
                    };

                sendEmailMerchant().then(success);


            }, function(errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };

        var retrieveShipmentForm = function(){

            return ShipmentOrderDetail.getShipmentForm($scope.data.orderDetailId).then(function(returnValue){

                $scope.data.orderDetails = returnValue.data;
            });

        };

        retrieveShipmentForm();


    }
]);