<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(10);
        return view('news.index', compact('news'));
    }

    public function add()
    {
        $categories = Category::all();
        return view('news.add', compact('categories'));
    }

    public function show($slug)
    {

        $news = News::where('slug', $slug)->firstOrFail();
        $comments = News::where('slug', $slug)->firstOrFail()->comments;
        return view('news.detail', compact('news', 'comments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $news = new News();
        $news->category_id = $request->category_id;
        $news->user_id = auth()->user()->id;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->image = $request->image;
        $file = $request->file('image');
        $imageName = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('images/news'), $imageName);
        $news->image = 'images/news/'.$imageName;
        $news->save();
        return redirect()->route('news.index')->with('success', 'News created successfully.');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $news = News::findOrFail($id);
        return view('news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $news = News::findOrFail($id);
        $news->category_id = $request->category_id;
        $news->user_id = auth()->user()->id;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->image = $request->image;
        $file = $request->file('image');
        $imageName = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('images/news'), $imageName);
        $news->image = 'images/news/'.$imageName;
        $news->save();
        return redirect()->route('news.index')->with('success', 'News updated successfully.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        unlink(public_path($news->image));
        $news->delete();
        return redirect()->route('news.index')->with('success', 'News deleted successfully.');
    }

}
