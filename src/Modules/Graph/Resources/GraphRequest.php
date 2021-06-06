<?php

namespace Bancario\Modules\Graph\Resources;

use Muleta\Modules\Eloquents\Displays\RequestAbstract;

/**
 * Class GraphRequest.
 *
 */
class GraphRequest extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $user = Auth::user();
        // if ($user->userMeta()->first()) {
        //     return false;
        // }
        // return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // return [
        //     'agree' => ['required'],
        // ];
    }
}
