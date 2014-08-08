<?php

/**
 * Created by PhpStorm.
 * User: Nguyen
 * Date: 7/18/14
 * Time: 11:13 AM
 */
class Map extends Controller
{
    public function index()
    {
        $users_model = $this->loadModel('usersmodel');
        $userLogged = $users_model->checkUserLogged();
        if (isset($_GET['id'])) {
            $placeId = $_GET['id'];
        } else {
            $placeId = -1;
        }
        $this->render('map/index', array('userLogged' => $userLogged, 'placeId' =>$placeId));
    }

    public function getLocationById()
    {
        $id = $_POST['id'];
        $locations_model = $this->loadModel('locationsmodel');
        echo $locations_model->getLocationById($id);
    }
}