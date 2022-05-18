<?php

namespace JoeriAbbo\LivewireSearch\Services\Search\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface SearchInterface
{
    /**
     * @param Builder $builder
     * @param string $field
     * @return Builder
     */
    public function orWhere(Builder $builder, string $field): Builder;

    /**
     * @param Builder $builder
     * @param array $fields
     * @return Builder
     */
    public function orWheres(Builder $builder, array $fields): Builder;
}
