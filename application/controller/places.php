<?php

/**
 * Created by PhpStorm.
 * User: Duyen
 * Date: 7/24/14
 * Time: 9:57 AM
 */
class Places extends Controller
{
    public function index()
    {
        $places_model = $this->loadModel('PlacesModel');
        $places = $places_model->getSomePlaces(2, 0);

        $users_model = $this->loadModel('usersmodel');
        $userLogged = $users_model->checkUserLogged();
        $this->render('places/index', array('places' => $places, 'userLogged' => $userLogged));
    }

    public function detail($id)
    {
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
        } else {
            $tab = 'info';
        }
        $users_model = $this->loadModel('usersmodel');
        $userLogged = $users_model->checkUserLogged();

        $places_model = $this->loadModel('PlacesModel');
        $place = $places_model->getOnePlace($id);
        $activities = $places_model->getActivities($id);

        $images_model = $this->loadModel('imagesmodel');
        $images = $images_model->getImagesOfAlbum($place->albumId);

        $samePlaces = $places_model->getSamePlaces($place->type);

        $comments_model = $this->loadModel('commentsmodel');
        $comments = $comments_model->getComments(2, $id);

        $this->render('places/detail', array('place' => $place, 'comments' => $comments, 'samePlaces' => $samePlaces, 'userLogged' => $userLogged, 'images' => $images, 'tab' =>$tab, 'activities' =>$activities));
    }

    public function addressUpdate()
    {
        session_start();
        $addressId = $_SESSION['addressId'];
        $field = $_POST['field'];
        $value = $_POST['value'];
        $place_model = $this->loadModel('placesmodel');
        echo $place_model->updateAddress($addressId, $field, $value);
    }
    public function getComments() {
        $id = $_POST['id'];
        $comments_model = $this->loadModel('commentsmodel');
        echo json_encode($comments_model->getComments(2, $id));
    }
    public function addComment() {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $office = $_POST['office'];
        $comments_model = $this->loadModel('commentsmodel');
        $comments_model->addComment(2, $id, $comment, $name, $office);
    }
    public function addPlace() {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $organization = $_POST['organization'];
        $presenter = $_POST['presenter'];
        $no = $_POST['no'];
        $street = $_POST['street'];
        $ward = $_POST['ward'];
        $dist = $_POST['dist'];
        $city = $_POST['city'];
        $phone = $_POST['phone'];
        $description = $_POST['description'];
        $email = $_POST['email'];
        $website = $_POST['website'];
        $place_model = $this->loadModel('placesmodel');
        $address_model = $this->loadModel('locationsmodel');
        $addressId = $address_model->addAddress($no, $street, $ward, $dist, $city);
           echo ($place_model->addOnePlace($name, $type, $organization,$presenter,
            $phone, $description, $email,$website, $addressId));





    }

}