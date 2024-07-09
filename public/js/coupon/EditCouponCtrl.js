app.controller('EditCouponCtrl', ['$scope', 'Swal', 'CouponResource', 'Coupon', 'Initialize', 'Store',
    function ($scope, Swal, CouponResource, Coupon, Initialize, Store) {

        $scope.data = {
            id: js.id
        };
        $scope.options = {};

        $scope.save = function () {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/coupons';
            }

            CouponResource.update($scope.data, function (returnValue) {

                $scope.data.id = returnValue.id;

                Swal.update(cb);

            }, function (errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };


        var getCouponTypes = function () {

                Swal.loading();

                return Coupon.getCouponTypes().then(function (returnValue) {
                    $scope.options.couponTypes = returnValue.data;

                })
            },

            getStores = function () {
                return Store.getStores().then(function (returnValue) {
                    $scope.options.stores = returnValue.data;
                });
            },


            getRecord = function () {

                return Initialize.getRecord('coupon', $scope.data.id).then(function (returnValue) {

                    var res = returnValue.data;

                    $scope.data = res;

                });

            },
            preLoadOptions = function () {

                angular.forEach($scope.options.couponTypes, function (i) {

                    if ($scope.data.option_coupon_type_id == i.id) {
                        $scope.data.couponType = i;

                    }
                });

                /*Pre load stores*/
                angular.forEach($scope.options.stores, function (i) {

                    if ($scope.data.store_id == i.id) {
                        $scope.data.store = i;
                    }
                });


                swal.close();

            }

        getCouponTypes().then(getRecord).then(getStores).then(preLoadOptions);

    }
]);