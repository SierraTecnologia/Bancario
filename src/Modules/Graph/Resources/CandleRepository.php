<?php

namespace Bancario\Modules\Graph\Resources;

use Illuminate\Support\Facades\Schema;
use Bancario\Models\Jesse\Candle;
use Muleta\Modules\Eloquents\Displays\RepositoryAbstract;
use Illuminate\Support\Facades\DB;
use Bancario\Models\Tradding\Exchange;
use Bancario\Models\Jesse\Ticker as JesseTicker;
use Bancario\Models\Jesse\Candle as JesseCandle;
use Bancario\Modules\Metrics\Resources\MetricEntity;

class CandleRepository extends RepositoryAbstract
{
    public $search = [
        [
            'name' => 'symbol',
            'label' => 'symbol',
            'type' => 'text'
        ],
        [
            'name' => 'interval',
            'label' => 'interval',
            'type' => 'text'
        ],
        [
            'name' => 'exchange',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        ['name' => 'after_date', 'label' => 'Publish Date', 'type' => 'date'],
    ];

    public $symbol = 'BTC-USDT';

    public $interval = '1m';

    public $exchange = 'Binance';
    
    public $after_date;

    protected $model;

    public function getRelations()
    {
        $relationshipOptions = [];
        $relationshipOptions["exchange"] = Exchange::pluck('name','name');
        return $relationshipOptions;
    }

    public function __toString() {
        return "Candles do par ".$this->symbol." na ".$this->exchange." no intervalo ".$this->interval;
    }

    public function setSearchParamsAndReturnFields($request)
    {
        return $this->search;
    }

    public function getTicketsForChart()
    {
        // Algoritmo
        $quantityCandles = 1 * 60 * 24; // * 7;
        $tickets = $this->getBuilderQuery()
        // ->where('period', $period)
        ->orderByDesc('timestamp')
        ->limit($quantityCandles)
        ->get();
        
        return $tickets->map(function ($tick) {
            return '{
                x: new Date('.$tick->timestamp.'),
                y: ['.$tick->open.', '.$tick->high.', '.$tick->low.', '.$tick->close.']
              }';
        });
    }

    public function getMetrics()
    {
        $metrics = [];
        $metrics[] = new MetricEntity([
            'code' => 'maxPrice',
            'name' => 'Preço Máximo Negociado',
            'color' => 'green',
            'value' => $this->getBuilderQuery()->max('high'),
            // 'value' => DB::table('orders')->max('price'),
        ]);
        $metrics[] = new MetricEntity([
            'code' => 'minPrice',
            'name' => 'Preço Máximo Negociado',
            'color' => 'red',
            'value' => $this->getBuilderQuery()->min('low'),
            // 'value' => DB::table('orders')->max('price'),
        ]);
        $metrics[] = new MetricEntity([
            'code' => 'avgClosePrice',
            'name' => 'Preço Médio',
            'color' => 'blue',
            'value' => $this->getBuilderQuery()->avg('close'),
            // 'value' => DB::table('orders')->max('price'),
        ]);

        return $metrics;
    }

    public function getBuilderQuery()
    {
        return JesseCandle::inExchange($this->exchange)->forPair($this->symbol);
    }

    public function model()
    {
        return Candle::class;
    }

    /**
     * Find Strategies by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Strategies
     */
    public function getDatatable($dateInterval)
    {


        // return $this->model->where('user_id', '=', $id);
    }

