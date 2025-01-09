<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        if (request()->ajax()) {
            $articles = Article::select(['id', 'title', 'author', 'start_date', 'end_date', 'image']);
    
            return DataTables::of($articles)
                ->editColumn('image', function($article) {
                    return $article->image ? 
                        '<img src="' . asset('storage/' . $article->image) . '" class="w-20 h-20 object-cover" />' : 
                        'No image';
                })
                ->addColumn('start_date', function($article){
                    if($article->start_date){
                        return Carbon::parse($article->start_date)->format('d M Y');
                    }
                    return '-';
                })
                ->addColumn('enddate', function($article){
                    if($article->end_date){
                        return Carbon::parse($article->end_date)->format('d M Y');
                    }
                    return '-';
                })
                ->addColumn('actions', function($article) {
                    return '
    <button onclick="editArticle(' . $article->id . ')" class="bg-green-500 text-white px-4 py-2 mb-4 rounded hover:bg-green-600 transition">
        Edit
    </button>
    <button onclick="deleteArticle(' . $article->id . ')" class="bg-red-500 text-white px-4 py-2 mb-4 rounded hover:bg-red-500 transition">
        Delete
    </button>';
                })
                ->rawColumns(['image', 'actions', 'start_date', 'enddate'])
                ->make(true);
        }
        return view('admin.articles.index');
    }

    public function create()
    {
        return 'no request';
    }

    public function store(StoreArticleRequest $request)
    {
        $validated = $request->validated();
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }
        $article = Article::create([
            'title' => $validated['title'],
            'author' => \Auth::user()->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'content' => $validated['content'],
            'image' => $imagePath,
            'meta_tags' => $request->meta_tags,
            'tags' => $request->tags
        ]);
        return response()->json([
            'success' => true,
            'data' => $article,
            'message' => 'Artikel berhasil diperbarui!'
        ]);
    }

    public function show(Article $article)
    {
        if ($article) {
            return response()->json([
                'success' => true,
                'data' => $article
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Article not found'
        ], 404);
    }
    
    public function update(StoreArticleRequest $request, Article $article)
    {
        $validated = $request->validated();
        $imagePath = $article->image;

        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')->store('articles', 'public');
        }

        $article->update([
            'title' => $validated['title'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'content' => $validated['content'],
            'image' => $imagePath,
            'meta_tags' => $request->meta_tags,
            'tags' => $request->tags
        ]);

        return response()->json([
            'success' => true,
            'data' => $article,
            'message' => 'Artikel berhasil diperbarui!'
        ]);
    }


    public function destroy($id)
    {
        $article = Article::find($id);
        if ($article) {
            $article->delete();

            return response()->json(['success' => true, 'message' => 'Artikel berhasil dihapus']);
        }

        return response()->json(['success' => false, 'message' => 'Artikel tidak ditemukan'], 404);
    }
}
