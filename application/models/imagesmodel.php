<?php

/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 7/17/14
 * Time: 3:39 PM
 */
class ImagesModel
{
    public function __construct($db)
    {
        try {
            $this->db = $db;
        } catch
        (PDOException $e) {
            exit ("Database is not established!");
        }
    }

    /**Insert vao table images 1 image moi
     * @param $creatorId
     * @param $caption
     * @param $imageUrl
     * @return int tra ve 1 neu insert thanh cong va tra ve 0 neu nguoc lai
     */
    public function addOneImage($creatorId, $caption, $imageUrl)
    {
        if (isset($creatorId) && isset($caption) && isset($imageUrl)) {
            $sql = "INSERT INTO images (creatorId, caption, imageUrl) VALUES('$creatorId', '$caption', '$imageUrl')";
            if (!($query = $this->db->prepare($sql))) {
                return 0;
            } else {
                $query->execute();
                return 1;
            }
        }
    }

    /**
     * Ham lay tat ca cac image thuoc album co $id
     * @param $id
     * @return int Tra ve mang chua cac image thuoc album hoac tra ve 0 neu
     * album khong ton tai hoac khong chua bat ki anh nao
     */
    public function getImagesOfAlbum($id)
    {
        $sql = "SELECT * FROM images WHERE id IN (SELECT imageId FROM albumdetail WHERE albumId = $id)";
        $query = $this->db->prepare($sql);
        if (!$query) {
            return 0;
        } else {
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

    }
}