app.factory("Payment", function($http, Email) {

    return {

        doPayment: function(method, orderHeaderId){


            switch (method) {

                case 'bankDeposit':

                    Email.placeOrder(orderHeaderId).then(function () {
                        window.location.href = siteUrl + 'success';
                    });

                    

                    break;

                case 'cashOnDelivery':


                    Email.placeOrder(orderHeaderId).then(function () {
                        window.location.href = siteUrl + 'success-cod';
                    });

                    

                    break;

                case 'paypal':

                    var redirect = function(url, method) {
                        $('<form>', {
                            method: method,
                            action: url
                        }).submit();
                    };
                    
                    redirect(siteUrl + 'payment/' + orderHeaderId, 'post');

                    //window.location.href = siteUrl + 'payment/' + orderHeaderId;
                    //this.paypalCheckout(orderHeaderTempId);
                    break;

                    
                case 'paymentCenters':

                    Email.placeOrder(orderHeaderId).then(function () {
                        window.location.href = siteUrl + 'success-payment-centers';
                    });
                    

                    break;

                case 'dragonpay':

                    //window.location.href = siteUrl + 'dragonpay/payment/' + orderHeaderId;
                    //break;

                    var redirect = function(redirectUrl) {
                        var form = $('<form action="' + redirectUrl + '" method="post">' +
                            '<input type="hidden" name="orderId" value="'+ orderHeaderId +'" />' +
                            '</form>');
                        $('body').append(form);
                        $(form).submit();
                    };
                    redirect(siteUrl + 'dragonpay/payment');
                    break;


                default:
                    break;
            }


        },

    	
        paypalCheckout: function(orderHeaderTempId){

            var el = $('<input>')
                    .attr("type", "hidden")
                    .attr("name", "orderHeaderId")
                    .val(orderHeaderTempId);

            $('#form').append($(el));

            $("#form").submit();

            return;
            
        },

        redirectSuccess: function(){
            window.location.href = siteUrl + 'success';
        },

        getPaymentOptions: function(){
            var promise = $http.get(siteUrl + 'payment-option/get-payment-options');
            return promise;
        }



    };

});