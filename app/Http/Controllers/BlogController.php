<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

/**
 * Class BlogController
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::paginate();

        return view('blog.index', compact('blogs'))
            ->with('i', (request()->input('page', 1) - 1) * $blogs->perPage());
        // return response()->json($blogs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blog = new Blog();
        return view('blog.create', compact('blog'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Blog::$rules);
        $input = $request->all();
        $input['user_id']=auth()->user()->id;
        $blog = Blog::create($input);

        return redirect()->route('blogs.index')
            ->with('success', 'Blog created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);

        return view('blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find($id);

        return view('blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        request()->validate(Blog::$rules);

        $blog->update($request->all());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $blog = Blog::find($id)->delete();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully');
    }

    function save_comment(Request $request){
        $data=new \App\Models\Comment;
        $data->blog_id=$request->blog;
        $data->description=$request->comment;
        $data->user_id=auth()->user()->id;
        if($data->save()){
            return response()->json([
                'bool'=>true
            ]);
        }
        else{
            return "Failed to post comment";
        }
    }
}
