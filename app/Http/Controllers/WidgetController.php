<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Trainer;

class WidgetController extends Controller
{
    public function getUser(){
        $user=User::count();
        $post=Post::count();
        $category=Category::count();
        $trainer=Category::count();
        return view('base.dashboard')
        ->with('user',$user)
        ->with('post',$post)
        ->with('category',$category)
        ->with('trainer',$trainer);
    }

}
