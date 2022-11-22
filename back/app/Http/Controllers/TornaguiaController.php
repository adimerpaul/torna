<?php

namespace App\Http\Controllers;

use App\Models\Tornaguia;
use App\Http\Requests\StoreTornaguiaRequest;
use App\Http\Requests\UpdateTornaguiaRequest;
use Illuminate\Http\Request;

class TornaguiaController extends Controller{
    public function index(){
        return Tornaguia::orderBy('id', 'desc')
            ->with('transporte')
            ->with('empresa')
            ->with('contratista')
            ->with('user')
            ->with('driver')
            ->get();
    }
    public function show(Tornaguia $tornaguia){ return $tornaguia; }
    public function store(Request $request){
        $request->validate([
            'fecha'=>'required',
            'numero'=>'required',
            'yacimiento'=>'required',
            'tranca'=>'required',
            'cuadrilla'=>'required',
            'tipoMaterial'=>'required',
            'minerales'=>'required',
            'peso'=>'required',
            'sacos'=>'required',
            'transporte_id'=>'required',
            'empresa_id'=>'required',
            'contratista_id'=>'required',
            'user_id'=>'required',
            'driver_id'=>'required',
        ]);
        return Tornaguia::create($request->all());
    }
    public function update(Request $request,$id){
        $tornaguia = Tornaguia::findOrFail($id);
        $tornaguia->update($request->all());
        return $tornaguia;
    }
    public function destroy($id){
        $tornaguia = Tornaguia::findOrFail($id);
        $tornaguia->delete();
        return $tornaguia;
    }
}
