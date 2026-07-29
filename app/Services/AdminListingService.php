<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminListingService
{
    protected Request $request;

    protected int $defaultPerPage = 20;

    protected int $maxPerPage = 100;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply search, filters, sorting, and pagination to a query.
     *
     * @param  Builder  $query
     * @param  array  $searchable  Columns to search against (supports relation.column e.g., 'user.firstname')
     * @param  array  $filters  Map of field => allowed values
     * @param  string  $defaultSort  Default sort column
     * @param  string  $defaultDir  Default sort direction ('asc'|'desc')
     * @return array
     */
    public function process(Builder $query, array $searchable = [], array $filters = [], string $defaultSort = 'id', string $defaultDir = 'desc'): array
    {
        $search = $this->request->get('search');
        $sortField = $this->request->get('sort', $defaultSort);
        $sortDir = $this->request->get('direction', $defaultDir);
        $perPage = min((int) $this->request->get('per_page', $this->defaultPerPage), $this->maxPerPage);

        // Search
        if ($search && ! empty($searchable)) {
            $query->where(function (Builder $q) use ($search, $searchable) {
                foreach ($searchable as $field) {
                    if (strpos($field, '.') !== false) {
                        [$relation, $col] = explode('.', $field);
                        $q->orWhereHas($relation, function ($relQuery) use ($col, $search) {
                            $relQuery->where($col, 'like', "%{$search}%");
                        });
                    } else {
                        $q->orWhere($field, 'like', "%{$search}%");
                    }
                }
            });
        }

        // Filters
        $appliedFilters = [];
        foreach ($filters as $field => $allowed) {
            $value = $this->request->get("filter_{$field}");
            if ($value !== null && $value !== '' && (empty($allowed) || in_array($value, $allowed, true))) {
                if (strpos($field, '.') !== false) {
                    [$relation, $col] = explode('.', $field);
                    $query->whereHas($relation, function ($relQuery) use ($col, $value) {
                        $relQuery->where($col, $value);
                    });
                } else {
                    $query->where($field, $value);
                }
                $appliedFilters[$field] = $value;
            }
        }

        // Sort (Basic sorting, bypass if sorting on related columns to avoid complex joins for now)
        if (strpos($sortField, '.') === false) {
            $query->orderBy($sortField, $sortDir);
        } else {
            // Default to ID order if sortField contains relationship to avoid query errors
            $query->orderBy('id', $sortDir);
        }

        $items = $query->paginate($perPage)->appends($this->request->query());

        return [
            'items' => $items,
            'sortField' => $sortField,
            'sortDir' => $sortDir,
            'search' => $search,
            'appliedFilters' => $appliedFilters,
            'perPage' => $perPage,
        ];
    }
}
