app.controller('userController', function($scope, $mdDialog, $mdToast, userFactory){

    // read all users
    $scope.readUsers = function(){
        userFactory.readUsers().then(function successCallback(response){
            $scope.users = response.data.records;
        }, function errorCallback(response){
            $scope.showToast("Unable to read user records.");
        });

    }

    // show 'create user form' in dialog box
    $scope.showNewUserForm = function(event){
        $mdDialog.show({
            controller: DialogController,
            templateUrl: './app/user/create_user.template.html',
            parent: angular.element(document.body),
            targetEvent: event,
            clickOutsideToClose: true,
            scope: $scope,
            preserveScope: true,
            fullscreen: true // Only for -xs, -sm breakpoints.
        });
    }
    $scope.createUser = function(){
        userFactory.createUser($scope).then(function successCallback(response){
            $scope.showToast(response.data.message);
            $scope.readUsers();
            $scope.cancel();
            $scope.clearUserForm();
        }, function errorCallback(response){
            $scope.showToast("Unable to create new user record.");
        });
    }

    // clear variable / form values
    $scope.clearUserForm = function(){
        $scope.id            = "";
        $scope.first_name    = "";
        $scope.last_name     = "";
        $scope.title         = "";
        $scope.email_address = "";
        $scope.password      = "";
    }

    // show toast message
    $scope.showToast = function(message){
        $mdToast.show(
            $mdToast.simple()
                .textContent(message)
                .hideDelay(3000)
                .position("top right")
        );
    }

    // methods for dialog box
    function DialogController($scope, $mdDialog) {
        $scope.cancel = function() {
            $mdDialog.cancel();
        };
    }

    // retrieve a single record to fill out the form
    $scope.readUser = function(id){
        userFactory.readUser(id).then(function successCallback(response){
            $scope.id            = response.data.id;
            $scope.title         = response.data.title;
            $scope.first_name    = response.data.first_name;
            $scope.last_name     = response.data.last_name;
            $scope.email_address = response.data.email_address;
            $scope.start_date    = response.data.start_date;
            $scope.end_date      = response.data.end_date;
            $scope.password      = response.data.password;

            $mdDialog.show({
                controller: DialogController,
                templateUrl: './app/user/read_a_user.template.html',
                parent: angular.element(document.body),
                targetEvent: event,
                clickOutsideToClose: true,
                scope: $scope,
                preserveScope: true,
                fullscreen: true
            }).then(
                function(){},
                // user clicked 'Cancel'
                function() {
                    // clear modal content
                    $scope.clearUserForm();
                }
            );
        }, function errorCallback(response){
            $scope.showToast("Unable to retrieve user record.");
        });
    }

    // retrieve record to fill out the form
    $scope.showUpdateUserForm = function(id){
        userFactory.readUser(id).then(function successCallback(response){
            $scope.id            = response.data.id;
            $scope.title         = response.data.title;
            $scope.first_name    = response.data.first_name;
            $scope.last_name     = response.data.last_name;
            $scope.email_address = response.data.email_address;
            $scope.start_date    = response.data.start_date;
            $scope.end_date      = response.data.end_date;
            $scope.password      = response.data.password;

            $mdDialog.show({
                controller: DialogController,
                templateUrl: './app/user/update_user.template.html',
                parent: angular.element(document.body),
                targetEvent: event,
                clickOutsideToClose: true,
                scope: $scope,
                preserveScope: true,
                fullscreen: true
            }).then(
                function(){},
                // user clicked 'Cancel'
                function() {
                    // clear modal content
                    $scope.clearUserForm();
                }
            );
        }, function errorCallback(response){
            $scope.showToast("Unable to retrieve user record.");
        });
    }

    // update user record / save changes
    $scope.updateUser = function(){
        userFactory.updateUser($scope).then(function successCallback(response){
            $scope.showToast(response.data.message);
            $scope.readUsers();
            $scope.cancel();
            $scope.clearUserForm();
        },
        function errorCallback(response) {
            $scope.showToast("Unable to update user record.");
        });
    }

    // cofirm product deletion
    $scope.confirmDisableUser = function(event, id){
        $scope.id = id;
        var confirm = $mdDialog.confirm()
            .title('Are you sure?')
            .textContent('User will be disabled.')
            .targetEvent(event)
            .ok('Yes')
            .cancel('No');

        // show dialog
        $mdDialog.show(confirm).then(
            // 'Yes' button
            function() {
                // if user clicked 'Yes', disable user
                $scope.disableUser();
            },
            // 'No' button
            function() {
                // hide dialog
            }
        );
    }

    // delete user (end dated)
    $scope.disableUser = function(){
        userFactory.disableUser($scope.id).then(function successCallback(response){
            $scope.showToast(response.data.message);
            $scope.readUsers();
        }, function errorCallback(response){
            $scope.showToast("Unable to mark user record as disabled.");
        });
    }

    // search users
    $scope.searchUsers = function(){
        userFactory.searchUsers($scope.user_search_keywords).then(function successCallback(response){
            $scope.users = response.data.records;
        }, function errorCallback(response){
            $scope.showToast("Unable to search user records.");
        });
    }

});
