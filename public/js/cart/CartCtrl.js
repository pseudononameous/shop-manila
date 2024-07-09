app.controller('CartCtrl', ['$scope', '$http', 'Initialize', 'Cart', 'Coupon','Swal',
    function ($scope, $http, Initialize, Cart, Coupon, Swal) {

        $scope.data = {
            cartItems: [],
            subtotal: js.subtotal
        };

        var getCart = function () {
            return Cart.getCart().then(function (returnValue) {
                $scope.data.cart = returnValue.data;

            });
        };
        //getDiscount = function () {
        //    return Coupon.getDiscount().then(function (returnValue) {
        //        $scope.data.discount = returnValue.data;
        //    });
        //},
        //getAppliedCoupon = function () {
        //    return Coupon.getAppliedCoupon().then(function (returnValue) {
        //        $scope.data.appliedCoupon = returnValue.data;
        //    });
        //},
        //    getSubtotal = function () {
        //        return Cart.getSubtotal().then(function (returnValue) {
        //
        //            $scope.data.subtotal = returnValue.data;
        //        });
        //    },
        //    getGrandtotal = function () {
        //        return Cart.getGrandtotal().then(function (returnValue) {
        //            $scope.data.grandTotal = returnValue.data;
        //        });
        //    };

        //getCart().then(getSubtotal).then(getGrandtotal).then(getDiscount).then(getAppliedCoupon);

        getCart();

        $scope.computeSubtotal = function (price, qty) {

            var subtotal = parseFloat(price * qty);

            return subtotal;

        };

        $scope.checkout = function () {

            window.location.href = siteUrl + 'checkout';

            //Cart.checkout($scope.data.cartItems).then(function () {
            //    window.location.href = siteUrl + 'checkout';
            //});

        };

        $scope.remove = function (id) {

            swal({
                title: "",
                type: "warning",
                text: "Remove item from cart?",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
            }).then(function () {

                Cart.remove(id).then(function () {
                    $scope.disableCoupon();
                }).then(function () {
                    window.location.href = siteUrl + 'cart';
                });

            });


        };

        $scope.updateCart = function () {

            Cart.multipleUpdate($scope.data.cart).then(function () {
                window.location.href = siteUrl + 'cart';
            });


        };

        /*Coupon*/


        $scope.disableCoupon = function () {

            Coupon.disableCoupon().then(function(){
                window.location.href = siteUrl + 'cart';
            });
        };

        $scope.applyCoupon = function () {

            var data = {
                'coupon': $scope.data.coupon,
                'subtotal': $scope.data.subtotal
            }

            Coupon.useCoupon(data).then(function (returnValue) {

                if (returnValue.data.response == false) {
                    swal('Coupon you entered is invalid')
                } else {
                    window.location.reload();
                }
            });


        };


    }
]);
