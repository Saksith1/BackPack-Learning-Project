<?php

namespace App\Http\Controllers\MobileApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\PostRequest;
use App\Models\CategoryPost;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Models\Post;

use App\Http\Resources\PostResource;
use PhpParser\Node\Expr\FuncCall;


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
    public function postsByCagegory($id){
        
        $posts = Category::find($id)->posts()->paginate(6);
        return PostResource::collection($posts);
    }
    public function postsTopHomePage() {
        $posts = Post::where('location',0)->get();
        return PostResource::collection($posts);
    }


}
