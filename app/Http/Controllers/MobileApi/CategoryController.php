<?php

namespace App\Http\Controllers\MobileApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\Repository;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $model;

    public function __construct(Category $post)
    {
        // set the model
        $this->model = new Repository($post);
    }

    public function index()
    {
        return $this->model
        ->getModel()
        ->orderBy('id', 'desc')->get();
    }

    public function store(CategoryRequest $request)
    {
    
        return $this->model->create($request->all());
    }

    public function show($id)
    {
        return $this->model->show($id);
    }

    public function update(CategoryRequest $request, $id)
    {
        return $this->model->update($request->all(), $id);

    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }
}
