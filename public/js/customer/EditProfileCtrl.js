app.controller('EditProfileCtrl', ['$scope', 'Swal', 'Initialize', 'Customer', 'CustomerAccountResource', 'City',
    function ($scope, Swal, Initialize, Customer, CustomerAccountResource, City) {

        $scope.data = {
            id: js.id
        };
        $scope.options = {};

        $scope.save = function () {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'account/profile';
            }

            CustomerAccountResource.update($scope.data, function (returnValue) {

                $scope.data.id = returnValue.id;


                Swal.update(cb);

            }, function (errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };


        var getCities = function () {

                Swal.loading();


                return City.getCities().then(function (returnValue) {

                    $scope.options.cities = returnValue.data;

                });
            },


            getRecord = function () {


                return Initialize.getRecord('customer', $scope.data.id).then(function (returnValue) {

                    var res = returnValue.data;

                    $scope.data = res;
                    $scope.data.birthday = new Date(res.birthday);


                });

            },
            preLoadOptions = function () {

                /*Pre load cities*/
                angular.forEach($scope.options.cities, function (i) {

                    if ($scope.data.city_id == i.id) {
                        $scope.data.city = i;
                    }
                });

                swal.close();
            };

        getCities().then(getRecord).then(preLoadOptions);

    }
]);