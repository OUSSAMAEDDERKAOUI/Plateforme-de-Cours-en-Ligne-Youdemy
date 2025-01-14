<?php

abstract class Users{

protected $userId;
protected $fName;
protected $lName;
protected $email;
protected $password;
protected $role;


public function __construct($fName,$lName,$email,$role){
    $this->fName=$fName;
    $this->lName=$lName;
    $this->email=$email;
    $this->role=$role;
}

// -------------------Getters-------------------------

public function getidUser(){
    return $this->userId;
}
public function getfName(){
    return $this->fName;
}
public function getlName(){
    return $this->lName;
}
public function getEmail(){
    return $this->email;
}
public function getpassword(){
    return $this->password;
}
public function getRole(){
    return $this->role;
}


// -------------------Setters-------------------------

public function setfName($fName){
    $this->fName=$fName;
}

public function setlName($lName){
    $this->lName=$lName;
}
public function setemail($email){
    $this->email=$email;
}
public function setpassword($password){
    $this->password=$password;
}
public function setRole($role){
    $this->role =$role;
}












}















?>