<?php

namespace App\Http\Controllers\MobileApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\PostRequest;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Models\Post;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    // space that we can use the repository from
    protected $model;

    public function __construct(Post $post)
    {
        // set the model
        $this->model = new Repository($post);
    }

    public function index()
    {
        $post = $this->model->getModel()->paginate(10);
        return PostResource::collection($post);
    }

    public function store(PostRequest $request)
    {
    
        $post=$this->model->store_post($request->all());
        return response()->json($post);
    }

    public function show($id)
    {
       $post=$this->model->show($id);
       return response()->json($post);
    }

    public function update(PostRequest $request, $id)
    {
       $post = $this->model->update_post($request->all(), $id);
       return response()->json($post);

    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }
}
