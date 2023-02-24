<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [

            // 'title'=>$this->title,
            // 'description'=>$this->description,
            // 'content'=>$this->content,
            // 'category'=>$this->categorie,

            // 'category_id'=>$this->category_id,

            'id' => $this->id,
            'title' => $this->title,
            'content'=>$this->content,
            'description' => $this->description,
            'category' => new CategoryResource($this->category),
            'user' => new UserResource($this->user),
            'comments' => new CommentCollection($this->comments),
            'tags' => new TagCollection($this->tags)



            // 'category'=>$this->categorie->category ?? null,
            // 'tag'=>$this->tags->tag,
            // 'comment'=>$this->comments->comment,
            // 'user'=>$this->user->name

        ];
    }
}
