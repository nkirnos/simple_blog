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

    public function new()
    {
        $post = new Post;

        $this->view->render('edit', compact('post'));
    }

    public function store()
    {
        print_r($_REQUEST);
        print_r($_FILES);
    }
}