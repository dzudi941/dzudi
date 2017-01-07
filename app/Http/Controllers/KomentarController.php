<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Kometar;
use App\Settings;
use App\Phone;
use App\Comments;
use App\User;

class KomentarController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

    	//$product=Settings::all()->sortByDesc("id");;
            $comments=Comments::all()->sortByDesc("id");
            /*foreach (Comments::with('BelongsToUser')->get() as $child)
                    {
                        //echo $book->author->name;
                        $comments=$child->BelongsToUser;
                    }*/
                    //$com=Comments::find(76)->HasComments()->get();
                    $lengthCom=count($comments);
    	//return $product;
    	return view('komentar.index')->with('comments', $comments);
        }
        else
        {
            return view('auth.login');
        }
    }

    public function create()
    {
    	
    }

    public function store(Request $request)
    {
       /* $set=new Settings(['name' => 'mare', 'email' => 'some@email.com']);
    	//$inputs=$request->all();
        $name=$request->name;
    	//$kom=Kometar::Create(['name' => 'Some Name', 'email' => 'some@email.com']);
        $mare=Settings::Create(['name' => $name, 'email' => 'some@email.com']);

        //$act=new Settings();
        $phone = new Settings(['name' => 'testIme', 'email' => '98765432']);
        $phone= new Phone (['code' => 961, 'number' => '98765432']);
        $relation = $mare->phone()->save($phone);*/
        if ($request->has('komentar')) {
            
        $LogUser=$request->user();
        $komentar=$request->komentar;
        $comm=Comments::Create(['comment' => $komentar, 'likes' => 0, 'dislikes' => 0]);
        $LogUser->HasComment()->save($comm);
        //$comm->BelongsToUser()->attach($LogUser);
        }
        elseif ($request->has('odgovor')) {
            $LogUser=$request->user();
            $komentar=$request->odgovor;
            $id=$request->idComment;
            $parentComm=Comments::find($id);
            $com=Comments::Create(['comment' => $komentar, 'likes' => 0, 'dislikes' => 0]);
            $parentComm->HasComments()->save($com);
            $LogUser->HasComment()->save($com);
        }


        return redirect()->route('komentar.index');

    }
    public function store1(Request $request)
    {
       


        return redirect()->route('komentar.index');

    }

    public function show($id)
    {
      
    }

    public function edit($id)
    {
       
    }
    public function update(Request $request, $id)
    {
        
    }


    public function destroy($id)
    {
       
    }
    public function addLikes(Request $request)
    {
        $LogUser=$request->user();
        //$request->input('ramo')
        $id= $request->input('id');
        $likes= $request->input('likes');
        $likes = $likes+1;
        $comm=Comments::find($id);
        $comm->likes=$likes;
        $comm->save();
        $LogUser->HasLike()->save($comm);

        if($request->ajax()){
            return response()->json([
                'likes' => $likes
            ]);
        }
    }
    public function deleteLikes(Request $request)
    {
        $LogUser=$request->user();
        //$request->input('ramo')
        $id= $request->input('id');
        $likes= $request->input('likes');
        $likes = $likes-1;
        $comm=Comments::find($id);
        $comm->likes=$likes;
        $comm->save();
        $relation=$LogUser->HasLike()->edge($comm);
        
        $relation->delete();
        
        //$LogUser->HasLike()->drop($comm);

        if($request->ajax()){
            return response()->json([
                'likes' => $likes
            ]);
        }
    }
    public function addDisLikes(Request $request)
    {
        $LogUser=$request->user();
        //$request->input('ramo')
        $id= $request->input('id');
        $dislikes= $request->input('dislikes');
        $dislikes = $dislikes+1;
        $comm=Comments::find($id);
        $comm->dislikes=$dislikes;
        $comm->save();
        $LogUser->HasDisLike()->save($comm);

        if($request->ajax()){
            return response()->json([
                'dislikes' => $dislikes
            ]);
        }
    }
    public function deleteDisLikes(Request $request)
    {
        $LogUser=$request->user();
        //$request->input('ramo')
        $id= $request->input('id');
        $dislikes= $request->input('dislikes');
        $dislikes = $dislikes-1;
        $comm=Comments::find($id);
        $comm->dislikes=$dislikes;
        $comm->save();
        //$LogUser->HasDisLike()->save($comm);
        $relation=$LogUser->HasDisLike()->edge($comm);
        
        $relation->delete();

        if($request->ajax()){
            return response()->json([
                'dislikes' => $dislikes
            ]);
        }
    }

    public function najboljeOcenjeni()
    {
        if (Auth::check()) {
            $comments=Comments::all()->sortByDesc("likes");
            return view('komentar.index')->with('comments', $comments);
        }
        else
        {
            return view('auth.login');
        }
    }
}
