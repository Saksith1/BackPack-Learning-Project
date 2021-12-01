<?php 
namespace App\Repositories;

use App\Http\Requests\Api\PostRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Mime\Encoder\Base64Encoder;


class Repository implements RepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {  
        // dd($request->all());
        $record = $this->model->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }
    //create user
    public function create_user(array $data)
    {
        $post=$this->model->create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
            'password'=>bcrypt($data['password']),
        ]);
        return response()->json($post,200);
    }
    //register
    public function register_user(array $data){
        if($data['password_confirmation'] == $data['password']){
            $post=$this->model->create([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'phone'=>$data['phone'],
                'password'=>bcrypt($data['password']),
            ]);
            return response()->json($post,200);
        }
        else{
            return response()->json('password not matched',200);
        }
    }
    //upload post with image
    public function store_post(array $data){
        $imageName = md5($data['image'].time()).'.jpg';
        $image = str_replace('data:image/png;base64,', '',  $data['image']);
        Storage::disk('stores')->put($imageName, base64_decode($image));
        $data['image'] = $imageName;

        $post = $this->model->create($data);
        //
        $post->categories()->attach($data['category_id']);
        return $post;
    }
    //update post with image
    public function update_post(array $data,$id){
        //if select img
        if(isset($data['image'])){
            $record = $this->model->find($id);
            //img name
            $imageName=md5($data['image'].time()).'.jpg';
            //replace img
            $image=str_replace('data:image/png;base64,','',$data['image']);
            //move to local storage with base 64
            Storage::disk('stores')->put($imageName,base64_decode($image));
            $data['image']=$imageName;
            //delete old image
            $image_path = public_path('images/'.$record->image);
            if(\File::exists($image_path)){
                \File::delete($image_path);
            }
            return $record->update($data);
        }
        //none select img
        else{
            //find old img
            $image_old=$this->model::find($id);
            //assign old img to image
            $data['image']=$image_old['image'];
            $record = $this->model->find($id);
            return $record->update($data);
        }
    }
}