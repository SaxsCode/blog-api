<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();

        return response()->json(['articles' => $articles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateFields($request);
        $article = Article::create($data);

        return response()->json(['article' => $article], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return response()->json(['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $data = $this->validateFields($request, true);
        $article->update($data);

        return response()->json(['article' => $article]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }

    private function validateFields(Request $request, bool $partial = false): array
    {
        $ruleModifier = $partial ? 'sometimes' : 'required';

        $rules = [
            'title' => [$ruleModifier, 'string', 'max:255'],
            'author' => [$ruleModifier, 'string', 'max:255'],
            'content' => [$ruleModifier, 'string', 'min:25', 'max:255'],
        ];

        return $request->validate($rules);
    }
}
