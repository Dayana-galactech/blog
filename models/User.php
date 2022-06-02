<?php

use Models\BaseModel;
use Utility\Database;

require_once './utility/Database.php';

class User extends BaseModel
{

    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database;
    }

    public function register($data)
    {
        return self::create($data);
    }

    public function getID($email)
    {
        $query = "SELECT userID FROM users WHERE email=?";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        $data = $stmt->fetchAll();
        foreach ($data as $userid) {
            $userID = htmlspecialchars($userid->userID);
        }
        return $userID;
    }


    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');

        //Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        $hashedPassword = $row->password;

        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    function getTableName()
    {
        return 'users';
    }
}
