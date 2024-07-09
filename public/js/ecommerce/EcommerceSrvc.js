app.factory("GATrack", function($http){
    return{
        getOrder: function(data){
            var promise = $http.get(siteUrl + 'checkout/place-order' , data);
            return promise;
        }
    };


});