<?php

class User extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTestById($id)
    {
        $sql = "SELECT * FROM test WHERE id=?";
        $result = parent::getSingleResult($sql, $id);
        return $result;
    }

    public function save($nom, $prenom, $email, $password, $group_id)
    {
        $uuid = parent::generateUUID("user");
        $sql = "INSERT INTO user (uuid, nom, prenom, email, password, groupe_id) VALUES (?, ?, ?, ?, ?, ?)";
        parent::setOrDeleteData($sql, array($uuid, $nom, $prenom, $email, $password, $group_id));
    }

    public function getByEmail($email)
    {
        $sql = "SELECT * FROM user WHERE email=?";
        return parent::getSingleResult($sql, $email);
    }

    public function getByUuid($uuid)
    {
        $sql = "SELECT A.*, B.libelle FROM user A JOIN groupe B ON A.groupe_id=B.id WHERE uuid=?";
        return parent::getSingleResult($sql, $uuid);
    }

    public function checkPassword($uuid, $password)
    {
        $sql = "SELECT COUNT(*) AS count FROM user WHERE uuid LIKE ? AND password LIKE ?";
        return parent::getSingleResult($sql, array($uuid, $password))['count'];
    }

    public function updatePassword($password, $uuid)
    {
        $sql = "UPDATE user SET password=? WHERE uuid LIKE ?";
        parent::setOrDeleteData($sql, array($password, $uuid));
    }

    public function getConnexion($email, $password)
    {
        $sql = "SELECT *, COUNT(*) AS count FROM USER WHERE email=? and password=?";
        return parent::getSingleResult($sql, array($email, $password));
    }

    public function update($password, $id)
    {
        $sql = "UPDATE user SET password = ? WHERE id = ?";
        parent::setOrDeleteData($sql, array($password, $id));
    }

    public function getAll($offset, $results_per_page)
    {
        $offset = is_int($offset) ? $offset : 0;
        $results_per_page = is_int($results_per_page) ? $results_per_page : 10;
        $sql = "SELECT * FROM user LIMIT $offset, $results_per_page";
        return parent::getResults($sql);
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) AS count FROM user";
        return parent::getSingleResult($sql);
    }

    public function isUnique($column, $value)
    {
        $sql = "SELECT COUNT(*) as count FROM user WHERE $column = '" . $value . "'";
        $count = parent::getSingleResult($sql);
        return ($count['count'] == 0) ? true : false;
    }

    public function delete($uuid)
    {
        $sql = "DELETE FROM user WHERE uuid=?";
        parent::setOrDeleteData($sql, $uuid);
    }

    public function search($key)
    {
        $sql = "SELECT * FROM user WHERE nom LIKE ? OR prenom LIKE ?";
        return parent::getResults($sql, array($key . "%", $key . "%"));
    }

    public function getUsers()
    {
        $sql = "SELECT id, CONCAT(prenom,' ',nom) AS user FROM user";
        return parent::getResults($sql);
    }
}
