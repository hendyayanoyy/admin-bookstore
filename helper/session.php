<?php 

session_start();

class SessionHelper {

    public function cek_login_exists() {
        if(isset($_SESSION['username']) || isset($_SESSION['email'])) {
            return true;
        }

        return false;
    }

}