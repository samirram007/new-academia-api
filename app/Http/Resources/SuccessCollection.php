<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;

class SuccessCollection extends ResourceCollection
{
    protected string $message;
    protected int $successCode;

    public function __construct(
        $resource,
        ?string $message = null,
        int $successCode = 200
    ) {
        parent::__construct($resource);
        $this->message = $message ?? 'Records fetched successfully';
        $this->successCode = $successCode;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }

    /**
     * Customize the response for a paginated resource.
     *
     * Prevents Laravel's default pagination wrapping (which adds `links`,
     * `meta.from`, `meta.to`, `meta.links` array, etc.) from conflicting
     * with the custom `meta` returned by `with()`.
     */
    public function toResponse($request)
    {
        if ($this->resource instanceof AbstractPaginator || $this->resource instanceof AbstractCursorPaginator) {
            $resourceClass = $this->collects();
            $resolvedItems = array_map(
                fn($item) => (new $resourceClass($item))->resolve($request),
                $this->resource->items()
            );

            return response()->json(
                [
                    'data' => array_values($resolvedItems),
                    ...$this->with($request),
                ]
            );
        }

        return parent::toResponse($request);
    }

    public function with(Request $request): array
    {
        $meta = null;

        if ($this->resource instanceof AbstractPaginator || $this->resource instanceof AbstractCursorPaginator) {
            $meta = [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'per_page' => $this->resource->perPage(),
                'total' => $this->resource->total(),
                'path' => $request->path(),
                'query' => http_build_query($request->query()),
            ];
        }

        return [
            'success' => true,
            'code' => $this->successCode,
            'message' => $this->message . ' (' . $this->resource->count() . ' record(s))',
            'meta' => $meta,
        ];
    }
}
