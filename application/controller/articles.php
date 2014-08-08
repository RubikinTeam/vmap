<?php
/**
 * Created by PhpStorm.
 * User: Duyen
 * Date: 7/19/14
 * Time: 3:17 PM
 */

class Articles extends Controller
{
    public function index()
    {
        $articles_model = $this->loadModel('ArticlesModel');
        $articles = $articles_model->getSomeArticles(0, 2, 6);

        $users_model = $this->loadModel('usersmodel');
        $userLogged = $users_model->checkUserLogged();

        $this->render('articles/index', array('articles' => $articles, 'userLogged' => $userLogged));
    }

    public function detail($id)
    {
        $users_model = $this->loadModel('usersmodel');
        $userLogged = $users_model->checkUserLogged();
        $articles_model = $this->loadModel('ArticlesModel');
        $article = $articles_model->getArticleById($id);

        $otherArticles = $articles_model->getSomeArticles(0, 2, 0);

        $comments_model = $this->loadModel('commentsmodel');
        $comments = $comments_model->getComments(1, $id);

        $this->render('articles/detail', array('article' => $article, 'comments' => $comments, 'otherArticles' => $otherArticles, 'userLogged' => $userLogged));
    }
    public function getComments() {
        $id = $_POST['id'];
        $comments_model = $this->loadModel('commentsmodel');
         echo json_encode($comments_model->getComments(1, $id));
    }
    public function addComment() {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $comment = $_POST['comment'];
        $office = $_POST['office'];
        $comments_model = $this->loadModel('commentsmodel');
        $comments_model->addComment(1, $id, $comment, $name, $office);
    }
}