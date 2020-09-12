<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DemoUser;
use App\DemoUserProfile;
use App\NewsCategory;
use App\Mechanic;
use App\Car;
use App\Country;
use App\Blog;
use App\Employee;
use Session;


class EloquentController extends Controller
{
    public function getUserData($id='') {
        $userData = DemoUser::find($id);
        if(!empty($userData)) {
            echo "<pre>";
            print_r(json_decode($userData->profile, TRUE));
        } else {
            return 'No data found.';
        }
    }
    
    public function getPosts($id='') {
        $categoryData = NewsCategory::find($id);
        if(!empty($categoryData)) {
            echo $categoryData->category_name."<br/>";
            if(!empty($categoryData->articles)) {
                foreach ($categoryData->articles as $article) {
                    echo $article->title."--------".$article->title."<br/>";
                }
            }
        } else {
            return 'No data found.';
        }
    }
    
    public function getRoles($id='') {
        $user = DemoUser::find($id);
        if(!empty($user)) {
            if(!empty($user->roles->toArray())) {
                foreach($user->roles as $role) {
                    echo $role->name."------".$role->pivot->created_at."<br/>";
                }
            } 
            else {
                echo 'No role found for this user.';
            }
        } else {
            return 'No data found.';
        }
    }
    
    public function getOwner($id='') {
        $mechanic_data = Mechanic::find($id);
        $results = Mechanic::find($id)->carOwner->toArray();
        $car_id = $results['car_id'];
        $car_data = Car::find($car_id);
        echo "Mechanic Name:- ".$mechanic_data->name."<br/><br/>";
        echo "Car Model:- ".$car_data->model."<br/><br/>";
        echo "Owner Name:- ".$results['name'];
    }
    
    public function getBlogsByCountry($id='') {
        $country = Country::find($id);
        if(empty($country->country_name)) {
            return 'Country not found.';
        }
        $country_name = $country->country_name;
        $blogs = Country::find($id)->blogs;
        echo "Country name:- ". $country_name."<br/>";

        if(empty($blogs->toArray())) {
            echo "Sorry, no post avaialble from this country.";
        }
        else {
            foreach($blogs as $blog) {
                $blog_id = $blog->id;
                $author = Blog::find($blog_id)->author->name;
                echo "Post title:- ".$blog->title." Author:-".$author."<br/>";
            }
        }
    }
    
    public function getEmployeeAsset($id='') {
        $emp = Employee::find($id);
        if(empty($emp->emp_name)) {
            return 'Employee not found.';
        }
        
        echo "Name:- ".$emp->emp_name."<br/>";
        if(empty($emp->asset->toArray())) {
            return 'Employee image not found.';
        }
        echo "Image name:- ".$emp->asset->asset_name;
    }
    
    public function getBlogAsset($id='') {
        $blog = Blog::find($id);
        if(empty($blog->title)) {
            return 'Blog not found.';
        }
        
        echo "Blog title:- ".$blog->title."<br/>";
        if(empty($blog->asset->toArray())) {
            return 'Blog image not found.';
        }
        echo "Image name:- ".$blog->asset->asset_name;
    }
}
