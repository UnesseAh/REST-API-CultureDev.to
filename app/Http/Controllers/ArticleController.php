<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Models\Article;
use Illuminate\Support\Facades\DB;



class ArticleController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        // $articles = ArticleResource::collection(Article::get());
        // // $articles = Article::join('categories','categories.id','=','articles.category_id')->get();
        // return $this->apiResponse($articles, 'ok', 200);

       // toufik work
        $articles = Article::all();

        return new ArticleCollection($articles);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $article = Article::create($request->all());
        $article->tags()->attach($request->tag_id);
        if ($article) {
            return $this->apiResponse($article, "Article Saved successfully", 201);
        } else {
            return $this->apiResponse(null,  "Article not saved", 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article,$id)
    {

        $article = Article::find($id);
        if ($article) {
             return new ArticleResource($article);
        }
        return $this->apiResponse(data: null, message: 'the article not found', status: 404);



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $article = Article::find($id);
        if(!$user->can('edit every article') && $user->id != $article->user_id){
            return $this->apiResponse(null, 'you dont have permission to edit this article', 400);
        }

        if (!$article) {
            return $this->apiResponse(null, 'Article not found', 404);
        }


        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }



        $article->update($request->all());
        // $article->tags()->updateExistingPivot($request->id);
        $article->tags()->sync([$request->tag_id]);
        if($article){
            return $this->apiResponse($article,'Article updated',201);
        }


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $article = Article::find($id);
        if (!$article) {
            return $this->apiResponse(null, 'Article not found', 404);
        }

        // Remove references to the article being deleted from the "article_tags" table
        // DB::table('article_tags')->where('article_id', $id)->delete();

        // $article->tags()->detach([$request->tag_id]);
        $article->delete();

        if ($article) {
            return $this->apiResponse(null, 'Article deleted', 200);
        }
    }

    public function search($search)
    {
        // $article=Article::with('categorie')->where('category','like','$search%')->get();
        // $article=Article::join('categories', 'categories.id', '=', 'articles.category_id')
        //                  ->join('tags', 'tags.id', '=', 'articles.tag_id')
        //                  ->where('category','like',"$search%")
        //                  ->orwhere('tag','like',"$search%")->get();

            $article = Article::join('categories', 'categories.id', '=', 'articles.category_id')
            ->join('article_tags', 'articles.id', '=', 'article_tags.article_id')
            ->join('tags', 'tags.id', '=', 'article_tags.tag_id')
            ->where('category', 'like', "$search%")
            ->orWhere('tag', 'like', "$search%")
            ->get();

        if (!$article) {
            return $this->apiResponse(null, 'Article not found', 404);
        }
        if ($article) {
            return $this->apiResponse($article, 'Article(s) with this category or tag :', 200);
        }

        // $article=Article::with('categorie')->where('category','like','%$search%')->get();

    }
}
