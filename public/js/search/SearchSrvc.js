app.factory('Search', function () {

    var defaultSortField = 'created_at';

    return {

        /*Find items using a search query with mandatory sort*/
        findItems: function (query, sort, url) {

            if (!sort) {
                sort = defaultSortField;
            }

            //if(url){
            //    window.location.href = siteUrl +'admin/search/items?q=' +query;
            //}

            //alert(url)

            /*Create string of queries using query array*/
            var qString = '?'

            angular.forEach(query, function (value, key) {

                if( (key && value) && key != 'page' && key != 'sort' ){
                //if (key != 'page' || key != 'sort' || value != undefined) {

                    qString += (key + '=' + value + '&')
                }

            });
            window.location.href = siteUrl + url + qString + 'sort=' + sort;

        },

        /*Sort items by category without using a search query*/
        sortItems: function (sort) {
            window.location.search = '&sort=' + sort;
        }
    };
});