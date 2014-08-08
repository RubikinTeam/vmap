<?php
/**
 * Created by PhpStorm.
 * User: DUONG_TRUC
 * Date: 8/7/14
 * Time: 10:39 AM
 */
class Admin extends Controller
{
    public function index()
    {

        $users_model = $this->loadModel('usersmodel');
        $userLogged = $users_model->checkUserLogged();
        if ($userLogged && $userLogged['groupId'] == 2){
            $this->render('admin/index', array('userLogged' => $userLogged));
        }
        else {
            header('location: '.URL);
        }

    }
    public function addLocation() {
        $this->render('admin/addLocation');
    }
}