<?php

namespace JoeriAbbo\LivewireSearch\Services\Search\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface SearchInterface
{
    /**
     * @param Builder $builder
     * @param string $field
     * @param string $searchValue
     * @return Builder
     */
    public function orWhere(Builder $builder, string $field, string $searchValue): Builder;

    /**
     * @param Builder $builder
     * @param array $fields
     * @param string $search
     * @return Builder
     */
    public function orWheres(Builder $builder, array $fields, string $search): Builder;
}
