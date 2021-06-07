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
use Bancario\Services\TimeScaleService;
use Illuminate\Database\Query\Expression;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CandleRepository extends RepositoryAbstract
{
    public $search = [
        [
            'name' => 'symbol',
            'label' => 'symbol',
            'type' => 'text'
        ],
        [
            'name' => 'timeframe',
            'label' => 'Timeframe Interval',
            'type' => 'select',
            'relationship' => 'timeframe'
        ],
        [
            'name' => 'exchange',
            'label' => 'Exchange',
            'type' => 'select',
            'relationship' => 'exchange'
        ],
        [
            'name' => 'last_date',
            'label' => 'Data do Último Candle',
            'type' => 'date'
        ],
    ];

    public $symbol = 'BTC-USDT';

    public $timeframe = '1d';

    public $exchange = 'Binance';
    
    public $last_date;

    protected $model;

    public function __toString() {
        return "Candles do par ".$this->symbol." na ".$this->exchange." no intervalo ".$this->timeframe;
    }

    /**
     * Para o formulário de filtro
     */
    public function getSearchFields()
    {
        return $this->search;
    }

    /**
     * Para o formulário de filtro
     */
    public function getRelationsFields()
    {
        $relationshipOptions = [];

        $relationshipOptions["timeframe"] = [
            '1m' => '1 minute',
            '5m' => '5 minutes',
            '10m' => '10 minutes',
            '15m' => '15 minutes',
            '1h' => '1 hour',
            '4h' => '4 hours',
            '1d' => '1 day',
            '1w' => '1 week',
        ];

        $relationshipOptions["exchange"] = Exchange::pluck('name','name');
        return $relationshipOptions;
    }

    public function __construct(Request $request)
    {
        $this->last_date = $request->input('last_date', Carbon::now());
        // dd(
        //     $this->last_date
        // );
    }

    public function getTicketsForChart()
    {
        // Algoritmo
        $quantityCandles = 1 * 60 * 24; // * 7;
        $tickets = $this->getBuilderQuery($this->timeframe)
        // ->where('period', $period)
        ->orderByDesc('buckettime')
        ->limit($quantityCandles)
        ->get();
        // dd($tickets[count($tickets)-1]);
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
            'value' => JesseCandle::inExchange($this->exchange)->forPair($this->symbol)->max('high'),
            // 'value' => DB::table('orders')->max('price'),
        ]);
        $metrics[] = new MetricEntity([
            'code' => 'minPrice',
            'name' => 'Preço Máximo Negociado',
            'color' => 'red',
            'value' => JesseCandle::inExchange($this->exchange)->forPair($this->symbol)->min('low'),
            // 'value' => DB::table('orders')->max('price'),
        ]);
        $metrics[] = new MetricEntity([
            'code' => 'avgClosePrice',
            'name' => 'Preço Médio',
            'color' => 'blue',
            'value' => JesseCandle::inExchange($this->exchange)->forPair($this->symbol)->avg('close'),
            // 'value' => DB::table('orders')->max('price'),
        ]);
 
        return $metrics;
    }

    public function getBuilderQuery($periodSize)
    {
        $timescaleService = new TimeScaleService($periodSize);

        
        // ->select(
        //     DB::raw(
        //         'time_bucket(\''.$timescaleService->getTimescale().'\', open_at) buckettime,
        //         exchange,
        //         first(open, open_at) as open,
        //         last(close,open_at) as close,
        //         first(low, low) as low,
        //         last(high,high) as high,
        //         last(timestamp, timestamp) as ola,
        //         last(open_at, open_at) as temporal,
        //         SUM(volume) AS volume'
        //     )
        // )
        // $query = JesseCandle::inExchange($this->exchange)->forPair($this->symbol);
        $query = Candle::select(
            'exchange',
            // 'first(open, open_at) as open',
            // 'last(close,open_at) as close',
            // 'first(low, low) as low',
            // 'last(high,high) as high',
            // 'last(timestamp, timestamp) as ola',
            // 'last(open_at, open_at) as temporal',
            )
        ->addSelect(new Expression("time_bucket('{$timescaleService->getTimescale()}', open_at) AS buckettime"))
        ->addSelect(new Expression("first(open, open_at) as open"))
        ->addSelect(new Expression("last(close,open_at) as close"))
        ->addSelect(new Expression("first(low, low) as low"))
        ->addSelect(new Expression("last(high,high) as high"))
        ->addSelect(new Expression("first(timestamp, timestamp) as timestamp"))
        ->addSelect(new Expression("last(open_at, open_at) as time_close"))
        // ->addSelect(new Expression("AVG(count)
        // OVER(PARTITION BY buckettime ORDER BY buckettime, open_at ROWS BETWEEN CURRENT ROW AND 7 Following) AS mediamovel_setedias"))
        ->whereNotNull('open_at')
        ->whereDate('open_at', '<', $this->last_date)
        ->groupBy('buckettime')->groupBy('exchange');
        // ->groupBy('exchange, buckettime')
        // ->get();
        return $query;
        
        // // SELECT time_bucket('$timescale', open_at) buckettime,
        //     exchange,
        //     first(open, open_at) as open,
        //     last(close,open_at) as close,
        //     first(low, low) as low,
        //     last(high,high) as high,
        //     last(timestamp, timestamp) as ola,
        //     last(open_at, open_at) as temporal,
        //     SUM(volume) AS volume ". //,
        // //     // AVG(bid) AS avgbid,
        // //     // AVG(ask) AS avgask,
        // //     // AVG(volume) AS avgvolume
        // //     "FROM candle
        // // WHERE symbol = '$pair'
        // // AND open_at IS NOT NULL
        // // GROUP BY exchange, buckettime 
        // // ORDER BY buckettime ASC   

        // dd(
        //     $users[0]
        // );
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
     * Ultimos 168 Registros
     * 
     * @param string $pair
     * @param int    $limit
     * @param bool   $day_data
     * @param int    $hour
     * @param string $periodSize
     * @param bool   $returnRS
     *
     * @return array
     */
    public function getRecentData($pair='BTC-USDT', $periodSize='1h', $limit=168, $returnRS=false)
    {
        /**
         *  we need to cache this as many strategies will be
         *  doing identical pulls for signals.
         */
        $connection_name = config('database.default');
        // $key = 'recent::'.$pair.'::'.$limit."::$day_data::$hour::$periodSize::$connection_name";
        // if(\Cache::has($key)) {
        //     return \Cache::get($key);
        // }

        $timeslice = 60;
        $timescale = false;
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
        if ($timescale === false) {
            throw new Exception("Timeframe inválido. ".$periodSize, 1);
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
    //     dd("
    //     SELECT time_bucket('$timescale', open_at) buckettime,
    //         exchange,
    //         first(open, open_at) as open,
    //         last(close, open_at) as close,
    //         first(low, low) as low,
    //         last(high, high) as high,
    //         last(timestamp, timestamp) as data_timestamp,
    //         last(open_at, open_at) as data_inicio,
    //         SUM(volume) AS volume ". //,
    //         // AVG(bid) AS avgbid,
    //         // AVG(ask) AS avgask,
    //         // AVG(volume) AS avgvolume
    //         "FROM candle
    //     WHERE symbol = '$pair'
    //     AND open_at IS NOT NULL
    //     AND extract(epoch from open_at) > ($offset)
    //     GROUP BY exchange, buckettime 
    //     ORDER BY buckettime DESC   
    // ");
        if ($connection_name == 'pgsql') {
            try {
                // timescale query
                $results = DB::select(
                    DB::raw(
                        "
                    SELECT time_bucket('$timescale', open_at) buckettime,
                        exchange,
                        first(open, open_at) as open,
                        last(close, open_at) as close,
                        first(low, low) as low,
                        last(high, high) as high,
                        last(timestamp, timestamp) as data_timestamp,
                        last(open_at, open_at) as data_inicio,
                        SUM(volume) AS volume ". //,
                        // AVG(bid) AS avgbid,
                        // AVG(ask) AS avgask,
                        // AVG(volume) AS avgvolume
                        "FROM candle
                    WHERE symbol = '$pair'
                    AND open_at IS NOT NULL
                    AND extract(epoch from open_at) > ($offset)
                    GROUP BY exchange, buckettime 
                    ORDER BY buckettime DESC   
                "
                    )
                );
                // echo "test:" . $offset;
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
                exchange,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY open_at), ',', 1 ) AS `open`,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY bid DESC), ',', 1 ) AS `high`,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY bid), ',', 1 ) AS `low`,
                SUBSTRING_INDEX(GROUP_CONCAT(CAST(bid AS CHAR) ORDER BY open_at DESC), ',', 1 ) AS `close`,
                SUM(volume) AS volume,
                ROUND((CEILING(UNIX_TIMESTAMP(`open_at`) / $timeslice) * $timeslice)) AS buckettime,
                round(AVG(bid),11) AS avgbid,
                round(AVG(ask),11) AS avgask,
                AVG(volume) AS avgvolume
              FROM candle
              WHERE symbol = '$pair'
              AND open_at IS NOT NULL
              AND UNIX_TIMESTAMP(`open_at`) > ($offset)
              GROUP BY exchange, buckettime 
              ORDER BY buckettime DESC
          "
                )
            );
        }
        // dd($results[0]);
        // if ($returnRS) {
        //     $ret = $results;
        // } else {
        //     $ret = $this->organizePairData($results, $limit);
        // }

        // \Cache::put($key, $ret, 2);
        return $results;
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
