<?php
    class Session {

        public function __construct() {
            session_start();
        }
        
    
        public function isLoggedIn() {
            return isset($_SESSION['user_id']);
        }
    
        public function logout() {
            session_unset(); 
            session_destroy();
        }
    }
    
?>