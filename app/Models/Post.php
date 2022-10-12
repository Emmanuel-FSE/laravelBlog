<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Post
{
    public $title;

    public $excerpt;

    public $date;

    public $body;

    public function __construct($title, $excerpt, $date, $body)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
    }

    public static function all(){
        $files = File::files(resource_path("posts/"));

        return array_map(function($file){
            return $file->getContents();
        }, $files);
    }
    
    public static function find($slug){
    $path = resource_path("posts/{$slug}.html");
    if(!file_exists($path)){
        abort(404);
    }
    return cache()->remember("posts.{$slug}", 1200, function() use($path){
        return file_get_contents($path);
    });
    }
}
