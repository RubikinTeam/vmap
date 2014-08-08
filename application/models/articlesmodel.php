<?php

/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 7/16/14
 * Time: 10:17 PM
 */
class ArticlesModel
{
    public function __construct(PDO $db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit("Database couldn't established");
        }
    }

    /**
     * Ham tra ve mot mang cac article theo mot so tieu chuan nhat dinh
     *      * @param $status
     *      = 1 : articles da duoc duyet
     *      = 2 : articles chua duyet
     *      = 0: khong rang buoc ve trang thai
     * @param $condition:
     *      = 1 : theo thoi gian tu xa den gan
     *      = 2 : theo thoi gian tu gan den xa
     *      = 3 : theo luong like tu it den nhieu
     *      = 4 : theo luong like tu nhieu den it
     *      = 0: Khong order
     * @param $quantity
     *      = 0 neu muon lay tat ca
     *      = n (n > 0): Lay n articles dau tien
     * @return mixed
     */
    public function getSomeArticles($status, $condition, $quantity)
    {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT a.*, i.imageUrl, COUNT(ac.id) AS commentTotal FROM articles a
        LEFT JOIN images i ON a.thumbnailImageId = i.id
        LEFT JOIN articleComments ac ON a.id = ac.articleId
        GROUP BY a.id";
        switch ($status) {
            case 1:
                $sql .= " WHERE status = 1 ";
                break;
            case 2:
                $sql .= " WHERE status = 2 ";
                break;
            case 0:
                break;
            default:
                break;
        }
        switch ($condition) {
            case 1:
                $sql .= " ORDER BY `date` ASC ";
                break;
            case 2:
                $sql .= " ORDER BY `date` DESC ";
                break;
            case 3:
                $sql .= " ORDER BY `like` ASC ";
                break;
            case 4:
                $sql .= " ORDER BY `like` DESC ";
                break;
            case 0:
                break;
            default:
                break;
        }
        if ($quantity > 0) {
            $sql .= " LIMIT $quantity";
        }
        //echo $sql ."</br>"; //If you wanna show sql statement, let's uncomment this line
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getArticleById($id)
    {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT a.*, CONCAT(u.fname, ' ', u.lname) AS author, i.imageUrl
        FROM articles a LEFT JOIN `user` u ON a.authorId = u.id
        LEFT JOIN images i ON a.thumbnailImageId = i.id
        WHERE a.id = $id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function searchArticle($str)
    {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT a.id, a.title, i.imageUrl FROM articles a JOIN images i ON a.thumbnailImageId = i.id WHERE a.titleASCII LIKE '$str' LIMIT 2";
        $query = $this->db->prepare($sql);
        $query->execute();
        return json_encode($query->fetchAll());
    }

}