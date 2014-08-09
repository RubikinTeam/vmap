<?php
/**
 * Created by PhpStorm.
 * User: DUONG_TRUC
 * Date: 8/7/14
 * Time: 1:06 AM
 */
class commentsModel {
    public function __construct(PDO $db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit("Database couldn't established");
        }
    }
    public function addComment($type, $id, $comment, $name, $office) {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        switch ($type) {
            case 1:
                $sql = "INSERT INTO articleComments(articleId";
                break;
            case 2:
                $sql = "INSERT INTO placeComments(placeId";
                break;
            case 3:
                $sql = "INSERT INTO activityComments(activityId";
                break;
        }
        $sql .= ", `content`, `name`, `office`) VALUES ($id, '$comment', '$name', '$office')";
        $query = $this->db->prepare($sql);
        $query->execute();
    }
    public function getComments($type, $id){
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT * FROM ";
        switch ($type) {
            case 1:
                $sql .= "articleComments WHERE articleId";
                break;
            case 2:
                $sql .= "placeComments WHERE placeId";
                break;
            case 3:
                $sql .= "activityComments WHERE activityId";
                break;
        }
        $sql .= "  = $id ORDER BY `date` DESC";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}