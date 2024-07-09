/* ==========================================================================
   Directives
    DOM related functions
   ========================================================================== */

app.directive('myCkEditor', ['$timeout', function ($timeout) {
    return {
        require: '?ngModel',
        link: function ($scope, elm, attr, ngModel) {

            $timeout(function() {
                ckeditor();
            }, 500);


            function ckeditor(){

                var ck = CKEDITOR.replace(elm[0], {
                    filebrowserUploadUrl: siteUrl + 'upload/upload'
                });

                if (!ngModel) return;

                ck.on('instanceReady', function() {
                    ck.setData(ngModel.$viewValue);
                });

                function updateModel() {
                    $scope.$apply(function() {
                        ngModel.$setViewValue(ck.getData());
                    });
                }

                ck.on('change', updateModel);
                ck.on('key', updateModel);
                ck.on('dataReady', updateModel);

                ngModel.$render = function(value) {
                    ck.setData(ngModel.$viewValue);
                }
            }

            //var ck = CKEDITOR.replace(elm[0], {
            //    filebrowserUploadUrl: '/uploader/upload'
            //});
            //
            //ck.on('pasteState', function () {
            //    $scope.$apply(function () {
            //        ngModel.$setViewValue(ck.getData());
            //    });
            //});
            //
            //ngModel.$render = function (value) {
            //    ck.setData(ngModel.$modelValue);
            //};
        }
    };
}])



/**
 * myTooltipTitle
 *
 * Adds a tooltip with content
 *
 */
app.directive('myTooltipTitle', function() {
    return {
        link: function(scope, elem, attrs) {
            elem.tooltip({
                title: attrs.myTooltipTitle
            });
        }
    };
});

/**
 * myPreventDefault
 *
 * Use prevent default for some dom ops
 *
 */

app.directive('myPreventDefault', function() {
    return {
        link: function(scope, elem, attr) {
            elem.bind('click', function(e) {
                e.preventDefault();
                return;
            });
        }
    };
});


/**
 * myBootstrapPanel
 *
 * Uses bootstrap panel class
 *
 */
app.directive('myBootstrapPanel', function() {

    var t = '<div class="panel panel-primary">';
    t += '<div class="panel-heading">';
    t += '<h3 class="panel-title">{{title}}</h3>';
    t += '</div>';
    t += '<div class="panel-body" ng-transclude></div>';
    t += '</div>';

    return {
        restrict: 'E',
        scope: {
            title: '@'
        },
        transclude: true,
        template: t

    };
});

/**
 * myStaticDisplay
 *
 * Uses bootstrap classes for static display
 *
 */
app.directive('myStaticDisplay', function() {

    var t = '<div class="form-group">';
    t += '<label class="control-label cstm_accnt_label col-sm-{{labelSize}}">{{label}}</label>';
    t += '<div class="col-sm-{{valueSize}} form-control-static">';
    t += '<span ng-transclude>{{value}}</span>';
    t += '</div>';
    t += '</div>';

    return {
        restrict: 'E',
        scope: {
            label: '@',
            value: '@',
            labelSize: '@',
            valueSize: '@'
        },
        transclude: true,
        template: t

    };
});

/**
 * myFormLogs
 *
 */
app.directive('myFormLogs', function() {

    var t = '<ul class="list-group" style="margin-top:40px; width:400px;">';
    t += '<li class="list-group-item" ng-if="createdBy"><small>Created by: {{createdBy}}</small></li>';
    t += '<li class="list-group-item" ng-if="modifiedBy"><small>Modified by: {{modifiedBy}}</small></li>';
    t += '</ul>';

    return {
        restrict: 'E',
        scope: {
            createdBy: '@',
            modifiedBy: '@'
        },
        transclude: true,
        template: t
    };
});

/**
 * myFormButtons
 *
 * Generate buttons for forms
 */
app.directive('myFormButtons', function() {

    var t = '<div class="pull-right">';
    t += '<button type="submit" class="btn btn-success" ng-disabled="isInvalid"><span class="glyphicon glyphicon-save"></span> Save</button>';
    t += '&nbsp;<a href="{{returnTo}}" class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> Cancel</a>';
    t += '</div>';

    return {
        restrict: 'E',
        scope: {
            isInvalid: '=',
            returnTo: '@',
        },
        transclude: false,
        template: t
    };
});



/**
 * myHorizontalForm
 *
 * Uses bootstrap classes for displaying horizontal forms
 *
 */
app.directive('myHorizontalForm', function() {

    var t = '<div class="form-group">';
    t += '<label class="control-label col-md-{{labelSize}}">{{label}}</label>';
    t += '<div class="col-md-{{valueSize}}">';
    t += '<div class="{{formClass}}" ng-transclude></div>';
    t += '</div>';
    t += '</div>';


    return {
        restrict: 'E',
        replace: true,
        scope: {
            formClass: '@',
            label: '@',
            labelSize: '@',
            valueSize: '@'
        },
        transclude: true,
        template: t,

    };
});

