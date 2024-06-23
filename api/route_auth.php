<?php

include 'auth.php';
include '../helper/JWT.php';
include '../helper/session.php';

header('Content-Type: application/json');

use Api\Auth;
$auth = new Auth();

use Helpers\SessionHelper;
$session = new SessionHelper();

function login() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $auth = $GLOBALS['auth'];
        $auth->email = $email;
        $auth->password = $password;
        $login = $auth->login();
        
        $token = $GLOBALS['session']->getToken($email);
        $token['user'] = $auth->_map_profile($auth->getProfile());

        if($login) {
            echo json_encode([
                'data' => $token,
                'code' => 200,
                'message' => 'Login Success'
            ]);
            header('status: 200');
            return;
        }

        echo json_encode([
            'code' => 401,
            'message' => 'Unauthorized'
        ]);
        header('status: 401');
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method Not Allowed'
    ]);
    header('status: 405');
    return;
}

function register() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $auth = $GLOBALS['auth'];
        $auth->email = $email;
        $auth->password = $password;
        $auth->name = $nama;
        $register = $auth->register();
        
        if($register) {
            echo json_encode([
                'code' => 200,
                'message' => 'Register Success'
            ]);
            header('status: 200');
            return;
        }

        echo json_encode([
            'code' => 400,
            'message' => 'Register Failed'
        ]);
        header('status: 400');
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method Not Allowed'
    ]);
    header('status: 405');
    return;
}

function logout() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo json_encode([
            'code' => 200,
            'message' => 'Logout Success'
        ]);
        header('status: 200');
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method Not Allowed'
    ]);
    header('status: 405');
    return;
}

function getProfile() {
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $authorization = $GLOBALS['session']->cek_login_exists();

        if(!$authorization) {
            echo json_encode([
                'code' => 401,
                'message' => 'Unauthorized'
            ]);
            header('status: 401');
            return;
        }
        
        $auth = $GLOBALS['auth'];
        $auth->email = $authorization->email;
        $profile = $auth->getProfile();
        if($profile) {
            echo json_encode([
                'data' => $auth->_map_profile($profile),
                'code' => 200,
                'message' => 'Success'
            ]);
            header('status: 200');
            return;
        }

        echo json_encode([
            'code' => 401,
            'message' => 'Unauthorized'
        ]);
        header('status: 401');
        return;
    }

    echo json_encode([
        'code' => 405,
        'message' => 'Method Not Allowed'
    ]);
    header('status: 405');
    return;
}


switch ($_GET['action']) {
    case 'login':
        login();
        break;
    case 'register':
        register();
        break;
    case 'logout':
        logout();
        break;
    case 'profile':
        getProfile();
        break;
    default:
        echo json_encode([
            'code' => 404,
            'message' => 'Not Found'
        ]);
        break;
}

