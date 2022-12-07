<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\inventario;



class inventariocontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventarios = Http::get('http://localhost:9000/inventarios/')->json();
    
        return view('inventario.index',compact ('inventarios')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidacionInventario $request)
    {
        $inventarios = Http::post('http://localhost:9000/insertar_inventario', [
            'NOMBRE_PRODUCTO'=> $request->nombre_producto,
            'PRECIO_PRODUCTO' => $request->precio_producto,
            'CANTIDAD_PRODUCTO' => $request->cantidad_producto,
            'CATEGORIA_PRODUCTO'=> $request->categoria_producto,
            'FECHA_VENCIMIENTO' => $request->fecha_vencimiento, 
            'MAXIMO_PRODUCTO' => $request->maximo_producto,    
            'MINIMO_PRODUCTO' => $request->minimo_producto,       
        ]); 

           return redirect()-> route('inventario.index')->with('agregado','el Producto fue agregado correctamente'); 
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
    public function edit($COD_PRODUCTO)
    {
        $inventarios = inventario ::findorfail($COD_PRODUCTO); 
        
        return view('inventario.edit', compact('inventarios')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidacionInventario $request, $COD_PRODUCTO)
    {
        $inventarios  = Http::put('http://localhost:9000/inventarios/edit/'. $COD_PRODUCTO ,[
            'NOMBRE_PRODUCTO'=> $request->nombre_producto,
            'PRECIO_PRODUCTO' => $request->precio_producto,
            'CANTIDAD_PRODUCTO' => $request->cantidad_producto,
            'CATEGORIA_PRODUCTO'=> $request->categoria_producto,
            'FECHA_VENCIMIENTO' => $request->fecha_vencimiento, 
            'MAXIMO_PRODUCTO' => $request->maximo_producto,    
            'MINIMO_PRODUCTO' => $request->minimo_producto,  
        ]);

        return redirect()-> route('inventario.index')->with('editado','El Inventario fue editado correctamente'); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($COD_PRODUCTO)
    {
        $inventarios = Http::delete('http://localhost:9000/inventarios/delete/'. $COD_PRODUCTO);

        return redirect()-> route('inventario.index')->with('eliminado','El producto fue eliminado correctamente'); 
    }
}
