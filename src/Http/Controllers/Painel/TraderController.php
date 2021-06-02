<?php
namespace Bancario\Http\Controllers\Painel;

use Illuminate\Http\Request;
use Bancario\Models\Money\Money;
use Bancario\Models\Trader\Trader;
use Bancario\Models\Trader\ExchangeAccount;

class TraderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $traders = Trader::orderBy('processing_time', 'DESC')->with('assets')->with('histories')->simplePaginate(50);
        // $moneys = Money::orderBy('code', 'DESC')->simplePaginate(50);

        // return view('bancario::painel.traders.index', compact('trader'));
        
        // if (auth()->user() && auth()->user()->isAdmin()) {
        //     $traders = Trader::allTeams()->orderBy('name', 'ASC')->simplePaginate(50);
        // } else {
        //     $traders = Trader::orderBy('name', 'ASC')->simplePaginate(50);
        // }

        return view('bancario::painel.traders.index', compact('traders'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trader = Trader::findOrFail($id);

        // $playlists = Playlist::fromTeam($trader->team_id)->orderBy('name', 'ASC')->get()->pluck('name', 'id');
        // $playlists[0] = 'Sem Playlist';

        // $computers = Computer::fromTeam($trader->team_id)->isBlock()->where('is_active', true)->where('trader_id', null)->orderBy('name', 'ASC')->get()->pluck('name', 'id');
        // $computers = $computers->diff($trader->computers->pluck('name', 'id'));
        return view('bancario::painel.traders.show', compact(
            'trader',
            // 'playlists', 'computers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bancario::painel.traders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $trader = new Trader();
        $trader->validateAndSetFromRequestAndSave($request);
        return redirect('/painel/traders')->with('success', 'Grupo foi adicionado com sucesso');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trader = Trader::findOrFail($id);

        return view('bancario::painel.traders.edit', compact('trader'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $trader = Trader::findOrFail($id);
        $trader->validateAndSetFromRequestAndSave($request);

        return redirect('/painel/traders')->with('success', 'Grupo foi atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->isAdmin()) {
            $trader = Trader::allTeams()->findOrFail($id);
        } else {
            $trader = Trader::findOrFail($id);
        }
        $trader->delete();

        return redirect('/painel/traders')->with('success', 'Grupo foi deletado com sucesso');
    }
}