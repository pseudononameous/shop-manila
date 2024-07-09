app.controller('EditProfileCtrl', ['$scope', 'Swal', 'Initialize', 'UserResource', 'Role', 'User',
    function ($scope, Swal, Initialize, UserResource, Role, User) {
        $scope.data = {
            id: js.id
        };
        $scope.options = {};

        $scope.save = function () {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin';
            }

            UserResource.update($scope.data, function (returnValue) {

                $scope.data.id = returnValue.id;

                var removeRole = function () {
                        return User.removeAttachedRole($scope.data.id);
                    },

                    saveRole = function () {
                        return User.attachRole($scope.data.id, $scope.data.role);
                    };

                // removeRole().then(saveRole);

                Swal.update(cb);

            }, function (errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };

        var getRoles = function () {

                return Role.getRoles().then(function (returnValue) {
                    $scope.options.roles = returnValue.data;
                });

            },
            getAssignedRole = function () {
                return Role.getAttachedRole($scope.data.id).then(function (returnValue) {
                    $scope.data.role_id = returnValue.data;
                });
            },
            retrieveRecord = function () {

                return Initialize.retrieveRecord('action-user', $scope.data.id).then(function (returnValue) {

                    var res = returnValue.data;

                    $scope.data = res;

                });

            },

            preLoadOptions = function () {

                angular.forEach($scope.options.roles, function (i) {

                    if ($scope.data.role_id == i.id) {
                        $scope.data.role = i;
                    }
                });

            };

        getRoles().then(retrieveRecord).then(getAssignedRole).then(preLoadOptions);
    }
]);