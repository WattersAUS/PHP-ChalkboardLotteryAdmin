app.controller('lotteryCtrl', function($scope, $mdDialog, $mdToast, lotteryFactory){

    // general system mesg popup
    $scope.infoMessage = function(message) {
        $mdToast.show(
            $mdToast.simple()
                .textContent(message)
                .hideDelay(4000)
                .position('top right')
        );
    }

    $scope.errorMessage = function(message) {
        var alert = $mdDialog.alert({
            title: 'An Error has occurred!',
            textContent: message,
            ok: 'Close'
        });
        $mdDialog.show( alert ).finally(function() {
            alert = undefined;
        });
    }

    // when in the new/update form clear down after use
    $scope.clearFormScope = function() {
        $scope.ident        = '';
        $scope.description  = '';
        $scope.draw         = '';
        $scope.numbers      = '';
        $scope.upperNumber  = '';
        $scope.numbersTag   = '';
        $scope.specials     = '';
        $scope.upperSpecial = '';
        $scope.specialsTag  = '';
        $scope.isBonus      = '';
        $scope.baseUrl      = '';
        $scope.lastModified = '';
        $scope.endDate      = '';
        $scope.bonusText    = '';
    }

    // basic read / search (arrays returned)
    $scope.readLotteries = function() {
        lotteryFactory.readLotteries().then(function successCallback(response) {
            if (response.data.count == 0) {
                $scope.infoMessage('WARNING: No records were returned from the database!');
            }
            $scope.lotteries = response.data.records;
        }, function errorCallback(response){
            $scope.errorMessage('Unable to return lottery records!');
        });
    }

    $scope.searchLotteries = function() {
        lotteryFactory.searchLotteries($scope.search_keywords).then(function successCallback(response){
            $scope.lotteries = response.data.records;
        }, function errorCallback(response) {
            $scope.errorMessage('Unable to search lottery records!');
        });
    }

    // generic dialog controller displays insert, read, update forms
    function DialogController($scope, $mdDialog) {
        $scope.cancel = function() {
            $mdDialog.cancel();
        };
    }

    // load up the form for a new lottery, display
    $scope.insertLotteryForm = function(event) {
        $mdDialog.show({
            controller: DialogController,
            templateUrl: './app/lottery_insert.template.html',
            parent: angular.element(document.body),
            targetEvent: event,
            clickOutsideToClose: true,
            scope: $scope,
            preserveScope: true,
            fullscreen: true // Only for -xs, -sm breakpoints.
        });
    }

    // and post collected data when the user selects Insert
    $scope.insertLottery = function() {
        lotteryFactory.insertLottery($scope).then(function successCallback(response) {
            if (response.data.success == 'Ok') {
                $scope.infoMessage('Lottery (' + $scope.description + ') added!');
            } else {
                $scope.errorMessage(response.data.success);
            }
            $scope.readLotteries();
            $scope.cancel();
            $scope.clearFormScope();
        }, function errorCallback(response) {
            $scope.errorMessage('Unable to insert new lottery record!');
        });
    }

    // retrieve a single record from the array to fill out the form
    $scope.viewLotteryForm = function(id) {
        lotteryFactory.readLottery(id).then(function successCallback(response){
            if (response.count == 0) {
                $scope.errorMessage('Unable to return selected lottery record id ' + id + '!');
            } else if (response.count > 0) {
                $scope.errorMessage('To many records returned for id: ' + id + '!');
            } else {
                $scope.ident        = response.data.records[0].ident;
                $scope.description  = response.data.records[0].description;
                $scope.draw         = response.data.records[0].draw;
                $scope.numbers      = response.data.records[0].numbers;
                $scope.upperNumber  = response.data.records[0].upperNumber;
                $scope.numbersTag   = response.data.records[0].numbersTag;
                $scope.specials     = response.data.records[0].specials;
                $scope.upperSpecial = response.data.records[0].upperSpecial;
                $scope.specialsTag  = response.data.records[0].specialsTag;
                $scope.isBonus      = response.data.records[0].isBonus;
                if ($scope.isBonus == 1) {
                    $scope.bonusText = 'Yes';
                } else {
                    $scope.bonusText = 'No';
                }
                $scope.baseUrl      = response.data.records[0].baseUrl;
                $scope.lastModified = response.data.records[0].lastModified;
                $scope.endDate      = response.data.records[0].endDate;
                $mdDialog.show({
                    controller: DialogController,
                    templateUrl: './app/lottery_view.template.html',
                    parent: angular.element(document.body),
                    targetEvent: event,
                    clickOutsideToClose: true,
                    scope: $scope,
                    preserveScope: true,
                    fullscreen: true
                }).then(
                    function(){},
                    function() {
                        $scope.clearFormScope();
                    }
                );
            }
        }, function errorCallback(response) {
            $scope.errorMessage('Unable to retrieve lottery record!');
        });
    }

    // retrieve record to fill out the form ready to be updated
    $scope.updateLotteryForm = function(id) {
        lotteryFactory.readLottery(id).then(function successCallback(response) {
            if (response.count == 0) {
                $scope.errorMessage('Unable to return selected lottery record id ' + id + '!');
            } else if (response.count > 0) {
                $scope.errorMessage('Too many records returned for id: ' + id + '!');
            } else {
                $scope.ident        = response.data.records[0].ident;
                $scope.description  = response.data.records[0].description;
                $scope.draw         = response.data.records[0].draw;
                $scope.numbers      = response.data.records[0].numbers;
                $scope.upperNumber  = response.data.records[0].upperNumber;
                $scope.numbersTag   = response.data.records[0].numbersTag;
                $scope.specials     = response.data.records[0].specials;
                $scope.upperSpecial = response.data.records[0].upperSpecial;
                $scope.specialsTag  = response.data.records[0].specialsTag;
                $scope.isBonus      = response.data.records[0].isBonus;
                if ($scope.isBonus == 1) {
                    $scope.bonusText = 'Yes';
                } else {
                    $scope.bonusText = 'No';
                }
                $scope.baseUrl      = response.data.records[0].baseUrl;
                $scope.lastModified = response.data.records[0].lastModified;
                $scope.endDate      = response.data.records[0].endDate;
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
                        $scope.clearFormScope();
                    }
                );
            }
        }, function errorCallback(response) {
            $scope.errorMessage('Unable to retrieve lottery record!');
        });
    }

    // if the user selects update, get to it!
    $scope.updateLottery = function() {
        lotteryFactory.updateLottery($scope).then(function successCallback(response) {
            if (response.data.success == 'Ok') {
                $scope.infoMessage('Lottery (' + $scope.description + ') updated!');
            } else {
                $scope.errorMessage(response.data.success);
            }
            $scope.readLotteries();
            $scope.cancel();
        },
        function errorCallback(response) {
            $scope.errorMessage('Unable to update lottery record (' + $scope.ident + ')!');
        });
    }

});
