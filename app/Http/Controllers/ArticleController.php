<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::paginate(5);

        return view('articles.index', ['articles' => $articles]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ],
        [
           'content.required' => 'Content obligatoire'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalExtension();
            $location = public_path('images/' . $image->getClientOriginalExtension());
            Image::make($image)->resize(1200, 400)->save($location);
        }

        Article::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'content' => $request->content,
            'image' => public_path('images/' . $image->getClientOriginalExtension())
        ]);




        return redirect()->route('article.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);

        if(!$article) {
            return redirect()->route('article.index');
        }

        $comments = $article->comments;

        return view('articles.show', compact('article', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);

        if(!$article) {
            return redirect()->route('article.index');
        }

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ],
        [
            'content.required' => 'Contenu obligatoire'
        ]);

        $article = Article::find($id);

        $article->title = $request->title;
        $article->content = $request->content;
        $article->save();

        return redirect()->route('article.show', [$article->id])->with('success', 'Article modifié');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        $article->delete();

        return redirect()->route('article.index')->with('success', 'Article supprimé');

    }

    public function isLikedByMe($id)
    {
        $article = Article::findOrFail($id)->first();
        if (Like::whereUserId(Auth::id())->whereArticleId($article->id)->exists()){
            return 'true';
        }
        return 'false';
    }

    public function like(Article $article)
    {
        $existing_like = Like::withTrashed()->wherePostId($article->id)->whereUserId(Auth::id())->first();

        if (is_null($existing_like)) {
            Like::create([
                'post_id' => $article->id,
                'user_id' => Auth::id()
            ]);
        } else {
            if (is_null($existing_like->deleted_at)) {
                $existing_like->delete();
            } else {
                $existing_like->restore();
            }
        }
    }
}
