<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait Filterable
{
    public function applyFilters($query, $source, $page, array $filters)
    {
        if ($source->has($page)) {
            $data = $source->get($page);

            foreach ($filters as $filter => $condition) {
                if ($filter === 'date_range') {
                    // Tratamento especial para intervalos de datas
                    $from = $data['created_at_from'] ?? null;
                    $to = $data['created_at_to'] ?? null;

                    if ($from && $to) {
                        $query->whereBetween('created_at', [$from, $to]);
                    } elseif ($from) {
                        $query->whereDate('created_at', '>=', $from);
                    } elseif ($to) {
                        $query->whereDate('created_at', '<=', $to);
                    }
                } elseif (isset($data[$filter]) && $data[$filter] !== null) {
                    $value = $data[$filter];
                    if (is_callable($condition)) {
                        $condition($query, $value);
                    } else {
                        $query->where($filter, $condition, $value);
                    }
                }
            }
        }
    }
}
