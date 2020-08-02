<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NewsCategory;
use App\Article;
use Session;
use Image;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller {

    public function index(Request $request) {
        $categories = NewsCategory::where('category_status', 1)->orderBy('category_name', 'ASC')->pluck('category_name', 'id')->toArray();
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);
        return view('articles.index', compact('articles', 'categories'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(Request $request) {
        $categories = NewsCategory::where('category_status', 1)->orderBy('category_name', 'ASC')->pluck('category_name', 'id')->toArray();
        return view('articles.create', compact('categories'));
    }

    public function insert(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'article_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $postdata = $request->input();
        $article = new Article($postdata);

        if ($request->hasFile('article_img')) {
            $file = $request->file('article_img');
            $orig_name = str_replace(' ', '-', trim($file->getClientOriginalName()));
            $filename = time() . '-' . $orig_name;
            $destinationPath = public_path() . '/uploads/article/large/';
            $destinationPath_thumb = public_path() . '/uploads/article/thumb/';

            $img = Image::make($file->getRealPath());
            $img->resize(120, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath_thumb . $filename);

            $file->move($destinationPath, $filename);
            $article->article_img = $filename;
        }
        //$news->news_slug = Str::slug($request->news_title);
        $article->save();
        //Session::flash('success', 'Article Added successfully.');
        Session::flash('success', 'Article Added successfully.');
        return redirect()->route('article.index');
    }

    public function edit($id) {
        $categories = NewsCategory::where('category_status', 1)->orderBy('category_name', 'ASC')->pluck('category_name', 'id')->toArray();
        $article = Article::find($id);
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update($id, Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'article_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        $article = Article::find($id);       
        $postData = $request->all();
        
        if ($request->hasFile('article_img')) {
            $file = $request->file('article_img');
            $orig_name = str_replace(' ', '-', trim($file->getClientOriginalName()));
            $filename = time() . '-' . $orig_name;
            $destinationPath = public_path() . '/uploads/article/large/';
            $destinationPath_thumb = public_path() . '/uploads/article/thumb/';

            $img = Image::make($file->getRealPath());
            $img->resize(120, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath_thumb . $filename);
            
            $file->move($destinationPath, $filename);            
            $postData['article_img'] = $filename;
            
            $old_image = $article->article_img;
            $old_image_path_thumb = public_path() . '/uploads/article/thumb/' . $old_image;
            $old_image_path_large = public_path() . '/uploads/article/large/' . $old_image;
            @unlink($old_image_path_thumb);
            @unlink($old_image_path_large);
        }
        
        Article::find($id)->update($postData);
        Session::flash('success_msg', 'Article Updated successfully.');
        return redirect()->route('article.index');
    }
    
    public function remove($id) {
        $article = Article::find($id);
        
        $old_image = $article->article_img;
        $old_image_path_thumb = public_path() . '/uploads/article/thumb/' . $old_image;
        $old_image_path_large = public_path() . '/uploads/article/large/' . $old_image;
        @unlink($old_image_path_thumb);
        @unlink($old_image_path_large);
        $article->delete();
        Session::flash('success_msg', 'Article Deleted successfully.');
        return redirect()->route('article.index');
    }

    public function setSession() {
        $arr = array('name' => 'Manojit Nandi', 'email' => 'mnbl87@gmail.com', 'age' => '32', 'org' => 'simpliance');
        session($arr);
        return redirect()->route('article.getsession');
    }

    public function getSession(Request $request) {
        $data = $request->session()->all();
        echo "<pre>";
        print_r($data);
        //print_r($delete_key );
        //echo "<br/>";
        //echo session('name') ."--". session('email'). "--". session('org');
        $request->session()->forget(['name', 'email', 'age', 'org']);
        print_r($request->session()->all());
    }
    
    

}
