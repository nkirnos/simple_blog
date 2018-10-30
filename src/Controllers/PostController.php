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
        
        $post = new Post;
        $post->id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
        $post->title = isset($_REQUEST['title']) ? $_REQUEST['title'] : null;
        $post->img_path = isset($_REQUEST['url']) ? $_REQUEST['url'] : null;
        $post->html = isset($_REQUEST['html']) ? $_REQUEST['html'] : null;
        $post->save();

        if(!empty($_FILES)) {
            $upload_dir = BASE_DIR . '/public/uploads';
            $post_upload_dir = $upload_dir . sprintf('/%s', $post->id);
            $upload_path = $post_upload_dir . '/' . basename($_FILES['file']['name']);
            if(!is_dir($post_upload_dir)) {
                mkdir($post_upload_dir, 0777, true);
            }
            if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
                $post->img_path = sprintf('/uploads/%s/%s', $post->id, basename($_FILES['file']['name']));
            }
            $post->save();
        }
        header('Content-Type: application/json');
        echo json_encode($post->toArray());
    }

    public function delete()
    {
        if(array_key_exists('id', $_REQUEST))
        {
            $id = $_REQUEST['id'];
            $post = new Post;
            $post->retrieve($id);
            $post->remove();
        }
        $this->redirect('/posts');

    }

    public function view()
    {
        if(array_key_exists('id', $_REQUEST))
        {
            $id = $_REQUEST['id'];
            $post = new Post;
            if($post->retrieve($id)) {
                $this->view->render('view', compact('post'));    
            } else {
                $this->redirect('/404');
            }
        } else {
            $this->redirect('/404');
        } 
    }

    public function edit()
    {
        if(array_key_exists('id', $_REQUEST))
        {
            $id = $_REQUEST['id'];
            $post = new Post;
            if($post->retrieve($id)) {
                $this->view->render('edit', compact('post'));    
            } else {
                $this->redirect('/404');
            }
        } else {
            $this->redirect('/404');
        } 
    }
}