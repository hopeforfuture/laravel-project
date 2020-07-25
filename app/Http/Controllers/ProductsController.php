<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Session;
use Illuminate\Validation\Rule;
use Validator;

class ProductsController extends Controller {

    public function index(Request $request) {
        $products = Product::where('status', '=', '1')->orderBy('id', 'DESC')->paginate(5);
        return view('products.index', compact('products'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'details' => 'required',
            'price' => 'required|numeric|min:1',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'CaptchaCode' => 'required|valid_captcha'
        ]);

        $postdata = $request->input();


        $product = new Product($postdata);

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path() . '/uploads/';
            $file->move($destinationPath, $filename);
            $product->product_image = $filename;
        }

        $product->save();

        Session::flash('success_msg', 'Product Added successfully.');

        return redirect()->route('products.index');
    }

    public function edit($id) {
        $product = Product::find($id);
        return view('products.edit', ['product' => $product]);
    }

    public function update($id, Request $request) {
        $product = Product::find($id);

        $v = Validator::make($request->input(), [
                    'name' => [
                        'required',
                        Rule::unique('products')->ignore($product->id),
                    ],
                    'details' => [
                        'required'
                    ],
                    'price' => [
                        'required',
                        'numeric',
                        'min:1'
                    ],
                    'product_image' => [
                        'image|mimes:jpeg,png,jpg,gif,svg'
                    ],
                    'CaptchaCode' => 'required|valid_captcha'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }

        $postData = $request->all();

        if ($request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path() . '/uploads/';
            $file->move($destinationPath, $filename);
            $postData['product_image'] = $filename;

            $old_image = $product->product_image;
            $old_image_path = public_path() . '/uploads/' . $old_image;
            @unlink($old_image_path);
        }

        Product::find($id)->update($postData);
        Session::flash('success_msg', 'Product Updated successfully.');
        return redirect()->route('products.index');
    }

}
