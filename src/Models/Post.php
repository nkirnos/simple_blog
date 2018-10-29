<?php
namespace Models;



class Post extends MysqlModel
{
    protected $fillable_fields = ['title', 'updated_at', 'html', 'img_path'];



}