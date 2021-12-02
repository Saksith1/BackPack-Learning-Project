<?php

namespace App\Http\Controllers\MobileApi;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\Repository;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $model;

    public function __construct(User $post)
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

    public function store(UserRequest $request)
    {
    
        $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required|email|unique:users',
        ]);
        $user = $this->model->create_user($request->all());
        return response()->json($user);
    }
    
    public function register(Request $request){
        $request->validate([
            'email'=>'required|email|unique:users',
            'password_confirmation'=>'required',
            'password'=>'required',
            'phone'=>'required',
            'name'=>'required|max:255'
        ]);
        return $this->model->register_user($request->all());
    }
    public function loginu(UserRequest $request){
        $user = $this->model->login($request->all());
        return response()->json($user);
    }
    public function show($id)
    {
        return $this->model->show($id);
    }

    public function update(Request $request, $id)
    {
        $this->model->update($request->all(), $id);

    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }
}
