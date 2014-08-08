<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        $articles_model = $this->loadModel('articlesmodel');
        $newArticles = $articles_model->getSomeArticles(0, 2, 6);

        $activities_model = $this->loadModel('ActivitiesModel');
        $activities = $activities_model->getSomeActivities(0, 0, 3, 6);
        $newActivities = $activities_model->getSomeActivities(0, 0, 5, 8);
        $upcomingActivities = $activities_model->getSomeActivities(0, 0, 1, 8);
        $hotActivities = $activities_model->getSomeActivities(0, 0, 6, 8);

        /*$comments_model = $this->loadModel('commentsmodel');
        $comments = $comments_model->getSomeComments(2, 2, 1, 3);*/

        $places_model = $this->loadModel('PlacesModel');
        $newPlaces = $places_model->getSomePlaces(5, 8);
        $hotPlaces = $places_model->getSomePlaces(2, 8);
        $focusPlaces = $places_model->getSomePlaces(6, 8);

        $entries_model = $this->loadModel('entriesmodel');
        $newEntries = $entries_model->getNewEntry(5);

        $users_model = $this->loadModel('usersmodel');
        $userLogged = $users_model->checkUserLogged();
        $newUsers = $users_model->getNewUsers();
	    // render the view, pass the data
        $this->render('home/index', array(
            'newArticles' => $newArticles,
            'activities' => $activities,
            'newActivities' => $newActivities,
            'upcomingActivities' => $upcomingActivities,
            'hotActivities' => $hotActivities,
            'newPlaces' => $newPlaces,
            'hotPlaces' => $hotPlaces,
            'focusPlaces' => $focusPlaces,
            'newUsers' => $newUsers,
            'newEntries' =>$newEntries,
            'userLogged' => $userLogged));
	}
}
