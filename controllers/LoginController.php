<?php
    include("services/UserService.php");

    class LoginController{
        public function index(){
            include("views/login/login.php");
            
        }

        public function processLogin(){
            $userService = new UserService();
            $processLogin = $userService-> userLogin();
        }
      
    }
?>   