<?php

class AddressModel
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
    public function getAllCities() {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT * FROM address_city";
        $query = $this->db->prepare($sql);
        $query->execute();
        return json_encode($query->fetchAll());
    }
    public function getAllDist($cityId) {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT id, districtName FROM address_dist WHERE cityId = $cityId";
        $query = $this->db->prepare($sql);
        $query->execute();
        return json_encode($query->fetchAll());
    }
    public function getAllWard($cityId, $distId) {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "SELECT id, wardName FROM address_ward WHERE cityId = $cityId AND districtId = $distId";
        $query = $this->db->prepare($sql);
        $query->execute();
        return json_encode($query->fetchAll());
    }
    public function addAddress($no, $street, $ward, $dist, $city) {
        $query = $this->db->prepare("SET NAMES 'UTF8'");
        $query->execute();
        $sql = "INSERT INTO  address(no, street, wardId, distId, cityId) VALUES('$no', '$street', '$ward', '$dist', '$city')";
        $query = $this->db->prepare($sql);
        if ($query->execute()) {
            $query = $this->db->prepare('SELECT MAX(id) AS addressId FROM address');
            $query->execute();
            $result = ($query->fetch(PDO::FETCH_OBJ));
            return (string)$result->addressId;
        }
        else {
            return 0;
        }
    }
}