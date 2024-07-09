app.controller('AddUserCtrl', ['$scope', 'Swal', 'UserResource' , 'User', 'Store',
    function($scope, Swal, UserResource, User, Store) {


        $scope.data = {};
        $scope.options = {};

        $scope.save = function() {

            Swal.loading();

            function cb() {
                window.location.href = siteUrl + 'admin/users';
            }

            UserResource.save($scope.data, function(returnValue) {

                $scope.data.id = returnValue.id;

                var saveRole = function() {
                        return User.attachRole($scope.data.id, $scope.data.role);
                    },
                    //emailToNewUser = function(){
                    //    return Email.sendNewUser($scope.data);
                    //},
                    success = function(){

                        Swal.save(cb);
                    };

                saveRole().then(success);



            }, function(errors) {
                $scope.data.errors = errors.data;
                swal.close();
            });

        };

        var getStores = function(){
            return Store.getStores().then(function(returnValue){
                $scope.options.stores = returnValue.data;
            })
        }


        getStores();



    }
]);