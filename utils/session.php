<?php
    class Session{
        public function startsession(){
            session_start();
        }

        public function isLoggedIn() {
            return isset($_SESSION['user_id']);
        }

        public function logout(){
            session_destroy();
        }

        
    }
?>