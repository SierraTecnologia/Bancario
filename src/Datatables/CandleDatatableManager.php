<?php
/**
 * @todo Fazer, nao feita ainda !
 */
namespace Bancario\Datatables;

use Bancario\Models\Midia\Money;
use Config;
use CryptoService;
use Illuminate\Support\Facades\Schema;

class MoneyRepository // extends Repository
{
    public $model;

    public $table;

    public function __construct(Money $model)
    {
        $this->model = $model;
        $this->table = 'moneys';
    }

    public function published()
    {
        return $this->model->where('is_published', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(Config::get('cms.pagination', 24));
    }

    /**
     * Returns all Moneys for the API.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function apiPrepared()
    {
        return $this->model->orderBy('created_at', 'desc')->where('is_published', 1)->get();
    }

    /**
     * Returns all Moneys for the API.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getMoneysByTag($tag = null)
    {
        $moneys = $this->model->orderBy('created_at', 'desc')->where('is_published', 1);

        if (!is_null($tag)) {
            $moneys->where('tags', 'LIKE', '%'.$tag.'%');
        }

        return $moneys;
    }

    /**
     * Returns all Moneys tags.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allTags()
    {
        $tags = [];
        $moneys = $this->model->orderBy('created_at', 'desc')->where('is_published', 1)->get();

        foreach ($moneys as $money) {
            foreach (explode(',', $money->tags) as $tag) {
                if ($tag > '') {
                    array_push($tags, $tag);
                }
            }
        }

        return array_unique($tags);
    }

    /**
     * Stores Moneys into database.
     *
     * @param array $input
     *
     * @return Moneys
     */
    public function apiStore($input)
    {
        $savedFile = app(FileService::class)->saveClone($input['location'], 'public/moneys');

        if (!$savedFile) {
            return false;
        }

        $input['is_published'] = 1;
        $input['location'] = $savedFile['name'];
        $input['storage_location'] = config('cms.storage-location');
        $input['original_name'] = $savedFile['original'];

        $money = $this->model->create($input);
        $money->setCaches();

        return $money;
    }

    /**
     * Stores Moneys into database.
     *
     * @param array $input
     *
     * @return Moneys
     */
    public function store($input)
    {
        $savedFile = $input['location'];

        if (!$savedFile) {
            Facilitador::notification('Money could not be saved.', 'danger');

            return false;
        }

        if (!isset($input['is_published'])) {
            $input['is_published'] = 0;
        } else {
            $input['is_published'] = 1;
        }

        $input['location'] = CryptoService::decrypt($savedFile['name']);
        $input['storage_location'] = config('cms.storage-location');
        $input['original_name'] = $savedFile['original'];

        $money = $this->model->create($input);
        $money->setCaches();

        return $money;
    }

    /**
     * Updates Moneys
     *
     * @param Moneys $moneys
     * @param array  $input
     *
     * @return Moneys
     */
    public function update($money, $input)
    {
        if (isset($input['location']) && !empty($input['location'])) {
            $savedFile = app(FileService::class)->saveFile($input['location'], 'public/moneys', [], true);

            if (!$savedFile) {
                Facilitador::notification('Money could not be updated.', 'danger');

                return false;
            }

            $input['location'] = $savedFile['name'];
            $input['original_name'] = $savedFile['original'];
        } else {
            $input['location'] = $money->location;
        }

        if (!isset($input['is_published'])) {
            $input['is_published'] = 0;
        } else {
            $input['is_published'] = 1;
        }

        $money->forgetCache();

        $money->update($input);

        $money->setCaches();

        return $money;
    }
}
