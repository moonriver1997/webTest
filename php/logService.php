<?php
    include_once('dbConnect.php');
    header('Content-Type: text/html; charset=utf-8');

    if (function_exists($_GET['fn'])){
        $_GET['fn']();
    }
    else{
        echo "function does not exist!!!";
    }

    function logout() {
        if (session_id() == '') {
            normal_session_start();
        }
        
        $_SESSION = array();
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $cookieParams["path"], $cookieParams["domain"], $cookieParams["secure"], $cookieParams["httponly"]);
        session_destroy();
        
        echo '{ "loginStatus": "logout success" }';
    }

    function login() {
        if (session_id() == '') {
            normal_session_start();
        }
        
        $postData = file_get_contents("php://input");
        $request = json_decode($postData);
        
        $account = $request->account;
        $password = $request->loginPassword;
        
        $connect = connectionInit();
        
        echo loginOperate($account, $password, $connect);
    }
    function loginOperate($account, $password, $connect) {
        $preQuery = "SELECT userID, name, account, password, boss, super FROM user WHERE account = ? LIMIT 1";
        
        if ($statement = $connect->prepare($preQuery)) {
            $statement->bind_param('s', $account);
            $statement->execute();
            $statement->store_result();
            
            $statement->bind_result($userID, $userName, $account, $loginPassword, $boss, $super);
            $statement->fetch();
            
            if ($statement->num_rows == 1) {
                $loginPassword = hash('sha512', $loginPassword);
                if (hashEquals($loginPassword, $password)) {
                    $userBrowser = $_SERVER['HTTP_USER_AGENT'];
                    $userID = preg_replace("/[^0-9]+/", "", $userID);
                    $_SESSION['userID'] = $userID;
                    $_SESSION['userName'] = $userName;
                    $_SESSION['loginString'] = hash('sha512', $loginPassword .$userBrowser);
                    $ObjTmp= new StdClass();
                    $ObjTmp->loginStatus = "success";
                    $ObjTmp->userName = $userName;
                    $ObjTmp->bossState = $boss;
                    $ObjTmp->super = $super;
                    return json_encode($ObjTmp);
                }
                else {
                    return '{ "loginStatus": "error" }';
                }
            }
            else {
                return '{ "loginStatus": "error" }';
            }
        }
        else {
            echo "prepare false";
        }
        
    }

    function hashEquals ($a, $b) {
        $aLength = strlen($a);
        if ($aLength !== strlen($b) ) {
            return false;
        }
        $result = 0;
        for ( $i = 0; $i < $a_length; $i++ ) {
            $result |= ord( $a[ $i ] ) ^ ord( $b[ $i ] );
          }

          return $result === 0;
    }

    function loginCheck() {
        if(session_id() == '') {
            sec_session_start();
        }
        
        $connect = connectionInit();
        
        if (loginChecker($connect) == true) {
            echo '{"result": "logged_in", "userName": "'.$_SESSION['userName'].'"}';
        }
        else {
            echo '{ "result": "logged_out" }';
        }
    }

    function loginChecker($connect) {
        if (isset($_SESSION['userName'], $_SESSION['loginString'])) {
            $userID = $_SESSION['userID'];
            $userName = $_SESSION['userName'];
            $loginString = $_SESSION['loginString'];
            $userBrowser = $_SERVER['HTTP_USER_AGENT'];
            
            $preQuery = "SELECT password FORM user WHERE userID = ? LIMIT 1";
            if ($statement = $connect->prepare($preQuery)) {
                $statement->bind_param('i', $userID);
                $statement->execute();
                $statement->store_result();
                
                if ($statement->num_rows == 1) {
                    $statement->bind_result($password);
                    $statement->fetch();
                    $statement = hash('sha512', $password);
                    
                    $loginChecker = hash('sha512', $password . $userBrowser);
                    
                    if (hashEquals($loginChecker, $loginString)) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        }
        else{
            return false;
        }
    }
    
//    session function
    function normal_session_start() {
        $sessionName = 'webTemplate_sessionID';
        $secure = false;
        $httpOnly = true;
        
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            echo "Could not initiate a safe session (ini_set)";
            exit();
        }
        
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httpOnly);
        session_name($sessionName);
        session_start();
    }
    function sec_session_start() {
        $sessionName = 'webTemplate_sessionID';
        $secure = false;
        $httpOnly = true;
        
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            echo "Could not initiate a safe session (ini_set)";
            exit();
        }
        
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httpOnly);
        ini_set('session.cookie_lifetime', 0);
        session_name($sessionName);
        session_start();
        session_regenerate_id(true);
    }
?>