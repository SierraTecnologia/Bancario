<?php

namespace Bancario\Builders;

use Muleta\Modules\Eloquents\Displays\BuilderAbstract as Builder;
use Illuminate\Database\Query\Expression;

/**
 * Class CandleBuilder.
 *
 * @package Bancario\Builders
 */
class CandleBuilder extends Builder
{
    // /**
    //  * @var string
    //  */
    // private $tagsTable = Tables::TABLE_TAGS;

    // /**
    //  * @var string
    //  */
    // private $postsCandlesTable = Tables::TABLE_POSTS_TAGS;

    // /**
    //  * @return $this
    //  */
    // public function defaultSelect()
    // {
    //     return $this->
    //     select(
    //         'exchange',
    //         // 'first(open, open_at) as open',
    //         // 'last(close,open_at) as close',
    //         // 'first(low, low) as low',
    //         // 'last(high,high) as high',
    //         // 'last(timestamp, timestamp) as ola',
    //         // 'last(open_at, open_at) as temporal',
    //         )
    //     ->addSelect(new Expression("time_bucket('{$timescaleService->getTimescale()}', open_at) AS buckettime"))
    //     ->addSelect(new Expression("first(open, open_at) as open"))
    //     ->addSelect(new Expression("last(close,open_at) as close"))
    //     ->addSelect(new Expression("first(low, low) as low"))
    //     ->addSelect(new Expression("last(high,high) as high"))
    //     ->addSelect(new Expression("first(timestamp, timestamp) as timestamp"))
    //     ->addSelect(new Expression("last(open_at, open_at) as time_close"))
    //     ->addSelect(new Expression("COUNT({$this->postsCandlesTable}.tag_id) AS popularity"));
    //         // select("{$this->tagsTable}.*");
    // }

    // /**
    //  * @return $this
    //  */
    // public function whereHasPosts()
    // {
    //     return $this->has('posts');
    // }

    // /**
    //  * @return $this
    //  */
    // public function whereHasNoPosts()
    // {
    //     return $this->doesntHave('posts');
    // }

    // /**
    //  * @return $this
    //  */
    // public function orderByPopularity()
    // {
    //     return $this
    //         ->addSelect(new Expression("COUNT({$this->postsCandlesTable}.tag_id) AS popularity"))
    //         ->leftJoin($this->postsCandlesTable, "{$this->postsCandlesTable}.tag_id", '=', "{$this->tagsTable}.id")
    //         ->groupBy("{$this->tagsTable}.id")
    //         ->orderBy('popularity', 'desc');
    // }
}
