<?php

/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 7/20/14
 * Time: 10:20 AM
 */
class LocationsModel
{
    public function __construct(PDO $db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit("Database couldn't established");
        }
    }

    public function getLocationById($id)
    {
        $sql = "SELECT v.id, `name`, `email`, `website`, `phone`, `no`, `street`,`ward`, `dist`, `city`, `lat`, `long`, `imageUrl` FROM v_place v JOIN address a ON v.addressId = a.id JOIN location l ON v.locationId = l.id JOIN images i on v.thumbnailImageId = i.id";
        if ($id != 0)
            $sql .= " WHERE v.id = $id";
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $query = $this->db->prepare($sql);
        $query->execute();
        return json_encode($query->fetchAll());
    }
}