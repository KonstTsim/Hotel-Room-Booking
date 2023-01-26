<?php

namespace Hotel;

use PDO;
use Hotel\BaseService;

class User extends BaseService
{
    const TOKEN_KEY = 'asfdhkjlr;asdaertedfgvdswerg';

    private static $currentUserId;

    public function getByUserId($userId)
    {
        $parameters = [
            ':user_id' => $userId
        ];
        return $this->fetch('SELECT * FROM user WHERE user_id = :user_id', $parameters);
    }

    public function getByEmail($email)
    {
        $parameters = [
            ':email' => $email
        ];
        return $this->fetch('SELECT * FROM user WHERE email = :email', $parameters);
    }

    public function getList()
    {
        return $this->fetchAll('SELECT * FROM user');
    }

    public function insert($name, $email, $password)
    {
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        //prepare parameters
        $parameters = [
            ':name' => $name,
            ':email' => $email,
            ':password' => $passwordHash,
        ];
        $rows = $this->execute('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)', $parameters);

        return $rows == 1;
    }

    public function verify($email, $password)
    {
        //Step 1 - Retrieve user
        $user = $this->getByEmail($email);

        //Step 2 - Verify user password
        return password_verify($password, $user['password']);
    }

    public function generateToken($userId, $csrf = '')
    {
        //create token payload
        $payload = [
            'user_id' => $userId,
            'csrf'=> $csrf ?: md5(time()),
        ];
        $payloadEncoded = base64_encode(json_encode($payload));
        $signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);

        return sprintf('%s.%s', $payloadEncoded, $signature);
    }

    public static function getTokenPayload($token)
    {
        // Get payload and signature
        [$payloadEncoded] = explode('.', $token);

        // Get payload
        return json_decode(base64_decode($payloadEncoded), true);
    }

    public function verifyToken($token)
    {
        // Get payload
        $payload = $this->getTokenPayload($token);
        $userId = $payload['user_id'];
        $csrf = $payload['csrf'];

        //Generate signature and verify for user
        return $this->generateToken($userId, $csrf) == $token;
    }

    public static function verifyCsrf($csrf)
    {
       return self::getCsrf() == $csrf;
    }

    public static function getCsrf()
    {
        $token = $_COOKIE['user_token'];
        $payload = self::getTokenPayload($token);
        
        return $payload['csrf'];
    }
    
 
    public static function getCurrentUserId()
    {
        return self::$currentUserId;
    }

    public static function setCurrentUserId($userId)
    {
        self::$currentUserId = $userId;
    }


    public function signOut()
    {
    // // Unset the current user ID
    self::$currentUserId = null;

    // // Delete the user's authentication token from their session or browser storage
    // // For example, if you are using a session to store the token:
    unset($_SESSION['auth_token']);

    // // Destroy the user's session
    session_destroy();
    }

    public static function logout()
    {
        // Start the session
        session_start();
        self::$currentUserId = null;

        // Unset all session variables
        $_SESSION = array();

        // // Delete the user's authentication token from their session or browser storage
        // For example, if you are using a session to store the token:
        unset($_SESSION['auth_token']);

        // Delete the user_token cookie
        setcookie('user_token', '', time() - 3600);

        // Destroy the session
        $result = session_destroy();

        if ($result) {
            // The session was destroyed successfully
            // Do something here, such as redirecting the user to the home page
            header('Location: index.php');
            exit;
        } else {
            // The session could not be destroyed
            // Do something here, such as displaying an error message
            echo 'An error occurred while logging out';
    }
    }
}
