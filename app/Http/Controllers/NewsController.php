<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NewsCategory;
use App\News;
use Session;
use Image;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller {

    public function index(Request $request) {
        $categories = NewsCategory::where('category_status', 1)->orderBy('category_name', 'ASC')->pluck('category_name', 'id')->toArray();
        $news_list_sql = News::where('news_status', 1);
        $is_search = 0;
        $filter = $request->all();
        if(!empty($filter['news_title'])) {
            $title = trim($filter['news_title']);
            if(!empty($title)) {
                $news_list_sql->where('news_title', 'like', '%'.$title.'%');
            }
            $is_search = 1;
        }
        if(!empty($filter['news_category_id'])) {
            $category = trim($filter['news_category_id']);
            if(!empty($category)) {
                $news_list_sql->where('news_category_id', '=', $category);
            }
            $is_search = 1;
        }
        if($is_search == 1) {
            session($filter);
        } else {
            $request->session()->forget(['news_title', 'news_category_id']);
        }
        
        $news_list = $news_list_sql->orderBy('id', 'DESC')->paginate(5);
        return view('news-data.index', compact('news_list','categories', 'is_search'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(Request $request) {
        $categories = NewsCategory::where('category_status', 1)->orderBy('category_name', 'ASC')->pluck('category_name', 'id')->toArray();
        return view('news-data.create', compact('categories'));
    }

    public function insert(Request $request) {
        $this->validate($request, [
            'news_title' => 'required',
            'news_category_id' => 'required',
            'news_description' => 'required',
            'news_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'CaptchaCode' => 'required|valid_captcha'
        ]);

        $postdata = $request->input();
        $news = new News($postdata);

        if ($request->hasFile('news_image')) {
            $file = $request->file('news_image');
            $orig_name = str_replace(' ', '-', trim($file->getClientOriginalName()));
            $filename = time() . '-' . $orig_name;
            $destinationPath = public_path() . '/uploads/news/large/';
            $destinationPath_thumb = public_path() . '/uploads/news/thumb/';

            $img = Image::make($file->getRealPath());
            $img->resize(120, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath_thumb . $filename);
            
            $file->move($destinationPath, $filename);            
            $news->news_img_thumb = $filename;
        }
        $news->news_slug = Str::slug($request->news_title);
        $news->save();
        Session::flash('success_msg', 'News Added successfully.');
        return redirect()->route('news.index');
    }
    
    public function view(Request $request) {
        $id = $request->id;
        $news_info = DB::table('news')
                ->join('news_categories', 'news.news_category_id', '=','news_categories.id')
                ->where('news.id', '=', $id)
                ->select('news.*','news_categories.category_name')->get()->toArray();
        
        //print_r($news_info[0]);
                
        return response()->json($news_info[0]);
    }
    
    public function export(Request $request) {
        ob_clean();
        ob_end_clean();
        set_time_limit(3600);
 
        $newsdata = DB::table('news')
                ->join('news_categories', 'news.news_category_id', '=','news_categories.id')
                ->where('news.news_status', '=', 1);
                
        if($request->session()->has('news_title')) {
            $title = $request->session()->get('news_title');
            $newsdata->where('news_title', 'like', '%'.$title.'%');
        }
        if($request->session()->has('news_category_id')) {
            $news_category_id = $request->session()->get('news_category_id');
            $newsdata->where('news_category_id', '=', $news_category_id);
        }
        
        $newsdata = $newsdata->orderBy('id', 'DESC')->select('news.*','news_categories.category_name')->get()->toArray();
        
        $header_row = $header_main = '';
        
        $header_main.='SI No'."\t".
                     'News Title'."\t".
                     'News Category'."\t".
                     'News Slug'."\t".
                     'News Content'."\t".                   
                     'News Publish Date'."\t \n";
        
        if(!empty($newsdata)) {
            $si_no = 0;
            foreach ($newsdata as $news) {                
                $si_no++;
                $news_title = preg_replace("/\s+/", "", $news->news_title);
                $news_title = preg_replace('/\s+/',' ', $news_title);
                $news_slug = preg_replace('/\s+/',' ', $news->news_slug);
                $news_content = preg_replace('/\s+/',' ', $news->news_description);
                $news_category = preg_replace('/\s+/',' ', $news->category_name);
                $published_date = $news->created_at;
                
                $header_row.=$si_no."\t".
                              $news_title."\t".
                              $news_category."\t".
                              $news_slug."\t".
                              $news_content."\t".
                              $published_date."\t \n";
                                                      
            }
        }
        
        
        $file_name = date('Y-m-d H:i:s')."-news-list.xls";
        header('Content-Type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$file_name);
        echo ($header_main);
        echo ($header_row);
        die;
                     
    }
    
    public function edit($id) {
        $categories = NewsCategory::where('category_status', 1)->orderBy('category_name', 'ASC')->pluck('category_name', 'id')->toArray();
        $news = News::find($id);
        return view('news-data.edit', compact('news','categories'));
    }
    
    public function update($id, Request $request) {        
        $this->validate($request, [
            'news_title' => 'required',
            'news_category_id' => 'required',
            'news_description' => 'required',
            'news_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'CaptchaCode' => 'required|valid_captcha'
        ]);
        
        $news = News::find($id);
        
        $v = Validator::make($request->all(), [
                    'news_title' => [
                        //'required',
                        Rule::unique('news')->ignore($news->id),
                    ],
                    
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }

        $postData = $request->all();
        
        if ($request->hasFile('news_image')) {
            $file = $request->file('news_image');
            $orig_name = str_replace(' ', '-', trim($file->getClientOriginalName()));
            $filename = time() . '-' . $orig_name;
            $destinationPath = public_path() . '/uploads/news/large/';
            $destinationPath_thumb = public_path() . '/uploads/news/thumb/';

            $img = Image::make($file->getRealPath());
            $img->resize(120, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath_thumb . $filename);
            
            $file->move($destinationPath, $filename);            
            $postData['news_img_thumb'] = $filename;
            
            $old_image = $news->news_img_thumb;
            $old_image_path_thumb = public_path() . '/uploads/news/thumb/' . $old_image;
            $old_image_path_large = public_path() . '/uploads/news/large/' . $old_image;
            @unlink($old_image_path_thumb);
            @unlink($old_image_path_large);
        }
        
        $postData['news_slug'] = Str::slug($postData['news_title']);
        
        News::find($id)->update($postData);
        Session::flash('success_msg', 'News Updated successfully.');
        return redirect()->route('news.index');
    }
    
    public function remove($id) {
        $news = News::find($id);
        $news->news_status = 0;
	$news->save();
        Session::flash('success_msg', 'News Deleted successfully.');
        return redirect()->route('news.index');
    } 
    
    

}
