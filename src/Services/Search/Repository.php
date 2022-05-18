<?php

namespace JoeriAbbo\LivewireSearch\Services\Search;

use Illuminate\Database\Eloquent\Builder;
use JoeriAbbo\LivewireSearch\Services\Search\Interfaces\SearchInterface;

class Repository implements SearchInterface
{
    /**
     * @param Builder $builder
     * @param string $field
     * @return Builder
     */
    public function orWhere(Builder $builder, string $field): Builder
    {
        $search = [];
        if (str_contains($this->search, ' ')) {
            $search = explode(' ', $this->search);
        } else {
            $search[] = $this->search;
        }


        foreach ($search as $s) {
            if (empty($s)) {
                continue;
            }
            $builder->orWhere($field, 'like', '%' . $s . '%');
        }
        return $builder;
    }

    /**
     * @param Builder $builder
     * @param array $fields
     * @return Builder
     */
    public function orWheres(Builder $builder, array $fields): Builder
    {
        return $builder->where(function ($builder) use ($fields) {
            foreach ($fields as $field) {
                $this->orWhere($builder, $field);
            }
        });
    }
}