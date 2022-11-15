<?php

namespace App\Http\Controllers;

use App\Models\Tornaguia;
use App\Http\Requests\StoreTornaguiaRequest;
use App\Http\Requests\UpdateTornaguiaRequest;
use Illuminate\Http\Request;

class TornaguiaController extends Controller{
    public function index(){ return Tornaguia::all(); }
    public function show(Tornaguia $tornaguia){ return $tornaguia; }
    public function store(Request $request){ return Tornaguia::create($request->all()); }
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
