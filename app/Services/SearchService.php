<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class SearchService
{
    /**
     *
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function buildDynamicQuery(Builder $query, array $params): Builder
    {
        $after = $params['after'] ?? null;
        $before = $params['before'] ?? null;
        $filters = $params['filters'] ?? [];
        $searchTerms = $params['search_terms'] ?? [];
        $order = $params['order'] ?? 'asc';
        $first = $params['first'] ?? null;
        $last = $params['last'] ?? null;

        // Handling 'after' and 'before' for pagination (assuming `id` is the cursor)
        if ($after) {
            $query->where('id', '>', $after);
        }

        if ($before) {
            $query->where('id', '<', $before);
        }

        // Applying filters
        foreach ($filters as $filter) {
            if (isset($filter['field'], $filter['value'])) {
                $query->where($filter['field'], $filter['value']);
            }
        }

        // Applying search terms
        if (!empty($searchTerms)) {
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    if (isset($term['field'], $term['value'], $term['match'])) {
                        if ($term['match'] === '%like%') {
                            $q->orWhere($term['field'], 'LIKE', '%' . $term['value'] . '%');
                        } elseif ($term['match'] === 'match') {
                            $q->orWhere($term['field'], '=', $term['value']);
                        }
                    }
                }
            });
        }

        // Sorting
        $query->orderBy('id', $order === 'asc' ? 'asc' : 'desc');

        // Handling 'first' and 'last' for limiting results
        if ($first) {
            $query->limit($first);
        } elseif ($last) {
            $query->limit($last)->orderBy('id', $order === 'asc' ? 'desc' : 'asc');
        }

        return $query;
    }

    /**
     *
     * @param \Illuminate\Database\Eloquent\Collection $results
     * @param int $totalCount
     * @param string|null $startCursor
     * @param string|null $endCursor
     * @param bool $hasNextPage
     * @param bool $hasPreviousPage
     * @return array
     */
    public function buildDynamicResponse($results, int $totalCount, ?string $startCursor, ?string $endCursor, bool $hasNextPage, bool $hasPreviousPage): array
    {
        $edges = $results->map(function ($result) {
            return [
                'cursor' => (string) $result->id,
                'node' => $result,
            ];
        });

        return [
            'total_count' => $totalCount,
            'edges' => $edges,
            'pageInfo' => [
                'start_cursor' => $startCursor,
                'end_cursor' => $endCursor,
                'has_next_page' => $hasNextPage,
                'has_previous_page' => $hasPreviousPage,
            ],
        ];
    }
}