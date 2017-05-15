app.controller('lotteryCtrl', function($scope, $mdDialog, $mdToast, lotteryFactory){

    $scope.readLotteries = function(){
        lotteryFactory.readLotteries().then(function successCallback(response){
            $scope.lotteries = response.data.records;
        }, function errorCallback(response){
            $scope.showToast("Unable to read lottery records.");
        });
    }

    $scope.newLotteryForm = function(event){
        $mdDialog.show({
            controller: DialogController,
            templateUrl: './app/lottery/lottery_insert.template.html',
            parent: angular.element(document.body),
            targetEvent: event,
            clickOutsideToClose: true,
            scope: $scope,
            preserveScope: true,
            fullscreen: true // Only for -xs, -sm breakpoints.
        });
    }
    $scope.createLottery = function(){
        lotteryFactory.createLottery($scope).then(function successCallback(response){
            $scope.showToast(response.data.message);
            $scope.readLotteries();
            $scope.cancel();
            $scope.clearLotteryForm();
        }, function errorCallback(response){
            $scope.showToast("Unable to create new lottery record.");
        });
    }

    $scope.clearLotteryForm = function(){
        $scope.ident        = "";
        $scope.description  = "";
        $scope.draw         = "";
        $scope.numbers      = "";
        $scope.upperNumber  = "";
        $scope.numbersTag   = "";
        $scope.specials     = "";
        $scope.upperSpecial = "";
        $scope.specialsTag  = "";
        $scope.isBonus      = "";
        $scope.baseUrl      = "";
        $scope.lastModified = "";
        $scope.endDate      = "";
    }

    $scope.showToast = function(message){
        $mdToast.show(
            $mdToast.simple()
                .textContent(message)
                .hideDelay(3000)
                .position("top right")
        );
    }

    function DialogController($scope, $mdDialog) {
        $scope.cancel = function() {
            $mdDialog.cancel();
        };
    }

    // retrieve a single record to fill out the form
    $scope.displayLotteryForm = function(id){
        lotteryFactory.readLottery(id).then(function successCallback(response){
            $scope.ident        = response.data.ident;
            $scope.description  = response.data.description;
            $scope.draw         = response.data.draw;
            $scope.numbers      = response.data.numbers;
            $scope.upperNumber  = response.data.upperNumber;
            $scope.numbersTag   = response.data.numbersTag;
            $scope.specials     = response.data.specials;
            $scope.upperSpecial = response.data.upperSpecial;
            $scope.specialsTag  = response.data.specialsTag;
            $scope.isBonus      = response.data.isBonus;
            $scope.baseUrl      = response.data.baseUrl;
            $scope.lastModified = response.data.lastModified;
            $scope.endDate      = response.data.endDate;
            $mdDialog.show({
                controller: DialogController,
                templateUrl: './app/read_a_lottery.template.html',
                parent: angular.element(document.body),
                targetEvent: event,
                clickOutsideToClose: true,
                scope: $scope,
                preserveScope: true,
                fullscreen: true
            }).then(
                function(){},
                function() {
                    $scope.clearLotteryForm();
                }
            );
        }, function errorCallback(response){
            $scope.showToast("Unable to retrieve lottery record.");
        });
    }

    // retrieve record to fill out the form
    $scope.updateLotteryForm = function(id){
        lotteryFactory.readLottery(id).then(function successCallback(response){
            $scope.ident        = response.data.ident;
            $scope.description  = response.data.description;
            $scope.draw         = response.data.draw;
            $scope.numbers      = response.data.numbers;
            $scope.upperNumber  = response.data.upperNumber;
            $scope.numbersTag   = response.data.numbersTag;
            $scope.specials     = response.data.specials;
            $scope.upperSpecial = response.data.upperSpecial;
            $scope.specialsTag  = response.data.specialsTag;
            $scope.isBonus      = response.data.isBonus;
            $scope.baseUrl      = response.data.baseUrl;
            $scope.lastModified = response.data.lastModified;
            $scope.endDate      = response.data.endDate;
            $mdDialog.show({
                controller: DialogController,
                templateUrl: './app/lottery_update.template.html',
                parent: angular.element(document.body),
                targetEvent: event,
                clickOutsideToClose: true,
                scope: $scope,
                preserveScope: true,
                fullscreen: true
            }).then(
                function(){},
                function() {
                    $scope.clearLotteryForm();
                }
            );
        }, function errorCallback(response){
            $scope.showToast("Unable to retrieve lottery record.");
        });
    }

    $scope.updateLottery = function(){
        lotteryFactory.updateLottery($scope).then(function successCallback(response){
            $scope.showToast(response.data.message);
            $scope.readLotteries();
            $scope.cancel();
            $scope.clearLotteryForm();
        },
        function errorCallback(response) {
            $scope.showToast("Unable to update lottery record.");
        });
    }

    // cofirm product deletion
    $scope.confirmDisableLottery = function(event, id){
        $scope.ident = id;
        var confirm = $mdDialog.confirm()
            .title('Are you sure?')
            .textContent('Lottery will be disabled.')
            .targetEvent(event)
            .ok('Yes')
            .cancel('No');

        // show dialog
        $mdDialog.show(confirm).then(
            function() {
                $scope.disableLottery();
            },
            function() {
            }
        );
    }

    $scope.disableLottery = function(){
        lotteryFactory.disableLottery($scope.ident).then(function successCallback(response){
            $scope.showToast(response.data.message);
            $scope.readLotteries();
        }, function errorCallback(response){
            $scope.showToast("Unable to mark lottery record as disabled.");
        });
    }

    $scope.searchLotteries = function(){
        lotteryFactory.searchLotteries($scope.search_keywords).then(function successCallback(response){
            $scope.lotteries = response.data.records;
        }, function errorCallback(response){
            $scope.showToast("Unable to search lotteries records.");
        });
    }

});
