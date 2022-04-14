<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use App\Models\Role;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/insert', function(){

    DB::insert('insert into posts(title, content, user_id) values(?, ?, ?)', ['PHP with Laravel', 'Laravel is awesome', '1']);
});

Route::get('/read', function(){
    $posts = Post::all();

    foreach($posts as $post) {
        echo $post->content . "<br>";
    }
});

Route::get('/basicInsert', function(){
    $post = new Post;

    $post->title = "New Eloquent title insert";
    $post->content = "Wow eloquent is really cool, look at this content";
    $post->user_id = "1";
    $post->save();
});

Route::get('/create', function(){
    Post::create(['user_id'=>'1', 'title'=>'the create method', 'content'=>'I\'m learning alot']);
});

Route::get('/update', function(){
    Post::where('id', 2)->where('is_admin', 0)->update(['title'=>'new title', 'content'=>'i love my instructor']);
});

Route::get('/delete', function(){
    $post = Post::find(1);
    $post->delete();
});

Route::get('/softdelete', function(){
    $post = Post::find(2);
    $post->delete();
});

Route::get('/restore', function(){
    Post::onlyTrashed()->where('is_admin', 0)->restore();
});

Route::get('/forceDelete', function(){
    Post::onlyTrashed()->where('is_admin', 0)->forceDelete();
});

Route::get('/user/{id}/post', function($id){
    return User::find($id)->post;
});

Route::get('/post/{id}/user', function($id){
    return Post::find($id)->user->name;
});

Route::get('/user/{id}/posts', function($id){
    $user = User::find($id);

    foreach($user->posts as $post) {
        echo $post->title . "<br>";
    }
});

Route::get('/user/{id}/role', function($id){
    $user = User::find($id)->roles()->orderBy('id', 'asc')->get();

    return $user;
//   $user = User::find($id);
//
//   foreach($user->roles as $role) {
//       echo $role->name . "<br>";
//   }
});

Route::get('/roles/{id}/users', function($id){
   $roles = Role::find($id)->users()->get();

   return $roles;
});

Route::get('user/pivot', function(){
    $user = User::find(1);

    foreach($user->roles as $role){
        return $role->pivot->created_at;
    }
});

Route::get('/user/country', function(){

});
