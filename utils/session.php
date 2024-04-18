<?php
    class Session{
        public function startsession(){
            session_start();
        }

        public function logout(){
            session_destroy();
        }

        
    }
?>