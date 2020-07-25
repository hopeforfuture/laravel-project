<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use session;

class TestController extends Controller
{
    public function newslist()
	{
		$bbcNews = array(
			array('category'=>'Science', 'date'=>'2019-05-15', 'article'=>'Post A'),
			array('category'=>'Nature', 'date'=>'2014-07-12', 'article'=>'Post B'),
			array('category'=>'Food', 'date'=>'2017-07-21', 'article'=>'Post C'),
			array('category'=>'Science', 'date'=>'2018-01-11', 'article'=>'Post D'),
			array('category'=>'Nature', 'date'=>'2019-01-25', 'article'=>'Post E'),
			array('category'=>'Nature', 'date'=>'2015-02-12', 'article'=>'Post F'),
			array('category'=>'Science', 'date'=>'2018-09-15', 'article'=>'Post G'),
			array('category'=>'Electronics', 'date'=>'2016-11-01', 'article'=>'Post H'),
			array('category'=>'Food', 'date'=>'2019-05-18', 'article'=>'Post I'),
			array('category'=>'Electronics', 'date'=>'2019-07-15', 'article'=>'Post J'),
			array('category'=>'Food', 'date'=>'2019-11-12', 'article'=>'Post K'),
			array('category'=>'Science', 'date'=>'2018-08-17', 'article'=>'Post L'),
			array('category'=>'Nature', 'date'=>'2019-12-15', 'article'=>'Post M'),
			array('category'=>'Nature', 'date'=>'2019-01-07', 'article'=>'Post N'),
			array('category'=>'Food', 'date'=>'2019-06-25', 'article'=>'Post O'),
			array('category'=>'Food', 'date'=>'2019-07-25', 'article'=>'Post P'),
		);
		
		$sortednews = $this->newssort($bbcNews);
		
		return view('news.index', ['originals'=>$bbcNews, 'sortednews'=>$sortednews]);
		
	}
	
	public function newssort($news=array())
	{
		$sortednews = array();
		
		if(!empty($news))
		{
			foreach($news as $ne)
			{
				$sortednews[] = array('category'=>ucfirst($ne['category']), 'article'=>$ne['article'], 'date'=>strtotime($ne['date']));
			}
			
			$categories = array_column($sortednews, 'category');
			$article_time = array_column($sortednews, 'date');
			
			array_multisort($categories,SORT_DESC,$article_time,SORT_DESC,$sortednews);
		}
		
		return $sortednews;
	}
	
	public function setsession(Request $request)
	{
		$arr = array('name'=>'Manojit Nandi', 'email'=>'mnbl87@gmail.com', 'age'=>'32');
		session($arr);
		$arr1 = array('org'=>'smartwork');
		session($arr1);
		
		$data = $request->session()->all();
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		$request->session()->flush();
		die;
	}
	
	public function search() {
		if(!empty(Input::all())) {
			echo "<pre>";
			print_r(Input::all());
			die;
		}
		return view('news.search');
	}
}
