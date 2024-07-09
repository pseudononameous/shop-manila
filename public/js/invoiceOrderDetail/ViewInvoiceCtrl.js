app.controller('ViewInvoiceCtrl', ['$scope', 'Swal', 'Email', 'Invoice',
    function($scope, Swal, Email, Invoice) {

        $scope.data = {
            invoiceHeaderId: js.id
        };

        $scope.sendEmail = function() {

            Swal.loading();
        
            var emailSend = function() {

                return Email.invoice($scope.data.invoiceHeaderId).then(function(){
                       
                });
                

            },
            markAsEmailSent = function(){
                return Invoice.markAsEmailSent($scope.data.invoiceHeaderId).then(function(){
                    swal("Success!", "Successfully emailed customer!", "success");
                });
            };


            emailSend().then(markAsEmailSent);

        };
    }
]);