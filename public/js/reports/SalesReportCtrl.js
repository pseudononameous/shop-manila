app.controller('SalesReportCtrl', ['$scope', 'Report',
    function ($scope, Report) {

        $scope.data = {
            filter: '24hrs'
        }

        /*Initialize google chart*/
        $scope.drawBasic = function (salesData) {

            if (!salesData)
                return;

            var data = new google.visualization.DataTable();
            data.addColumn('number', 'X');
            data.addColumn('number', 'Sale');

            var rows = [];

            for (var ctr = 1; ctr <= salesData.days; ctr++) {
                var row = [ctr, salesData.sales[ctr]];
                rows.push(row);
            }

            data.addRows(rows);

            var options = {
                hAxis: {
                    title: 'Day'
                },
                vAxis: {
                    title: 'Sales'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }

        google.charts.load('current', {packages: ['corechart', 'line']});

        /*Use feed gchart with real data*/
        var getReport = function (filter) {
            Report.getSales(filter).then(function (returnValue) {

                var res = returnValue.data;

                google.charts.setOnLoadCallback(function () {
                    $scope.drawBasic(res);
                })
            });
        }

        getReport($scope.data.filter);

        $scope.filter = function () {

            getReport($scope.data.filter);

        };


    }
]);