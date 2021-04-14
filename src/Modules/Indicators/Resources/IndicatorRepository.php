<?php

namespace Bancario\Modules\Indicators\Resources;

use Illuminate\Support\Facades\Schema;
use Bancario\Models\Actors\Indicator;
use Muleta\Modules\Eloquents\Displays\RepositoryAbstract;

class IndicatorRepository extends RepositoryAbstract
{
    public function __construct(Indicator $model)
    {
        $this->model = $model;
    }

    // /**
    //  * Returns all Indicators.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Collection|static[]
    //  */
    // public function all()
    // {
    //     return $this->model->all();
    //     // return $this->model->orderBy('created_at', 'desc')->all();
    // }

    // /**
    //  * Returns all paginated Indicators.
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
    //  * Stores Indicators into database.
    //  *
    //  * @param array $payload
    //  *
    //  * @return Indicators
    //  */
    // public function store($payload)
    // {
    //     return $this->model->create($payload);
    // }

    // /**
    //  * Find Indicators by given id.
    //  *
    //  * @param int $id
    //  *
    //  * @return \Illuminate\Support\Collection|null|static|Indicators
    //  */
    // public function find($id)
    // {
    //     return $this->model->find($id);
    // }

    // /**
    //  * Find Indicators by given id.
    //  *
    //  * @param int $id
    //  *
    //  * @return \Illuminate\Support\Collection|null|static|Indicators
    //  */
    // public function getByCustomer($id)
    // {
    //     return $this->model->where('user_id', '=', $id);
    // }

    // /**
    //  * Find Indicators by given id.
    //  *
    //  * @param int $id
    //  *
    //  * @return \Illuminate\Support\Collection|null|static|Indicators
    //  */
    // public function getByCustomerAndId($customer, $id)
    // {
    //     return $this->model->where('user_id', $customer)->where('id', $id)->first();
    // }

    // /**
    //  * Find Indicators by given id.
    //  *
    //  * @param int $id
    //  *
    //  * @return \Illuminate\Support\Collection|null|static|Indicators
    //  */
    // public function getByCustomerAndUuid($customer, $id)
    // {
    //     return $this->model->where('user_id', $customer)->where('uuid', $id)->first();
    // }

    // /**
    //  * Updates Indicators into database.
    //  *
    //  * @param Indicator $order
    //  * @param array  $payload
    //  *
    //  * @return Indicators
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
