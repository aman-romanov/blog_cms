<?php
/**
 * User
 * 
 * author or reader of the blog
 */
class User {
    public $id;
    public $username;
    public $password;
    /**
     * Authentication of the user by username and password
     * 
     * @param string username
     * @param string password
     * @param object $conn is Connection to the DB
     * 
     * @return boolean true if data is correct
     */
    public static function authenticate($conn, $username, $password){
        $sql = "SELECT *
                FROM users
                WHERE username = :username";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

        $stmt->execute();

        if($user = $stmt->fetch()){
            return password_verify($password, $user->password);
        }

    }
    /**
     * Checks username for duplication in db
     * 
     * @param object $conn is Connection to the DB
     * 
     * @return boolean true if username is not taken, null if otherwise
     */
    public static function checkUsername($conn, $username){
        $sql = "SELECT *
        FROM users
        WHERE username = :username";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() === 0){
            return true;
        }
    }
    /**
     * Creates new username in db
     * 
     * @param object $conn is Connection to the DB
     * @param string username
     * @param string password
     * 
     * @return boolean true if data is correct, error if otherwise
     */
    public static function register($conn, $username, $password){
        
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password)
                VALUES (:username, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        if ($stmt->execute()){
            return true;
        }else {
            die($stmt->error . " " . $stmt->errno);
        }
    }
}