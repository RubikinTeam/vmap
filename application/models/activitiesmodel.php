<?php

/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 7/17/14
 * Time: 9:39 AM
 */
class ActivitiesModel
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
     * Ham tra ve mot mang cac activity theo mot so tieu chuan nhat dinh
     * @param: $type
     *      = 0 : Tat ca
     *      = n > 0: Cac loai hoat dong
     * @param $status
     *      = 1 : activities da duoc duyet
     *      = 2 : activities chua duyet
     *      = 0: khong rang buoc ve trang thai
     * @param $condition :
     *      = 1 : theo thoi gian tu xa den gan
     *      = 2 : theo thoi gian tu gan den xa
     *      = 3 : theo luong like tu it den nhieu
     *      = 4 : theo luong like tu nhieu den it
     *      = 0: Khong order
     * @param $quantity
     *      = 0 neu muon lay tat ca
     *      = n (n > 0): Lay n activities dau tien
     * @return mixed
     */
    public function getSomeActivities($type, $status, $condition, $quantity)
    {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT a.*, i.imageUrl, v.`name` AS vplaceName, COUNT(ac.id) AS commentTotal FROM activities a
        LEFT JOIN images i ON a.thumbnailImageId = i.id
        LEFT JOIN v_place v ON a.placeId = v.id
        LEFT JOIN activityComments ac ON a.id = ac.activityId GROUP BY a.id";
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
        if ($type > 0) {
            $sql .= " AND `type` = $type ";
        }
        switch ($condition) {
            case 1:
                $sql .= " ORDER BY (startday - NOW()) ASC ";
                break;
            case 2:
                $sql .= " ORDER BY (startday - NOW()) DESC ";
                break;
            case 3:
                $sql .= " ORDER BY `rating` ASC ";
                break;
            case 4:
                $sql .= " ORDER BY `rating` DESC ";
                break;
            case 5:
                $sql .= " ORDER BY `createDate` DESC ";
                break;
            case 6:
                $sql .= " ORDER BY `commentTotal` DESC ";
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

    public function getActivityShortDesByType($type)
    {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT a.`id` AS activityId, a.`name` AS activityName, a.startday, a.endday,
        v.id AS placeId, v.`name` AS placeName,
        l.lat, l.long FROM activities a JOIN v_place v
        ON a.vplaceId = v.id JOIN location l ON a.locationId = l.id";
        if ($type > 0) {
            $sql .= " WHERE a.type = $type";
        }
        $query = $this->db->prepare($sql);
        $query->execute();
        return json_encode($query->fetchAll());
    }

    public function searchActivity($str)
    {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT a.id, a.`name`, i.imageUrl FROM activities a JOIN images i ON a.thumbnailImageId = i.id WHERE a.nameASCII LIKE '$str' LIMIT 2";
        $query = $this->db->prepare($sql);
        $query->execute();
        return json_encode($query->fetchAll());
    }

    function getActivityById($id)
    {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT a.*, i.imageUrl FROM activities a LEFT JOIN images i
         ON a.thumbnailImageId = i.id
         WHERE a.id = $id";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function takePart($userId, $activityId)
    {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $query = $this->db->prepare("SELECT userId FROM takepart WHERE userId = $userId AND activityId = $activityId");
        $query->execute();
        if (is_null($query->fetch(PDO::FETCH_OBJ))) {
            $sql = "INSERT INTO takepart(userId, activityId) VALUES($userId, $activityId)";
            $query = $this->db->prepare($sql);
            $query->execute();
            return 1;
        } else {
            return 0;
        }
    }
    public function addShare($id, $type) {
        $sql = "UPDATE activities SET ";
        if ($type == 1)
            $sql .= "FBShare = FBShare + 1";
        else
            $sql .= "GPlusShare = GPlusShare + 1";
        $sql .= " WHERE id = $id";
        var_dump($sql);
        $query = $this->db->prepare($sql);
        $query->execute();
    }
}