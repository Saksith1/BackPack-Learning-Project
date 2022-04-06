<?php 
namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



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
        $record=$this->model->create($data);
        return $record;
    }

    // update record in the database
    public function update(array $data, $id)
    {  
        // dd($request->all());
        $record = $this->model->find($id);
        if($record==null){
            $message = [
                'message' => 'id not found',
                'status' => 400,
            ];
            return $message;
        }
        else{
            $record->update($data);
            $message=[
                'message' => 'updated successfully',
                'record' => $record,
                'status' => 200,
            ];
            return $message;
        }

    }

    // remove record from the database
    public function delete($id)
    {
        $record= $this->model->find($id);
        if($record==null){
            $message = [
                'message' => 'id not found',
                'status' => 400,
            ];
            return $message;
        }
        else{
            $record= $this->model->destroy($id);
            $message=[
                'message' => 'Record id = '.$id." has been deleted successfully",
                'status' => 200,
            ];
            return $message;
        }
    }

    // show the record with the given id
    public function show($id)
    {
        $record = $this->model->find($id);
        if($record==null){
            $message = [
                'message' => 'id not found',
                'status' => 400,
            ];
            return $message;
        }
        else{
            $message=[
                'record' => $record,
                'status' => 200,
            ];
            return $message;
        }
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
        $accessToken=$post->createToken('token')->accessToken;
        $message = [
            'user'=>$post,
            'token' => $accessToken,
        ];
        return $post;
    }
    //upload post with image
    public function store_post(array $data){
        $imageName = md5($data['image'].time()).'.jpg';
        $image = str_replace('data:image/png;base64,', '',  $data['image']);
        Storage::disk('stores')->put($imageName, base64_decode($image));
        $data['image'] = $imageName;

        $record = $this->model->create($data);
        //created category_id table many to many catgory_post
        $record->categories()->attach($data['category_id']);
        
        $message=[
            'message'=>'record created successfully',
            'record'=>$record,
            'status'=>200
        ];
        return $message;
    }
    //update post with image
    public function update_post(array $data,$id){
       
        $record = $this->model->find($id);
        //check if id exit
        if($record==null){
            $message = [
                'message' => 'id not found',
                'status' => 400,
            ];
            return $message;
        }
        else{
            //if select img
            if(isset($data['image'])){
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
                
                $record->update($data);
                //update table many to many catgory_post
                $record->categories()->sync($data['category_id']);
            }
            //none select img
            else{
                //find old img
                $image_old=$this->model::find($id);
                //assign old img to image
                $data['image']=$image_old['image'];
                $record = $this->model->find($id);
            }
            //message
            $message=[
                'message'=>'record updated successfully',
                'record'=>$record,
                'status'=>200
            ];
            return $message;
        }
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
            $accessToken=$post->createToken('token')->accessToken;
            return response()->json([
              'message'=>'Register Successfully',
              'user'=>$post,
              'token'=>$accessToken
            ],200);
        }
        else{
            return response()->json([
                'message'=>"Invalid email or password"
            ],400);
        }
    }
    //login
    public function login(array $data){
        
        if(!Auth::attempt(['email' => $data['email'], 'password' =>$data['password']])){
            return response('Invalid email or password',400);
            $message=[
                'message'=>'Invalid email or password',
                'status'=>200
              ];
            return $message;
        }
        else{
          $accessToken=Auth::user()->createToken('token')->accessToken;
          $message=[
            'message'=>'login successfully',
            'user'=>Auth::user(),
            'token'=>$accessToken,
            'status'=>200
          ];
           return $message;
        }
    }

    //get posts by cateogry
    // public function getPostsByCateogry($category){
    //     $post=$this->model->where('category_id',$category)
    // }
}