<?php

namespace Controllers;

use Models\Post;

class PostController extends Controller {
    
    public function index()
    {
        $this->view->render('index');
    }

    public function list()
    {
        $posts = Post::all();
        $this->view->render('list', compact('posts'));
    }
}