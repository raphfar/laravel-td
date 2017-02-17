<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show', 'index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::paginate(10);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'title' => 'required|min:5',
                'content' => 'required|min:10'
            ],
            [
                'title.required' => 'Titre requis',
                'title.min' => 'Minimum 5 caractères',

                'content.required' => 'Contenu requis',
                'content.min' => 'Minimum 10 caractères'
            ]);

        $article = new Article();
        $input = $request->input();
        $input['user_id'] = Auth::user()->id;

        $article
            ->fill($input)
            ->save();

        return redirect()->route('article.index')->with('success', 'L\'article a bien été publié');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                'title' => 'required|min:5',
                'content' => 'required|min:10'
            ],
            [
                'title.required' => 'Titre requis',
                'title.min' => 'Minimum 5 caractères',

                'content.required' => 'Contenu requis',
                'content.min' => 'Minimum 10 caractères'
            ]);

        $article = Article::find($id);
        $input = $request->input();

        $article
            ->fill($input)
            ->save();

        return redirect()->route('article.index')->with('success', 'L\'article a bien été modifié');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();

        return redirect()->route('article.index')->with('success', 'L\'article a bien été supprimé');
    }
}
