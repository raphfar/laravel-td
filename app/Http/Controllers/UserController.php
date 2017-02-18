<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    public function update(Request $request, $id) {
        $comment = Comment::find($id);

        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('users.index', [$comment->id])->with('success', 'Commentaire modifié');
    }

}
