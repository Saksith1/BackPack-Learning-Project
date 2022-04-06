<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Post extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable=['trainer_id','user_id','title','body','image','created_by','updated_by'];
    
    public function trainers(){
        return $this->hasMany(Trainer::class);
    }

    
    public function categories(){
        return $this->belongsToMany(Category::class,'category_posts');
    }

    public function trainer(){
        return $this->belongsTo(Trainer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            Storage::delete(Str::replaceFirst('storage/','public/', $obj->image));
        });
    }
    // mutator formate timestamb
    public function setCreatedAtAttribute($date)
    {
        $this->attributes['created_at']=Carbon::parse($date)->format("Y-m-d");
    }
    //
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format("Y-m-d");
    }

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        // or use your own disk, defined in config/filesystems.php
        $disk = 'stores'; 
        // destination path relative to the disk above
        // $destination_path = "public/uploads/folder_1/folder_2"; 
        $filename = md5($value.time()).'.jpg';
        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value)->encode('jpg', 90);

            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';

            // 2. Store the image on disk.
            \Storage::disk($disk)->put($filename, $image->stream());

            // 3. Delete the previous image, if there was one.
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // 4. Save the public path to the database
            // but first, remove "public/" from the path, since we're pointing to it 
            // from the root folder; that way, what gets saved in the db
            // is the public URL (everything that comes after the domain name)
            // $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $filename;
        }else{
            $this->attributes[$attribute_name] = $filename;
        }
    }
    
}
