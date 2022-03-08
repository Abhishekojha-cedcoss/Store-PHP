<?php
namespace user;

class User extends DB
{
    public $username;
    public $firstname;
    public $lastname;
    public $password;
    public $email;

    public function __construct($username, $firstname, $lastname, $password, $email)
    {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->email = $email;
    }

    public function addUser()
    {
        try {
                DB::getInstance()->exec("INSERT INTO Users(username,`password`,email,`Status`,
                firstName,lastname) 
                VALUES('$this->username','$this->password','$this->email',
                'pending','$this->firstname','$this->lastname');");
                return "Wait for the admin to accept the request";
        } catch (\Exception $e) {
                return "You are already registered! Please Login";
        }
    }
    public function addUserByAdmin()
    {
        DB::getInstance()->exec("INSERT INTO Users(username,`password`,email,`Status`,firstName,lastname,`role`) 
        VALUES('$this->username','$this->password','$this->email','approved',
        '$this->firstname','$this->lastname','user');");
    }
}
