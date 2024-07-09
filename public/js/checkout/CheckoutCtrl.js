app.controller('CheckoutCtrl', ['$scope', '$http', '$q', 'Checkout', 'Swal', 'Payment', 'City', 'Order', 'GoogleAnalytics', 'Coupon',
    function ($scope, $http, $q, Checkout, Swal, Payment, City, Order, GoogleAnalytics, Coupon) {

        $scope.data = {
            option_shipping_id: 1,
            option_payment_id: 1,
            orderHeaderId: js.orderHeaderId,
            grandTotal: js.grandTotal,
            shippingFee: js.shippingFee,
            minimumSubtotal : 800,
            
        };

        $scope.data.recipient = {};

        $scope.config = {
            
            subtotal: js.subtotal
        };

        $scope.options = {};

        $scope.grandTotal = $scope.data.grandTotal;


        $scope.computeShippingFee = function() {
         
            if($scope.config.subtotal < $scope.data.minimumSubtotal){
                $scope.data.shippingFee = parseFloat($scope.data.minimumSubtotal) - parseFloat($scope.config.subtotal);

                $scope.data.grandTotal = parseFloat($scope.data.shippingFee) + parseFloat($scope.config.subtotal);
            }
             
         };
          
        



        var getCities = function () {

                return City.getCities().then(function (returnValue) {
                    $scope.options.cities = returnValue.data;

                });
            },

            getCustomer = function () {
                return Checkout.getCustomer().then(function (returnValue) {

                    var res = returnValue.data;

                    $scope.data.recipient = res;


                });


            },
            preLoadOptions = function () {
                /*Pre load cities*/
                angular.forEach($scope.options.cities, function (i) {

                    if ($scope.data.recipient.city_id == i.id) {
                        $scope.data.recipient.city = i;
                    }
                });
                $scope.changeSelectedCity();
            };


        getCities().then(getCustomer).then(preLoadOptions);

        /*Payment config*/

        var paymentOptions = []; // index is optionPaymentId value
        paymentOptions[1] = 'bankDeposit';
        paymentOptions[2] = 'cashOnDelivery';
        paymentOptions[3] = 'paypal';
        paymentOptions[4] = 'paymentCenters';
        paymentOptions[5] = 'dragonpay';

        $scope.placeOrder = function () {

            
            var verifyOrder = function () {

                    Swal.loading();

                    return Checkout.verifyPlaceOrder($scope.data.orderHeaderId).then(function (returnValue) {
                        var res = returnValue.data;

                        if (res.length > 0) {
                            swal({
                                title: "Item is out of stock",
                                type: "warning",
                                text: res,
                                confirmButtonText: "Ok",
                                closeOnConfirm: false,
                            }, function () {

                                Coupon.disableCoupon().then(function(){
                                    window.location.href = siteUrl + 'cart';
                                })

                            });

                            return $q.reject();

                        }


                    });
                },
                placeOrder = function () {

                    return Checkout.placeOrder($scope.data).then(function (returnValue) {

                        $scope.data.orderHeaderId = returnValue.data.id;

                    });

                },


                createGaOrder = function () {

                    return Order.getOrder($scope.data.orderHeaderId).then(function (returnValue) {

                        var res = returnValue.data;


                        GoogleAnalytics.sendEcommerce($scope.data.orderHeaderId, res);


                    })


                },
                doPayment = function () {

                    /*Do payment*/
                    var method = paymentOptions[$scope.data.option_payment_id];

                    Payment.doPayment(method, $scope.data.orderHeaderId);
                }


            verifyOrder().then(placeOrder).then(createGaOrder).then(doPayment);


        };


        /*Re-assign payment method if no city selected*/
        $scope.$watch('data.recipient.city', function (newVal) {
            var cities = [];
            angular.forEach(newVal, function (values) {
                cities.push(values);
            });
            $scope.config.disableCod = false;
            if (newVal == undefined || cities[2] == 0) {
                $scope.data.option_payment_id = 1;
                $scope.config.disableCod = true;
            }
        });


        /*Disable radio button if no city selected*/
        $scope.allowCod = function (radioButtonIndex) {

            if ((radioButtonIndex == 1) && $scope.config.disableCod) {
                return true;
            }

            return false;

        };


        /*Disable LBC if COD is selected*/
        $scope.$watch('data.option_payment_id', function (newVal) {
            $scope.config.disableLbc = false;

            if (newVal == 2) {
                $scope.config.disableLbc = true;
            }
            return false;
        });

        /*Disable radio button for LBC if COD is selected*/
        $scope.checkShippingState = function (radioButtonIndex) {

            var disable = false;

            if ((radioButtonIndex == 1) && $scope.config.disableLbc) {
                disable = true;
            }

            //Disable LBC if grand total is less than 1000
            if ((radioButtonIndex == 1) && $scope.data.grandTotal < 1000) {
                disable = true;
            }

            return disable;
        };
        /*End*/


        /**
         * Change minimum subtotal and recompute shipping fee based on city
         * @return {void} 
         */
        $scope.changeSelectedCity = function(){


            var ct500 = ["Caloocan","Las Piñas","Makati","Malabon","Mandaluyong","Manila","Marikina","Muntinlupa","Navotas","Parañaque",
                "Pasay","Pasig","Pateros","Quezon City","San Juan", "Taguig", "Valenzuela"];


            var match = 0;

            angular.forEach(ct500, function(i) {


                if(($scope.data.recipient.city) && (match === 0)){

                    if(i == $scope.data.recipient.city.name){

                        $scope.data.minimumSubtotal = 500;
                        match++;
  
                        
                    }else{
                        $scope.data.minimumSubtotal = 800;
                    }


                    $scope.computeShippingFee();
                    
                }

            });
            

        };

        // $scope.changeSelectedCity = function(){
        //     var ct500 = ["Caloocan","Las Piñas","Makati","Malabon","Mandaluyong","Manila","Marikina","Muntinlupa","Navotas","Parañaque",
        //         "Pasay","Pasig","Pateros","Quezon City","San Juan", "Taguig", "Valenzuela"];
        //     var selectedCity = $scope.data.recipient.city;
        //     if($scope.data.grandTotal <=800) {
        //         for (var i = 0; i < ct500.length; i++) {
        //             if (selectedCity['name'] == ct500[i]) {
        //                 $scope.grandTotal = 500;
        //                 $scope.data.minimum = 500;
        //                 break;
        //             } else {
        //                 $scope.grandTotal = 800;
        //                 $scope.data.minimum = 800;
        //             }
        //         }
        //     }
        // }
    }

]);

