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
        $commentNames = $this->comments->map(function ($comment) {
            return $comment->comment;
        });
        $tagNames = $this->tags->map(function ($tag) {
            return $tag->tag;
        });

        return [

            'id' => $this->id,
            'title' => $this->title,
            'content'=>$this->content,
            'description' => $this->description,
            'category' => new CategoryResource($this->category),
            'user' => new UserResource($this->user),
            'comments' => new CommentCollection($this->comments),
            'tags' => new TagCollection($this->tags)



            

        ];
    }
}
