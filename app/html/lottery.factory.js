app.factory("userFactory", function($http){

    var factory = {};

    factory.readUsers = function(){
        return $http({
            method: 'GET',
            url: 'http://localhost/api/user/read.php'
        });
    };

    factory.createUser = function($scope){
        return $http({
            method: 'POST',
            data: {
                'title'         : $scope.title,
                'first_name'    : $scope.first_name,
                'last_name'     : $scope.last_name,
                'email_address' : $scope.email_address,
                'start_date'    : $scope.start_date,
                'end_date'      : $scope.end_date,
                'password'      : $scope.password
            },
            url: 'http://localhost/api/user/create.php'
        });
    };

    factory.readUser = function(id){
        return $http({
            method: 'GET',
            url: 'http://localhost/api/user/read_a.php?id=' + id
        });
    };

    factory.updateUser = function($scope){
        return $http({
            method: 'POST',
            data: {
                'id'            : $scope.id,
                'title'         : $scope.title,
                'first_name'    : $scope.first_name,
                'last_name'     : $scope.last_name,
                'email_address' : $scope.email_address,
                'start_date'    : $scope.start_date,
                'end_date'      : $scope.end_date,
                'password'      : $scope.password
            },
            url: 'http://localhost/api/user/update.php'
        });
    };

    factory.disableUser = function(id){
        return $http({
            method: 'POST',
            data: { 'id' : id },
            url: 'http://localhost/api/user/disable.php'
        });
    };

    // search all products
    factory.searchUsers = function(keywords){
        return $http({
            method: 'GET',
            url: 'http://localhost/api/user/search.php?s=' + keywords
        });
    };

    return factory;
});
