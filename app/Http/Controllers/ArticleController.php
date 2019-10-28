<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articles;

class ArticleController extends Controller
{
    public function index()
    {
        return Articles::orderBy('id', 'DESC')->get();
    }

    public function show(Articles $article)
    {
        return $article;
    }

    public function store(Request $request)
    {
        $article = Articles::create($request->all());

        return response()->json($article, 201);
    }

    public function update(Request $request, Articles $article)
    {
        $article->update($request->all());

        return response()->json($article, 200);
    }

    public function delete(Articles $article)
    {
        $article->delete();

        return response()->json(null, 204);
    }
}
