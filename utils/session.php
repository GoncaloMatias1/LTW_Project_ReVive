<?php
    class Session {
        public function startSession() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
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