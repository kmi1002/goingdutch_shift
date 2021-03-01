<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleGroupTreeCollection extends ResourceCollection
{
    var $depth = 0;

    public function __construct($resource, $depth)
    {
        parent::__construct($resource);

        $this->depth = $depth;
    }


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($order) use ($request) {
            return (new ArticleGroupTreeResource($order, $this->depth))->toArray($request);
        });
    }
}