/**
 * myFormError
 *
 *
 */
app.directive('myFormError', function() {

    var t = '<div ng-show="message" class="alert alert-danger" role="alert">';
    t += '<span class="glyphicon glyphicon-exclamation-sign"></span>';
    t += ' {{message}}';
    t += '</div>';


    return {
        restrict: 'E',
        replace: true,
        scope: {
            valid: '@',
            message: '@'
        },
        template: t,
    };
});

app.directive('myElevateZoom', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {

            scope.$watch(
                function() {
                    return attrs.zoomImage;
                },
                function(newValue, oldValue) {
                  if(newValue){
                    // console.info(oldValue + ' old');
                    // console.info(newValue + ' old');
                    // element.attr('data-zoom-image', oldValue);
                    $('.zoomContainer').remove(); // To prevent plugin from adding endless zoomcontainer element
                    element.elevateZoom();

                  }
                });

            return;
        }
    };
});
/**
 * myNotMoreThanValue
 *
 * Validate inputs to accept values not greater than other value
 */
app.directive('myNotMoreThanValue', function() {

    return {
        require: 'ngModel',
        link: function(scope, elem, attrs, ctrl) {


            // scope.$watch(function(){
            //     if (parseFloat(scope.data.qty) <= parseFloat(attrs.myNotMoreThanValue)) {
            //         ctrl.$setValidity('myNotMoreThanValue', true);
            //         return scope.data.qty;
            //     } else {
            //         ctrl.$setValidity('myNotMoreThanValue', false);
            //         return undefined;
            //     }
            // });

            ctrl.$parsers.unshift(function(viewValue) {
                if (parseFloat(viewValue) <= parseFloat(attrs.myNotMoreThanValue)) {
                   ctrl.$setValidity('myNotMoreThanValue', true);
                   return viewValue;
                } else {
                   ctrl.$setValidity('myNotMoreThanValue', false);
                   return undefined;
                }

            });
        }
    };
});

/**
 * myEqualValue
 *
 * Validate inputs to accept values not greater than other value
 */
app.directive('myEqualValue', function() {

    return {
        require: 'ngModel',
        link: function(scope, elem, attrs, ctrl) {


            ctrl.$parsers.unshift(function(viewValue) {
                if (parseFloat(viewValue) == parseFloat(attrs.myEqualValue) && parseFloat(viewValue) != 0 ) {
                   ctrl.$setValidity('myEqualValue', true);
                   return viewValue;
                } else {
                   ctrl.$setValidity('myEqualValue', false);
                   return undefined;
                }

            });
        }
    };
});

/**
 * myNotMoreThanStock
 *
 * Validate inputs to accept values not greater than other value
 */
app.directive('myNotMoreThanStock', function() {

    return {
        require: 'ngModel',
        link: function(scope, elem, attrs, ctrl) {

            scope.$watch(function(){
                if (parseFloat(scope.data.qty) <= parseFloat(attrs.myNotMoreThanStock)) {
                    ctrl.$setValidity('myNotMoreThanStock', true);
                    return scope.data.qty;
                } else {
                    ctrl.$setValidity('myNotMoreThanStock', false);
                    return undefined;
                }
            });
        }
    };
});

app.directive('myCountdownTimer', function($interval, $http, dateFilter) {

    return {

        link: function(scope, elem, attrs, ctrl) {

            $http.get(siteUrl + 'admin/items/getRecord/' + attrs.myCountdownTimer).success(function(returnValue) {

                if (returnValue.avail_until == '0000-00-00') {
                    return;
                }

                function updateTime() {

                    var availUntil = new Date(returnValue.avail_until);

                    var dateNow = new Date();

                    var seconds = Math.floor((availUntil - (dateNow)) / 1000);
                    var minutes = Math.floor(seconds / 60);
                    var hours = Math.floor(minutes / 60);
                    var days = Math.floor(hours / 24);

                    hours = hours - (days * 24);
                    minutes = minutes - (days * 24 * 60) - (hours * 60);
                    seconds = seconds - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minutes * 60);

                    var timeRemaining = '';
                    timeRemaining += (days ? days + ' days ' : '');
                    timeRemaining += (hours ? hours + ' hours ' : '');
                    timeRemaining += (minutes ? minutes + ' minutes ' : '');

                    elem.text(timeRemaining);
                }

                // watch the expression, and update the UI on change.
                scope.$watch(attrs.myCountdownTimer, function(value) {
                    format = value;
                    updateTime();
                });

                $interval(updateTime, 1000);

            });



        }
    };
});