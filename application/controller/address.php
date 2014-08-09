<?php

class Address extends Controller
{
    public function index() {
        header("location: ".URL);
    }
    public function getAllCities()
    {
        $address_model = $this->loadModel('addressmodel');
        echo $address_model->getAllCities();
    }
    public function getAllDist()
    {
        $cityId = $_POST['cityId'];
        $address_model = $this->loadModel('addressmodel');
        echo $address_model->getAllDist($cityId);
    }
    public function getAllWard()
    {
        $cityId = $_POST['cityId'];
        $distId = $_POST['distId'];
        $address_model = $this->loadModel('addressmodel');
        echo $address_model->getAllWard($cityId, $distId);
    }
}