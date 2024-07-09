app.controller('AddShipmentCtrl', ['$scope', 'Swal', 'ShipmentResource' , 'Shipment',
    function($scope, Swal, ShipmentResource, Shipment) {


        $scope.data = {
            order_header_id: js.orderHeaderId
        };
        $scope.options = {};

        $scope.save = function() {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/shipments';
            }

            ShipmentResource.save($scope.data, function(returnValue) {

                $scope.data.id = returnValue.id;

                Swal.save(cb);


            }, function(errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };

        var retrieveShipmentForm = function(){

            return Shipment.getShipmentForm($scope.data.order_header_id).then(function(returnValue){

                $scope.data.orderDetails = returnValue.data;
            });

        };

        retrieveShipmentForm();


    }
]);