    /**
     * @param string $pair
     * @param int    $limit
     * @param bool   $day_data
     * @param int    $hour
     * @param string $periodSize
     * @param bool   $returnRS
     *
     * @return array
     */
    public function getRecentData($pair='BTC-USDT', $limit=168, $day_data=false, $hour=12, $periodSize='1m', $returnRS=false)
    {
        /**
         *  we need to cache this as many strategies will be
         *  doing identical pulls for signals.
         */
        $connection_name = config('database.default');
        $key = 'recent::'.$pair.'::'.$limit."::$day_data::$hour::$periodSize::$connection_name";
        if(\Cache::has($key)) {
            return \Cache::get($key);
        }

        $timeslice = 60;
        switch($periodSize) {
        case '1m':
            $timescale = '1 minute';
            $timeslice = 60;
            break;
        case '5m':
            $timescale = '5 minutes';
            $timeslice = 300;
            break;
        case '10m':
            $timescale = '10 minutes';
            $timeslice = 600;
            break;
        case '15m':
            $timescale = '15 minutes';
            $timeslice = 900;
            break;
        case '30m':
            $timescale = '30 minutes';
            $timeslice = 1800;
            break;
        case '1h':
            $timescale = '1 hour';
            $timeslice = 3600;
            break;
        case '4h':
            $timescale = '4 hours';
            $timeslice = 14400;
            break;
        case '1d':
            $timescale = '1 day';
            $timeslice = 86400;
            break;
        case '1w':
            $timescale = '1 week';
            $timeslice = 604800;
            break;
        }
        $current_time = time();
        $offset = ($current_time - ($timeslice * $limit)) -1;

        /**
         *  The time slicing queries in various databases are done differently.
         *  Postgres supports series() mysql does not, timescale has buckets, the others don't etc.
         *  having support for timescaledb is important for the scale of the project.
         *
         *  none of these queries can be done through our eloquent models unfortunately.
         */
        if ($connection_name == 'pgsql') {
            try {
                // timescale query
                $results = DB::select(
                    DB::raw(
                        "
                    SELECT time_bucket('$timescale', date(timestamp::DATE)) buckettime,
                        exchange_code,
                        first(open, timestamp) as open,
                        last(close,timestamp) as close,
                        first(low, low) as low,
                        last(high,high) as high,
                        SUM(base_volume) AS volume ". //,
                        // AVG(bid) AS avgbid,
                        // AVG(ask) AS avgask,
                        // AVG(base_volume) AS avgvolume
                        "FROM candle
                    WHERE symbol = '$pair'
                    AND extract(epoch from timestamp) > ($offset)
                    GROUP BY exchange_code, buckettime 
                    ORDER BY buckettime DESC   
                "
                    )
                );
                echo "test:" . $offset;
                //code...
            } catch (\Throwable $th) {
                dd($th);
                //throw $th;
                // regular psql query
                // TODO
                die("TimescaleDB extension required for Postgres. see timescale.com\n");
            }
        } else {
            // mysql query
            $results = DB::select(
                DB::raw(
                    "
              SELECT 
                exchange_code,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY created_at), ',', 1 ) AS `open`,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY bid DESC), ',', 1 ) AS `high`,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY bid), ',', 1 ) AS `low`,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY created_at DESC), ',', 1 ) AS `close`,
                SUM(base_volume) AS volume,
                ROUND((CEILING(UNIX_TIMESTAMP(`created_at`) / $timeslice) * $timeslice)) AS buckettime,
                round(AVG(bid),11) AS avgbid,
                round(AVG(ask),11) AS avgask,
                AVG(base_volume) AS avgvolume
              FROM candle
              WHERE symbol = '$pair'
              AND UNIX_TIMESTAMP(`created_at`) > ($offset)
              GROUP BY exchange_code, buckettime 
              ORDER BY buckettime DESC
          "
                )
            );
        }

        // if ($returnRS) {
        //     $ret = $results;
        // } else {
        //     $ret = $this->organizePairData($results, $limit);
        // }

        // \Cache::put($key, $ret, 2);
        return $ret;
    }

    // /**
    //  * Returns all Strategies.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Collection|static[]
    //  */
    // public function all()
    // {
    //     return $this->model->all();
    //     // return $this->model->orderBy('created_at', 'desc')->all();
    // }

    // /**
    //  * Returns all paginated Strategies.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Collection|static[]
    //  */
    // public function paginated()
    // {
    //     if (isset(request()->dir) && isset(request()->field)) {
    //         $model = $this->model->orderBy(request()->field, request()->dir);
    //     } else {
    //         $model = $this->model->orderBy('created_at', 'desc');
    //     }

    //     return $model->paginate(\Illuminate\Support\Facades\Config::get('siravel.pagination', 25));
    // }

    // /**
    //  * Searches the orders.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Collection|static[]
    //  */
    // public function search($payload, $count)
    // {
    //     $query = $this->model->orderBy('created_at', 'desc');

    //     $columns = Schema::getColumnListing('orders');
    //     $query->where('id', '>', 0);
    //     $query->where('id', 'LIKE', '%'.$payload.'%');

    //     foreach ($columns as $attribute) {
    //         $query->orWhere($attribute, 'LIKE', '%'.$payload.'%');
    //     }

    //     return [$query, $payload, $query->paginate($count)->render()];
    // }

    // /**
    //  * Stores Strategies into database.
    //  *
    //  * @param array $payload
    //  *
    //  * @return Strategies
    //  */
    // public function store($payload)
    // {
    //     return $this->model->create($payload);
    // }

    // /**
    //  * Find Strategies by given id.
    //  *
    //  * @param int $id
    //  *
    //  * @return \Illuminate\Support\Collection|null|static|Strategies
    //  */
    // public function find($id)
    // {
    //     return $this->model->find($id);
    // }

    // /**
    //  * Find Strategies by given id.
    //  *
    //  * @param int $id
    //  *
    //  * @return \Illuminate\Support\Collection|null|static|Strategies
    //  */
    // public function getByCustomerAndId($customer, $id)
    // {
    //     return $this->model->where('user_id', $customer)->where('id', $id)->first();
    // }

    // /**
    //  * Find Strategies by given id.
    //  *
    //  * @param int $id
    //  *
    //  * @return \Illuminate\Support\Collection|null|static|Strategies
    //  */
    // public function getByCustomerAndUuid($customer, $id)
    // {
    //     return $this->model->where('user_id', $customer)->where('uuid', $id)->first();
    // }

    // /**
    //  * Updates Strategies into database.
    //  *
    //  * @param Candle $order
    //  * @param array  $payload
    //  *
    //  * @return Strategies
    //  */
    // public function update($order, $payload)
    // {
    //     if (isset($payload['is_shipped'])) {
    //         $payload['is_shipped'] = true;
    //     } else {
    //         $payload['is_shipped'] = false;
    //     }

    //     return $order->update($payload);
    // }
}
