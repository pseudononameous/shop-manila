app.controller('EditUserCtrl', ['$scope', 'Swal', 'UserResource', 'Initialize', 'User', 'Store',
    function ($scope, Swal, UserResource, Initialize, User, Store) {

        $scope.data = {
            id: js.id
        };

        $scope.options = {};

        $scope.save = function () {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/users';
            }

            UserResource.update($scope.data, function (returnValue) {

                $scope.data.id = returnValue.id;


                Swal.update(cb);

            }, function (errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };


        var getStores = function () {
                return Store.getStores().then(function (returnValue) {
                    $scope.options.stores = returnValue.data;
                })
            },

            getRecord = function () {

                return Initialize.getRecord('user', $scope.data.id).then(function (returnValue) {

                    var res = returnValue.data;

                    $scope.data = res;

                });

            },

            preLoadOptions = function () {

                angular.forEach($scope.options.stores, function (i) {

                    if ($scope.data.store_id == i.id) {
                        $scope.data.store = i;
                    }
                });

            };


        getStores().then(getRecord).then(preLoadOptions);

    }
]);