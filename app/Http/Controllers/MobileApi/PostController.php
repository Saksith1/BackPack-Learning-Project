<?php

namespace App\Http\Controllers\MobileApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $posts=Post::all();
    //     return response($posts,200);
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required',
    //         'body' => 'required',
    //     ]);
    //     $post=Post::create([
    //         'title'=>$request->input('title'),
    //         'user_id'=>$request->input('user_id'),
    //         'category_id'=>$request->input('category_id'),
    //         'trainer_id'=>$request->input('trainer_id'),
    //         'body'=>$request->input('body'),
    //         'image'=>$request->input('image')
    //     ]);
    //     return response($post,200);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'title'=>'required',
    //         'user_id'=>'required',
    //         'category_id'=>'required',
    //         'trainer_id'=>'required',
    //         'body'=>'required',
    //         'image'=>'required'
    //     ]);
    //     // $post=Post::where('id',$id)->update($data,$id);
    //     $post=Post::find($id)->update([
    //         'title'=>$request->input('title'),
    //         'user_id'=>$request->input('user_id'),
    //         'category_id'=>$request->input('category_id'),
    //         'trainer_id'=>$request->input('trainer_id'),
    //         'body'=>$request->input('body'),
    //         'image'=>$request->input('image')
    //     ]);
    //     return response($post,200);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     Post::find($id)->delete();
    //     return response('Bank id = '.$id.'is deleted',200);
    // }
 // space that we can use the repository from
    protected $model;

    public function __construct(Post $post)
    {
        // set the model
        $this->model = new Repository($post);
    }

    public function index()
    {
        return $this->model
        ->getModel()
        ->all();
        // ->orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
    
        return $this->model->store_post($request->all());
    }

    public function show($id)
    {
        return $this->model->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->model->update_post($request->all(), $id);

    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }
}
