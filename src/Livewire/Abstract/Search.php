<?php

namespace JoeriAbbo\LivewireSearch\Livewire\Abstract;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use JoeriAbbo\LivewireSearch\Livewire\Interfaces\SearchInterface;
use JoeriAbbo\LivewireSearch\Services\Search\Repository;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

abstract class Search extends Component implements SearchInterface
{
    protected Repository $repository;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->repository = new Repository();
    }

    use WithPagination;

    /**
     * @var string
     */
    public string $search = '';

    /**
     * @return string
     */
    abstract public static function getView(): string;

    /**
     * @return int
     */
    public function getPaginateNumber(): int
    {
        return 60;
    }

    /**
     * @return Model
     */
    abstract public static function getClass(): string;

    /**
     * @param $builder
     * @return Builder
     */
    abstract public function getSearchBuilder($builder): Builder;

    /**
     * @return Factory|View|Application
     */
    public function render(): \Illuminate\Contracts\View\Factory|View|\Illuminate\Contracts\Foundation\Application
    {
        return view(static::getView(), [
            'items' => $this
                ->getSearchBuilder(static::getClass()::query())
                ->paginate($this->getPaginateNumber())
        ]);
    }
}
