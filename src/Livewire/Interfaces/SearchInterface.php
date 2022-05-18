<?php

namespace JoeriAbbo\LivewireSearch\Livewire\Interfaces;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

interface SearchInterface
{
    /**
     * @return Factory|View|Application
     */
    public function render(): \Illuminate\Contracts\View\Factory|View|\Illuminate\Contracts\Foundation\Application;

    /**
     * @return string
     */
    public static function getView(): string;

    /**
     * @return Model
     */
    public static function getClass(): string;

    /**
     * @param $builder
     * @return Builder
     */
    public function getSearchBuilder($builder): Builder;
}
