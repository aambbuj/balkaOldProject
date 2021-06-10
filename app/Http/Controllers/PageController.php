<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use DB;
use Validator;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('deleted',0)->get();
        // echo "<pre>";
        // print_r($pages);die;
        return view('pages.index',['pages'=>$pages]);
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255|string',
            'content' => 'required|min:3|string',
          ]);

        if ($validator->fails()) {
          //return error_json($validator->errors()->first());
          return redirect()->route('pages.create')->withErrors($validator)->withInput();
        }

        $page= new Page();
        $page->name=$request->name;
        $page->slug=strtolower(str_replace(' ', '_', request('name')));
        $page->content=$request->content;
        $page->save();

        return redirect()->route('pages.index')->withSuccess('You have successfully created a Page!');
    }

    public function edit($id)
    {
        $page= Page::find($id);
        return view('pages.edit',['page'=>$page]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255|string',
            'content' => 'required|min:3|string',
          ]);

        if ($validator->fails()) {
          //return error_json($validator->errors()->first());
          return redirect()->route('pages.edit',$id)->withErrors($validator)->withInput();
        }

        $page= Page::find($id);
        $page->name=$request->name;
        $page->slug=strtolower(str_replace(' ', '_', request('name')));
        $page->content=$request->content;
        $page->update();

        return redirect()->route('pages.index')->withSuccess('You have successfully updated a Page!');
    }

    public function show($name)
    {
        $page = Page::where('deleted',0)->where('name',$name)->first();
        // echo "<pre>";
        // print_r($pages);die;
        if($page)
        {
          return view('pages.show',['page'=>$page]);
        }
        else
        {
          return redirect()->route('404');
        }
    }
}
