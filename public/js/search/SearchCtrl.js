app.controller('SearchCtrl', ['$scope', 'Search',
    function ($scope, Search) {

        $scope.data = {};
        $scope.data.query = {};

        /*To set ng-model to current query value*/
        function setDefaultQueryValue() {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            angular.forEach(vars, function (value) {
                var queryValue = value.split("=");
                $scope.data.query[queryValue[0]] = decodeURIComponent(queryValue[1]);
            });


        }

        setDefaultQueryValue();


        $scope.search = function (sort, url) {
            Search.findItems($scope.data.query, sort, url);

        };


        $scope.sortItems = function (prioritySort) {

            //Override data.sort if a parameter has been passed
            if(prioritySort != ''){
                $scope.data.sort = prioritySort;
            }

            Search.sortItems($scope.data.sort);
        };




    }
]);