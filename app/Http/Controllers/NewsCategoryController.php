<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NewsCategory;
use Session;
use Illuminate\Validation\Rule;
use Validator;

class NewsCategoryController extends Controller {

    public function index(Request $request) {
        $news_category_list = NewsCategory::where('category_status', 1)->orderBy('id', 'DESC')->paginate(5);
        return view('news-category.index', compact('news_category_list'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create() {
        return view('news-category.create');
    }

    public function insert(Request $request) {
        $this->validate($request, [
            'category_name' => 'required',
            'category_details' => 'required',
            'category_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'CaptchaCode' => 'required|valid_captcha'
        ]);

        $postdata = $request->input();
        $newscategory = new NewsCategory($postdata);
        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $orig_name = str_replace(' ', '-', trim($file->getClientOriginalName()));
            $filename = time() . '-' . $orig_name;
            $destinationPath = public_path() . '/uploads/';
            $file->move($destinationPath, $filename);
            $newscategory->category_image = $filename;
        }

        $newscategory->save();
        Session::flash('success_msg', 'Category Added successfully.');
        return redirect()->route('newscategory.index');
    }
    
    public function edit($id) {
        $newscategory = NewsCategory::find($id);
        return view('news-category.edit', ['newscategory' => $newscategory]);
    }
    
    public function update($id, Request $request) {
        $this->validate($request, [
            'category_name' => 'required',
            'category_details' => 'required',
            'category_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'CaptchaCode' => 'required|valid_captcha'
        ]);
        $newscategory = NewsCategory::find($id);
        
        $v = Validator::make($request->input(), [
                    'category_name' => [
                        //'required',
                        Rule::unique('news_categories')->ignore($newscategory->id),
                    ],                    
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }

        $postData = $request->all();
        
        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $orig_name = str_replace(' ', '-', trim($file->getClientOriginalName()));
            $filename = time() . '-' . $orig_name;
            $destinationPath = public_path() . '/uploads/';
            $file->move($destinationPath, $filename);
            $postData['category_image'] = $filename;

            $old_image = $newscategory->category_image;
            $old_image_path = public_path() . '/uploads/' . $old_image;
            @unlink($old_image_path);
        }

        NewsCategory::find($id)->update($postData);
        Session::flash('success_msg', 'News Category Updated successfully.');
        return redirect()->route('newscategory.index');
       
    }
    
    public function remove($id) {
        $newscategory = NewsCategory::find($id);
        $newscategory->category_status = 0;
	$newscategory->save();
        Session::flash('success_msg', 'News Category Deleted successfully.');
        return redirect()->route('newscategory.index');
    }

    public function export() {
        ob_clean();
        $categories = NewsCategory::where('category_status', 1)->orderBy('id', 'DESC')->get()->toArray();
        $header_main = $header_row = '';
        $header_main.='SI No'."\t".
                      'Category Name'."\t".
                      'Category Description'."\t".
                      'Created At'."\t \n";
        
        if(!empty($categories)) {
            $si_no = 0;
            foreach ($categories as $category) {
                $si_no++;
                $header_row.=$si_no."\t".
                preg_replace('/\s+/', ' ', $category['category_name'])."\t".
                preg_replace('/\s+/', ' ', $category['category_details'])."\t".
                $category['created_at']."\t \n";      
            }
        }
        ob_end_clean();
        $filename = date('Y-m-d H:i:s')."category-list.xls";
        header('Content-Type:appliaction/ms-excel');
        header('Content-Disposition:attachment;filename='.$filename);
        echo ($header_main);
        echo ($header_row);
        die;
    }
    
    public function view(Request $request) {
        $id = $request->category_id;
        $news_category_info = NewsCategory::find($id)->toArray();
        return response()->json($news_category_info);
    }

}
