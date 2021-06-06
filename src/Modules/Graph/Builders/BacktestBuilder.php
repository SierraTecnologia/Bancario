<?php

namespace Bancario\Modules\Graph\Builders;

// use Population\Manipule\Managers\Photo\ARPhotoManager;
// use Population\Manipule\Managers\Tag\ARTagManager;
// use Siravel\Models\Post;
// use Siravel\Models\Tag;
// use Siravel\Services\SiteMap\Contracts\SiteMapBuilder as SiteMapBuilder;
use Illuminate\Support\Collection;
// use SiObjects\Mount\SiteMap\Contracts\Builder;
// use SiObjects\Mount\SiteMap\Item;
// use function SiUtils\Helper\url_frontend;
// use function SiUtils\Helper\url_frontend_photo;
// use function SiUtils\Helper\url_frontend_tag;
use Bancario\Models\Tradding\Exchange;
use Bancario\Models\Jesse\Candle;
use Bancario\Models\Jesse\Graph;
use Bancario\Models\Jesse\GraphIndicator;
use Illuminate\Support\Facades\DB;

/**
 * Class GraphMetricsBuilder.
 *
 * @package Siravel\Services\SiteMap
 */
class BacktestBuilder
{
    // public $indicators = [
    //     \Bancario\Modules\Indicators\Base\MediaMovelIndicator::class,
    // ];

    /**
     * @inheritdoc
     */
    public function build()
    {
        $graph = Graph::updateOrCreate(
            [
                'graph_id'      => '\Bancario\Models\Money\Pair',
                'graph_type'    => 'BTC-USDT',
                'abrangencia_id'      => Exchange::class,
                'abrangencia_type'    => 'Binance',
            ],
            [
                'timestamp' => time()
            ]
        );
        $indicators = [
            
        ];
        foreach ($this->indicators as $indicator) {
            $indicators[] = new $indicator;
        }
        $symbol = 'BTC-USDT';
        $exchangeCode = 'Binance';

        // Algoritmo
        DB::table('candle')->where('exchange', $exchangeCode)->where('symbol', $symbol)
        // Candle::inExchange($exchangeCode)->forPair($symbol)
        // ->where('period', $period)
        ->orderBy('timestamp')
        ->chunk(
            50, function (Collection $tickets) use ($indicators, $graph) {
                $tickets->each(
                    function ($ticket) use ($indicators, $graph) {
                        foreach ($indicators as $indicator) {
                            $parcialValue = $indicator->runForEach($ticket->close);
                            \DB::table('graphables')->insert([
                                [
                                    'graphable_id' => $indicator->getCode(),
                                    'graphable_type' => 'indicator',
                                    'graph_id' => $graph->id,
                                    'timestamp' => $ticket->timestamp,
                                    'value' => $parcialValue,
                                ],
                            ]);
                            // GraphIndicator::updateOrCreate(
                            //     [
                            //         'code' => $indicator->getCode(),
                            //         'timestamp' => $ticket->timestamp,
                            //         'graph_id' => $graph->id
                            //     ],
                            //     [
                            //         'value' => $parcialValue,
                            //     ]
                            // );
                        }
                    }
                );
            }
        );

    }

    // /**
    //  * @var Builder
    //  */
    // private $siteMapBuilder;

    // /**
    //  * @var ARPhotoManager
    //  */
    // private $photoManager;

    // /**
    //  * @var ARTagManager
    //  */
    // private $tagManager;

    // /**
    //  * GraphMetricsBuilder constructor.
    //  *
    //  * @param Builder        $siteMapBuilder
    //  * @param ARPhotoManager $photoManager
    //  * @param ARTagManager   $tagManager
    //  */
    // public function __construct(Builder $siteMapBuilder, ARPhotoManager $photoManager, ARTagManager $tagManager)
    // {
    //     $this->siteMapBuilder = $siteMapBuilder;
    //     $this->photoManager = $photoManager;
    //     $this->tagManager = $tagManager;
    // }

    // /**
    //  * @inheritdoc
    //  */
    // public function build(): Builder
    // {
    //     $items = collect();

    //     $items->push(
    //         (new Item)
    //             ->setLocation(url_frontend())
    //             ->setChangeFrequency('weekly')
    //             ->setPriority('1')
    //     );

    //     $items->push(
    //         (new Item)
    //             ->setLocation(url_frontend('/contact-me'))
    //             ->setChangeFrequency('monthly')
    //             ->setPriority('0.2')
    //     );

    //     $items->push(
    //         (new Item)
    //             ->setLocation(url_frontend('/subscription'))
    //             ->setChangeFrequency('monthly')
    //             ->setPriority('0.2')
    //     );

    //     (new Post)
    //         ->newQuery()
    //         ->whereIsPublished()
    //         ->chunk(
    //             50, function (Collection $posts) use ($items) {
    //                 $posts->each(
    //                     function (Post $post) use ($items) {
    //                         $items->push(
    //                             (new Item)
    //                                 ->setLocation(url_frontend_photo($post->id))
    //                                 ->setLastModified($post->updated_at->toAtomString())
    //                                 ->setChangeFrequency('weekly')
    //                                 ->setPriority('0.7')
    //                         );
    //                     }
    //                 );
    //             }
    //         );

    //     (new Tag)
    //         ->newQuery()
    //         ->defaultSelect()
    //         ->orderByPopularity()
    //         ->chunk(
    //             50, function (Collection $tags) use ($items) {
    //                 $tags->each(
    //                     function (Tag $tag) use ($items) {
    //                         $items->push(
    //                             (new Item)
    //                                 ->setLocation(url_frontend_tag($tag->value))
    //                                 ->setChangeFrequency('weekly')
    //                                 ->setPriority('0.4')
    //                         );
    //                     }
    //                 );
    //             }
    //         );

    //     $this->siteMapBuilder->setItems($items->toArray());

    //     return $this->siteMapBuilder;
    // }
}
