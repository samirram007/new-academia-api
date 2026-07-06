<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasAdvancedFilter
{
    /**
     * Apply pagination, search, and filter logic to a query.
     *
     * Query params supported:
     *   ?page=1&per_page=10          — pagination
     *   ?search=term                 — search across searchable fields
     *   ?campus_id=1&floor_id=2     — filter by belongsTo foreign keys
     *   ?campus_id=-1               — -1 means "all" (no filter applied)
     *   ?date_from=2025-01-01       — filter records on or after this date (uses created_at)
     *   ?date_to=2025-03-15         — filter records on or before this date (uses created_at)
     *
     * @param  Builder  $query
     * @param  Request  $request
     * @param  array    $options  Optional override: searchable, filterable, defaultPerPage, dateField
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function applyAdvancedFilter(Builder $query, Request $request, array $options = [])
    {
        $searchable = $options['searchable'] ?? $this->getSearchableFields($query);
        $filterable = $options['filterable'] ?? $this->getFilterableFields($query);
        $defaultPerPage = $options['defaultPerPage'] ?? 10;
        $dateField = $options['dateField'] ?? 'created_at';

        // Apply search
        if ($search = $request->input('search')) {
            $query->where(function (Builder $q) use ($search, $searchable) {
                foreach ($searchable as $field) {
                    $q->orWhere($field, 'LIKE', "%{$search}%");
                }
            });
        }

        // Apply filters from request (e.g., ?campus_id=1)
        foreach ($filterable as $field) {
            if ($request->has($field)) {
                $value = $request->input($field);
                // -1 means "all" — skip the filter
                if ($value !== null && $value !== '' && $value !== '-1') {
                    $query->where($field, $value);
                }
            }
        }

        // Apply global date range filter (supports both date_from/date_to and from/to)
        if ($request->filled('date_from')) {
            $query->whereDate($dateField, '>=', $request->input('date_from'));
        } elseif ($request->filled('from')) {
            $query->whereDate($dateField, '>=', $request->input('from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate($dateField, '<=', $request->input('date_to'));
        } elseif ($request->filled('to')) {
            $query->whereDate($dateField, '<=', $request->input('to'));
        }

        // Apply sorting
        if ($sortBy = $request->input('sort_by')) {
            // Only allow safe column names to prevent SQL injection
            if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $sortBy)) {
                $sortOrder = strtolower($request->input('sort_order', 'asc')) === 'desc' ? 'desc' : 'asc';
                $query->orderBy($sortBy, $sortOrder);
            }
        }

        // Paginate if page param is present, otherwise return all
        if ($request->has('page')) {
            $perPage = $request->input('per_page', $defaultPerPage);
            return $query->paginate((int) $perPage)->withQueryString();
        }

        return $query->get();
    }

    /**
     * Infer searchable fields from the model's $fillable (string fields only).
     */
    protected function getSearchableFields(Builder $query): array
    {
        $model = $query->getModel();
        $fillable = $model->getFillable();
        $casts = $model->getCasts();

        // Only include string-type fillable fields
        $stringFields = [];
        foreach ($fillable as $field) {
            $cast = $casts[$field] ?? null;
            // Skip if cast to non-string type
            if ($cast && in_array($cast, ['int', 'integer', 'float', 'double', 'bool', 'boolean', 'array', 'json', 'object', 'collection', 'date', 'datetime', 'timestamp'])) {
                continue;
            }
            // Skip common non-searchable fields
            if (str_ends_with($field, '_id') || str_ends_with($field, '_at') || $field === 'id') {
                continue;
            }
            $stringFields[] = $field;
        }

        // Fallback to common searchable fields if none detected
        if (empty($stringFields)) {
            $stringFields = ['name', 'code', 'description', 'email', 'phone'];
        }
        \Log::info($stringFields);
        return $stringFields;
    }

    /**
     * Infer filterable fields from the model's fillable (foreign keys ending in _id).
     */
    protected function getFilterableFields(Builder $query): array
    {
        $model = $query->getModel();
        $fillable = $model->getFillable();

        $filterFields = [];
        foreach ($fillable as $field) {
            // Only include foreign key fields (ending in _id)
            if (str_ends_with($field, '_id') && $field !== 'id') {
                $filterFields[] = $field;
            }
        }

        return $filterFields;
    }
}
