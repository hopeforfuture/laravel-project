<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NewsCategory;
use App\Article;
use Session;
use Image;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Auth;
use Auth;

class ArticleController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        //echo Auth::user()->id;
        //print($this->getUserDetails());
        $categories = NewsCategory::where('category_status', 1)->orderBy('category_name', 'ASC')->pluck('category_name', 'id')->toArray();
        $articles = Article::where('created_by', Auth::user()->id)
                ->orderBy('created_at', 'desc')->paginate(5);
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
        $article->created_by = Auth::user()->id;
        $article->save();
        //Session::flash('success', 'Article Added successfully.');
        Session::flash('success', 'Article Added successfully.');
        return redirect()->route('article.index');
    }

    public function edit($id) {
        $categories = NewsCategory::where('category_status', 1)->orderBy('category_name', 'ASC')->pluck('category_name', 'id')->toArray();
        $article = Article::find($id);
        if($article->created_by != Auth::user()->id) {
            return redirect()->route('article.index');
        }
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
    
    public function view(Request $request) {
        $id = $request->id;
        $news_info = DB::table('articles')
                ->join('news_categories', 'articles.article_category', '=','news_categories.id')
                ->where('articles.id', '=', $id)
                ->select('articles.*','news_categories.category_name')->get()->toArray();
        
        return response()->json($news_info[0]);
    }
    
    public function export(Request $request) {
        ob_clean();
        ob_end_clean();
        set_time_limit(3600);
        
        $artclesdata = DB::table('articles')
                ->join('news_categories', 'articles.article_category', '=','news_categories.id')
                ->join('users', 'articles.created_by', '=','users.id')
                ->where('articles.created_by', Auth::user()->id)
                ->select('articles.*','news_categories.category_name', 'users.name')
                ->orderBy('articles.created_at', 'DESC')
                ->get()
                ->toArray();
        
        $header_row = $header_main = '';
        
        $header_main.='SI No'."\t".
                     'Article Title'."\t".
                     'Article Category'."\t".                     
                     'Article Content'."\t". 
                     'Created By'."\t".
                     'Article Publish Date'."\t \n";
        
        if(!empty($artclesdata)) {
            $si_no = 0;
            foreach($artclesdata as $article) {
                $si_no++;
                $article_title = preg_replace("/\s+/", " ", $article->title);
                $article_content = preg_replace('/\s+/',' ', $article->body);
                $article_category = preg_replace('/\s+/',' ', $article->category_name);
                $created_by = $article->name;
                $published_date = $article->created_at;
                
                $header_row.=$si_no."\t".
                              $article_title."\t".
                              $article_category."\t".                             
                              $article_content."\t".
                              $created_by."\t".
                              $published_date."\t \n";
            }
        }
        
        $file_name = date('Y-m-d H:i:s')."-artcles-list.xls";
        header('Content-Type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$file_name);
        echo ($header_main);
        echo ($header_row);
        die;
        
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
        $request->session()->forget(['name', 'email', 'age', 'org']);
        print_r($request->session()->all());
        //echo "<br>";
        //echo public_path('uploads/article/thumb/');
        //echo "<br>";
        //echo public_path() . '/uploads/article/large/';
        //echo "<br/>";
        //echo $this->param;
    }
    
    private function getUserDetails() {
        $user_id = Auth::user()->id;
        return $user_id;
    }
    
    
}
