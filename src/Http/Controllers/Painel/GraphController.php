<?php
namespace Bancario\Http\Controllers\Painel;

use Illuminate\Http\Request;
use Bancario\Models\Money\Money;
use Bancario\Models\Jesse\Graph;
use Bancario\Models\Trader\ExchangeAccount;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $graph = Graph::all();
        // dd(
        //     $graph
        // );
        // $moneys = Money::orderBy('code', 'DESC')->simplePaginate(50);

        return view('bancario::trader.dashboard', compact('trader'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     return view('root.moneys.create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     $request->validate(
    //         [
    //         'money_name'=>'required',
    //         'money_price'=> 'required|integer',
    //         'money_qty' => 'required|integer'
    //         ]
    //     );
    //     $money = new Money(
    //         [
    //         'money_name' => $request->get('money_name'),
    //         'money_price'=> $request->get('money_price'),
    //         'money_qty'=> $request->get('money_qty')
    //         ]
    //     );
    //     $money->save();
    //     return redirect('/root/root/moneys')->with('success', 'Money has been added');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int $code
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($code)
    // {
    //     $money = Money::findOrFail($code);
    //     return view('root.moneys.show', compact('money'));
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int $code
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($code)
    // {
    //     $money = Money::findOrFail($code);

    //     return view('root.moneys.edit', compact('money'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request $request
    //  * @param  int                      $code
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $code)
    // {
    //     $request->validate(
    //         [
    //         'money_name'=>'required',
    //         'money_price'=> 'required|integer',
    //         'money_qty' => 'required|integer'
    //         ]
    //     );

    //     $money = Money::findOrFail($code);
    //     $money->money_name = $request->get('money_name');
    //     $money->money_price = $request->get('money_price');
    //     $money->money_qty = $request->get('money_qty');
    //     $money->save();

    //     return redirect('/root/root/moneys')->with('success', 'Money has been updated');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int $code
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($code)
    // {
    //     $money = Money::findOrFail($code);
    //     $money->delete();

    //     return redirect('/root/root/moneys')->with('success', 'Money has been deleted Successfully');
    // }
}