var app = angular.module('app', [ 'ngRoute', 'ngFileUpload', 'ngResource', 'ngTagsInput']);

app.filter('myDateFormat', function myDateFormat($filter){
  // return function(){
  return function(text){
    // var  tempdate = new Date();
    // 
    if (text){
        
        var  tempdate = new Date(text.replace(/-/g,"/"));
        return $filter('date')(tempdate, "MMM dd, yyyy");
    }
  };
});



app.controller('AppCtrl', ['$scope', '$http',
    function($scope, $http) {

        // $scope.itemsPerPage = 15;
        //
        // $scope.logout = function() {
        //
        //     Auth.logout('customer').then(function(returnValue){
        //         window.location.href = siteUrl;
        //     });
        //
        // };

    }

]);

app.controller('ContactUsCtrl', ['$scope', '$http', 'Swal',
    function($scope, $http, Swal) {

        $scope.data = {};

        $scope.send = function() {

            Swal.loading();

            $http.post(siteUrl + 'email/contact', $scope.data ).then(function(){
                swal('Contact form sent!');
                $scope.data = {};
            });

            
        };

    }

]);


//////////
//Admin //
//////////

app.controller('AdminLoginCtrl', ['$scope', '$http', 'Auth',
    function($scope, $http, Auth) {

        $scope.data = {};

        $scope.submit = function() {
            $scope.data.valid = [];
            $http.post('admin/login', $scope.data).success(function(returnValue) {
                
                if(returnValue){
                    window.location.href = siteUrl + 'admin/dashboard' ;
                }else{
                    $scope.data.authenticate = 1;
                    $scope.data.message = 'Invalid username/password';
                }

            });
        };

        $scope.logout = function() {
        
            Auth.logout('admin').then(function(returnValue){
                window.location.href = siteUrl + 'admin';
            });
            
        };

    }
]);