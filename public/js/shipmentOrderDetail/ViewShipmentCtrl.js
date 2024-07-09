app.controller('ViewShipmentCtrl', ['$scope', 'Swal', 'Email', 'Shipment',
    function($scope, Swal, Email, Shipment) {

        $scope.data = {
            shipmentHeaderId: js.id
        };

        $scope.sendEmail = function() {

            Swal.loading();
        
            var emailSend = function() {
                return Email.shipment($scope.data.shipmentHeaderId).then(function(){
                   swal("Success!", "Successfully emailed customer!", "success");
                });
            },
            markAsEmailSent = function(){
                return Shipment.markAsEmailSent($scope.data.shipmentHeaderId).then(function(){
                    swal("Success!", "Successfully emailed customer!", "success");
                });
            };

            emailSend().then(markAsEmailSent);
            
        };
    }
]);