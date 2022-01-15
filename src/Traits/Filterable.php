<?php

namespace KLisica\ApiFormula\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{
    private $_DEFAULT_FREE_TEXT_FILTER = '_text';
    private $_DEFAULT_SORT_COLUMN = 'created_at';
    private $_DEFAULT_SORT_DIRECTION = 'DESC';

    private $_FILTER_OPTIONS = [
        'diff',
        'equal',
        'strict_less',
        'less',
        'strict_greater',
        'greater',
        'where_in',
        'where_between'
    ];

    /**
     * Sort data either by column or relation column.
     *
     * @param   Builder $query
     * @param   Request $params
     * @return  Builder $query
     */
    public function scopeTableSort(Builder $query, Request $params): Builder
    {
        $column = $params->sort_by ? $params->sort_by[0] : $this->_DEFAULT_SORT_COLUMN;
        $option = $params->sort_by ? $params->sort_by[1] : $this->_DEFAULT_SORT_DIRECTION;

        // If table column exist order by it.
        if ($this->columnExists($column)) {
            return $query->orderBy($column, $option);
        }

        return $query;
    }

    /**
     * Filter results by provided parameters.
     *
     * @param   Builder $query
     * @param   Request $params
     * @return  Builder $query
     */
    public function scopeFilter(Builder $query, Request $params): Builder
    {
        $params = $params->all() ?? [];
        $filterType = null;

        // Parse parameters column|option.
        foreach ($params as $column => $value) {

            // Check if filter type exists.
            if (is_array($value)) {
                foreach ($value as $key => $value) {
                    $filterType = $key;
                    $value = $value;
                }
            }

            // Check if filter type exists and is in available filters.
            if ($filterType && in_array($filterType, $this->_FILTER_OPTIONS)) {
                // Check if filter aplies for relation column.
                if (strpos($column, "|") !== false) {
                    // Filter out relations.
                    $this->filterRelations($query, explode("|", $column), $value, $filterType);
                } else {
                    // Filter current model table if column exists.
                    if ($this->columnExists($column)) {
                        $query = $this->handleFiltering($query, $filterType, $column, $value);
                    }
                }
            }

            // Run free text filter if needed
            if ($column === $this->_DEFAULT_FREE_TEXT_FILTER) {
                $query = $this->handleFreeTextFilter($query, $value);
            }
        }

        return $query;
    }

    /**
     * Handle the free text filtering.
     *
     * @param   Builder $query
     * @param   string $value
     * @return  Builder $query
     */
    public function handleFreeTextFilter(Builder $query, ?string $value): Builder
    {
        $columns = Schema::getColumnListing($query->getModel()->getTable());

        $query->where(function ($query) use ($value, $columns) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', '%' . $value . '%');
            }
        });

        return $query;
    }

    /**
     * Filter model relations.
     *
     * @param   Builder $query
     * @param   array $elements
     * @param   string $value
     * @param   string $filterType
     * @return  Builder $query
     */
    public function filterRelations(
        Builder $query,
        array $elements,
        string $value,
        string $filterType
    ): Builder
    {
        return $query->whereHas($elements[0], function ($q) use ($elements, $value, $filterType) {
            // Check if relation go deeper
            if (count($elements) > 2) {
                array_shift($elements);
                return $this->filterRelations($q, $elements, $value, $filterType);
            }

            if (Schema::hasColumn($q->getModel()->getTable(), end($elements))) {
               $this->handleFiltering($q, $filterType, end($elements), $value);
            }
        });
    }

    /**
     * Execute query filtration.
     *
     * @param   Builder $query
     * @param   string $filterType
     * @param   string $key
     * @param   string $value
     * @return  Builder $query
     */
    public function handleFiltering(
        Builder $query,
        string $filterType,
        string $key,
        string $value
    ): Builder
    {
        switch ($filterType) {
            case 'diff':
                $query->where($key, '!=', $value);
                break;
            case 'equal':
                $query->where($key, $value);
                break;
            case 'strict_less':
                $query->where($key, '<', $value);
                break;
            case 'less':
                $query->where($key, '<=', $value);
                break;
            case 'strict_greater':
                $query->where($key, '>', $value);
                break;
            case 'greater':
                $query->where($key, '>=', $value);
                break;
            case 'where_in':
                $query->whereIn($key, explode(",", $value));
                break;
            case 'where_between':
                $query->whereBetween($key, explode(",", $value));
                break;
        }

        return $query;
    }


    /**
     * Check if column exists on table.
     *
     * @param   string $key
     * @return  bool
     */
    public function columnExists(string $key): bool
    {
        return property_exists($this, 'connection')
            ? Schema::connection($this->connection)->hasColumn($this->getTable(), $key)
            : Schema::hasColumn($this->getTable(), $key);
    }
}
