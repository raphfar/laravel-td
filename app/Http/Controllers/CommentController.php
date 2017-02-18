<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CommentController extends Controller
{

    public function admin() {
        $comments = Comment::all();
        return view('comments.admin', compact('comments'));
    }

    public function delete($id) {
        $comments = Comment::find($id);
        $comments->delete();
        return redirect()->back()->with('success', 'Commentaire supprimé');
    }

    public function update(Request $request, $id) {
        $comment = Comment::find($id);

            $comment->content = $request->content;
            $comment->save();

        return redirect()->route('comments.admin', [$comment->id])->with('success', 'Commentaire modifié');
    }


    public function create($id) {

        $article = Article::find($id);
        $inputs = Input::all();

        Comment::create([
            'user_id' => Auth::user()->id,
            'article_id' => $article->id,
            'content' => $inputs['comment'],
        ]);
        return redirect()->route('article.show', [$article->id])->with('success', 'Commentaire ajouté');
    }
}
