<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class CategoryPost extends Model
{
    use HasFactory;
    protected $table='category_posts';
    protected $fillable=['category_id','post_id'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
