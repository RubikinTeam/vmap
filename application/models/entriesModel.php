<?php
/**
 * Created by PhpStorm.
 * User: DUONG_TRUC
 * Date: 8/5/14
 * Time: 11:18 PM
 */
class EntriesModel extends Controller
{
    public function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit("Database couldn't established");
        }
    }
    public function getNewEntry($quantity) {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT u.id AS userId, CONCAT(u.fname, ' ',u.lname) AS fullname, u.office, e.*, i.imageUrl FROM entry e LEFT JOIN `user` u ON e.userId = u.id LEFT JOIN images i ON u.avatarId = i.id ORDER BY e.date DESC LIMIT $quantity ";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}