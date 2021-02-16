<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nota;

class NotaController extends Controller
{
    //Proteger las rutas
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $usuarioEmail = auth()->user()->email; //Filtrar notas por email de usuario (auth user tiene toda la info del usuario)
        $notas = Nota::where('usuario',$usuarioEmail)->paginate(5);
        return view('notas.lista',compact('notas'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notas.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nota = new Nota();
        $nota->nombre = $request->nombre;
        $nota->descripcion= $request->descripcion;
        $nota->usuario = auth()->user()->email;
        $nota->save();
        
        return back()->with('mensaje','Nota agregada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nota = Nota::findOrFail($id);
        return view('notas.editar',compact('nota'));
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
        $request->validate([
            'nombre'=>'required',
            'descripcion'=>'required'
        ]);
        $notaUpdate = Nota::findOrFail($id);
        $notaUpdate->nombre = $request->nombre;
        $notaUpdate->descripcion = $request->descripcion;
      
        $notaUpdate-> save();
        
        return back()->with('mensaje','Nota actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notaAEliminar = Nota::findOrFail($id);
        $notaAEliminar->delete();
        return back()->with('mensaje','Nota eliminada');
    }
}
