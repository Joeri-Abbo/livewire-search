<?php

namespace JoeriAbbo\LivewireSearch\Tests\Unit;

use Illuminate\Database\Eloquent\Builder;
use JoeriAbbo\LivewireSearch\Services\Search\Repository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Repository::class)]
class RepositoryTest extends TestCase
{
    private Repository $repository;

    protected function setUp(): void
    {
        $this->repository = new Repository();
    }

    public function test_orWhere_with_simple_value(): void
    {
        $builder = $this->createMock(Builder::class);
        $builder->expects($this->once())
            ->method('orWhere')
            ->with('name', 'like', '%john%')
            ->willReturnSelf();

        $result = $this->repository->orWhere($builder, 'name', 'john');
        $this->assertSame($builder, $result);
    }

    public function test_orWhere_with_pipe_separated_values(): void
    {
        $builder = $this->createMock(Builder::class);
        $builder->expects($this->exactly(2))
            ->method('orWhere')
            ->willReturnSelf();

        $result = $this->repository->orWhere($builder, 'name', 'john|jane');
        $this->assertSame($builder, $result);
    }

    public function test_orWhere_skips_empty_string(): void
    {
        $builder = $this->createMock(Builder::class);
        $builder->expects($this->never())
            ->method('orWhere');

        $result = $this->repository->orWhere($builder, 'name', '');
        $this->assertSame($builder, $result);
    }

    public function test_orWhere_skips_empty_pipe_segments(): void
    {
        $builder = $this->createMock(Builder::class);
        $builder->expects($this->once())
            ->method('orWhere')
            ->with('name', 'like', '%john%')
            ->willReturnSelf();

        $result = $this->repository->orWhere($builder, 'name', 'john|');
        $this->assertSame($builder, $result);
    }

    public function test_orWheres_applies_closure_for_each_field(): void
    {
        $innerBuilder = $this->createMock(Builder::class);
        $innerBuilder->expects($this->exactly(2))
            ->method('orWhere')
            ->willReturnSelf();

        $builder = $this->createMock(Builder::class);
        $builder->expects($this->once())
            ->method('where')
            ->willReturnCallback(function ($callback) use ($innerBuilder) {
                $callback($innerBuilder);
                return $innerBuilder;
            });

        $result = $this->repository->orWheres($builder, ['name', 'email'], 'john');
        $this->assertNotNull($result);
    }
}
