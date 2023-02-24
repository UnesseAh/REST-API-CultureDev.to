<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;
use App\Models\Article;



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
            // 'tag_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $article = Article::create($request->all());

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
    public function show(Article $article)
    {
        // $article = Article::findorfail($id);
        // if ($article) {
        //     return $this->apiResponse($article, 'ok', 200);
        // }
        // return $this->apiResponse(data: null, message: 'the article not found', status: 404);


        // // toufik work
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }
        return new ArticleResource($article);
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
        $article = Article::find($id);
        if (!$article) {
            return $this->apiResponse(null, 'Article not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'tag_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $article = Article::findorfail($id);

        $article->update($request->all());
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
    public function destroy($id)
    {
        $article = Article::findorfail($id);
        if (!$article) {
            return $this->apiResponse(null, 'Article not found', 404);
        }
        $article->delete($id);
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
            ->join('article_tag', 'articles.id', '=', 'article_tag.article_id')
            ->join('tags', 'tags.id', '=', 'article_tag.tag_id')
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
