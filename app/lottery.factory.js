app.factory("lotteryFactory", function($http){

    var factory = {};

    factory.readLotteries = function(){
        return $http({
            method: 'GET',
            url: 'http://www.shiny-ideas.co.uk/api/lottery_read_all.php'
        });
    };

    factory.createLottery = function($scope){
        return $http({
            method: 'POST',
            data: {
                'description'  : $scope.description,
                'draw'         : $scope.draw,
                'numbers'      : $scope.numbers,
                'upperNumber'  : $scope.upperNumber,
                'numbersTag'   : $scope.numbersTag,
                'specials'     : $scope.specials,
                'upperSpecial' : $scope.upperSpecial,
                'specialsTag'  : $scope.specialsTag,
                'isBonus'      : $scope.isBonus,
                'baseUrl'      : $scope.baseUrl
            },
            url: 'http://www.shiny-ideas.co.uk/api/lottery_create.php'
        });
    };

    factory.readLottery = function(id){
        return $http({
            method: 'GET',
            url: 'http://www.shiny-ideas.co.uk/api/lottery_read.php?id=' + id
        });
    };

    factory.updateLottery = function($scope){
        return $http({
            method: 'POST',
            data: {
                'ident'        : $scope.ident,
                'description'  : $scope.description,
                'draw'         : $scope.draw,
                'numbers'      : $scope.numbers,
                'upperNumber'  : $scope.upperNumber,
                'numbersTag'   : $scope.numbersTag,
                'specials'     : $scope.specials,
                'upperSpecial' : $scope.upperSpecial,
                'specialsTag'  : $scope.specialsTag,
                'isBonus'      : $scope.isBonus,
                'baseUrl'      : $scope.baseUrl
            },
            url: 'http://www.shiny-ideas.co.uk/api/lottery_update.php'
        });
    };

    factory.disableLottery = function(id){
        return $http({
            method: 'POST',
            data: { 'id' : id },
            url: 'http://www.shiny-ideas.co.uk/api/lottery_disable.php'
        });
    };

    // search all products
    factory.searchLotteries = function(keywords){
        return $http({
            method: 'GET',
            url: 'http://www.shiny-ideas.co.uk/api/lottery_search.php?s=' + keywords
        });
    };

    return factory;
});
