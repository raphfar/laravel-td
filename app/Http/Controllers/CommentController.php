<?php
namespace App\Http\Controllers;
use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'content' => 'required|min:10',
            ],
            [
                'content.required' => 'Un contenu est nécessaire !'
            ]);
        $input = $request->input();
        $input['user_id'] = Auth::user()->id;
        $comment = new Comment;
        $comment->fill($input)->save();
        $id = $input['article_id'];
        return redirect()->route('article.show', compact('id'))
            ->with('success', 'Votre commentaire a bien été envoyé !');
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
        $articles = Article::paginate(5);
        $comments = Comment::all();
        $comment = Comment::find($id);
        return view('articles.show', compact('article', 'comments', 'comment', 'articles'));
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
        $comment = Comment::find($id);
        return view('articles.comment', compact('comment', 'article'));
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
            'content' => 'required|min:10',
        ],
            [
                'content.required' => 'Un contenu est requis'
            ]);
        $comment = Comment::find($id);
        $input = $request->input();
        $comment->fill($input)->save();
        $article_id = $request->article_id;
        return redirect()->route('article.show', compact('article_id'))
            ->with('success', 'Vous avez modifié le commentaire  !');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return Redirect::back()
            ->with('success', 'Commentaire supprimé !');
    }
}