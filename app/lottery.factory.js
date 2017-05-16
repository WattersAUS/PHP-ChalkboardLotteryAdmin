app.factory("lotteryFactory", function($http){

    var factory = {};

    // return array of recs to controller
    factory.readLotteries = function(){
        return $http({
            method: 'GET',
            url: 'http://www.shiny-ideas.co.uk/api/lottery_read_all.php'
        });
    };

    // may only be one in the array (needs to be tested)
    factory.readLottery = function(id){
        return $http({
            method: 'GET',
            url: 'http://www.shiny-ideas.co.uk/api/lottery_read.php?id=' + id
        });
    };

    // return array of LIKE data
    factory.searchLotteries = function(keywords){
        return $http({
            method: 'GET',
            url: 'http://www.shiny-ideas.co.uk/api/lottery_search.php?s=' + keywords
        });
    };

    // insert one
    factory.insertLottery = function($scope){
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
            url: 'http://www.shiny-ideas.co.uk/api/lottery_insert.php'
        });
    };

    // update data
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

    // will update one field on the data
    factory.disableLottery = function(id){
        return $http({
            method: 'POST',
            data: { 'id' : id },
            url: 'http://www.shiny-ideas.co.uk/api/lottery_disable.php'
        });
    };

    factory.enableLottery = function(id){
        return $http({
            method: 'POST',
            data: { 'id' : id },
            url: 'http://www.shiny-ideas.co.uk/api/lottery_enable.php'
        });
    };

    return factory;
});
