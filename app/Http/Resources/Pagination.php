<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class Pagination extends ResourceCollection
{
    public function __construct(AbstractPaginator $resource, private ?string $wrapper = null)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pagination' => [
                'currentPage' => $this->resource->currentPage(),
                'lastPage' => $this->resource->lastPage(),
                'perPage' => $this->resource->perPage(),
                'total' => $this->resource->total(),
            ],
            'data' => $this->wrapper ? $this->wrapper::collection($this->collection) : $this->collection,
        ];
    }
}
