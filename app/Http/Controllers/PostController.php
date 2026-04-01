<?php

namespace App\Http\Controllers;

use App\Models\Post; // Importante: avisamos o PHP que vamos usar o modelo Post
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // Pegamos todos os registros da tabela 'posts' no SQLite
        $posts = Post::all();

        // Enviamos esses dados para a view chamada 'home' 
        // dentro da variável 'posts'
        return view('home', ['posts' => $posts]);
    }
}