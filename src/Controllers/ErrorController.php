<?php

namespace Controllers;

class ErrorController extends Controller {
    public function error($text)
    {
        echo $text;
    }
}