<?php

namespace App\Http\Controllers\MobileApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\TrainerRequest;
use Illuminate\Http\Request;
use App\Models\Trainer;
use App\Repositories\Repository;

class TrainerController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Trainer $post)
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

    public function store(TrainerRequest $request)
    {

        return $this->model->create($request->all());
    }

    public function show($id)
    {
        return $this->model->show($id);
    }

    public function update(TrainerRequest $request, $id)
    
    {
        $trainer =  $this->model->update($request->all(), $id);
        return response()->json($trainer);


    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }
}
