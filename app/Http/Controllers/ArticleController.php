<?php
namespace App\Http\Controllers;
use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('id', 'DESC')->paginate(5);
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
                'title' => 'required|min:3',
                'content' => 'required|min:10',
                'picture' => 'required',
            ],
            [
                'title.required' => 'Un titre est requis',
                'content.required' => 'Un contenu est requis'
            ]);
        $articlePicture = $request->file('picture');
        $extension = Input::file('picture')->getClientOriginalExtension();
        $filename = rand(111, 999) . '.' . $extension;
        Image::make($articlePicture)->save(public_path('/uploads/' . $filename));
        $article = new Article;
        $input = $request->input();
        $input['user_id'] = Auth::user()->id;
        $input['picture'] = $filename;
        $article->fill($input)->save();
        return redirect()->route('article.index')
            ->with('success', 'L\'article a bien été publié !');
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
        $comments = Comment::all();
        $comment = Comment::find($id);
        return view('articles.show', compact('article', 'comments', 'comment'));
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
        $this->validate($request, [
            'title' => 'required|min:3',
            'content' => 'required|min:10',
        ],
            [
                'title.required' => 'Le titre est requis',
                'content.required' => 'Le contenu est requis'
            ]);
        $article = Article::find($id);
        $input = $request->input();
        $article->fill($input)->save();
        return redirect()->route('article.show', compact('id'))
            ->with('success', 'L\'article a bien été modifié !');
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
        return redirect()->route('article.index')
            ->with('success', 'L\'article a bien été supprimé !');
    }
}