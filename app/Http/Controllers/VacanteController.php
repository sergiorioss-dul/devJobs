<?php

namespace App\Http\Controllers;

use App\Salario;
use App\Vacante;
use App\Categoria;
use App\Ubicacion;
use App\Experiencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VacanteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vacantes = Vacante::where('user_id',auth()->user()->id)->latest()->simplePaginate(10);
        
        return view('vacantes.index',compact('vacantes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Consulta de categorias
        $categorias = Categoria::all();
        $experiencias = Experiencia::all();
        $ubicaciones = Ubicacion::all();
        $salarios = Salario::all();
        return view('vacantes.create',compact('categorias','experiencias','ubicaciones','salarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validacion
        $data = $request->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'experiencia' => 'required',
            'ubicacion' => 'required',
            'salarios' => 'required',
            'descripcion' => 'required|min:50',
            'imagen' => 'required',
            'skills' => 'required'
        ]);
        //Almacenar en la BD
        auth()->user()->vacantes()->create([
            'titulo'=>$data['titulo'],
            'imagen'=>$data['imagen'],
            'descripcion'=>$data['descripcion'],
            'skills'=>$data['skills'],
            'categoria_id'=>$data['categoria'],
            'experiencia_id'=>$data['experiencia'],
            'ubicacion_id'=>$data['ubicacion'],
            'salario_id'=>$data['salarios'],
        ]);

        return redirect()->action('VacanteController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function show(Vacante $vacante)
    {
        if($vacante->activa === 0)return abort(404);
        return view('vacantes.show',compact('vacante'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacante $vacante)
    {
        $this->authorize('view',$vacante);
        //Consulta de categorias
        $categorias = Categoria::all();
        $experiencias = Experiencia::all();
        $ubicaciones = Ubicacion::all();
        $salarios = Salario::all();
        return view('vacantes.edit',compact('categorias','experiencias','ubicaciones','salarios','vacante'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacante $vacante)
    {
        $this->authorize('update',$vacante);
        //Validacion
        $data = $request->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'experiencia' => 'required',
            'ubicacion' => 'required',
            'salarios' => 'required',
            'descripcion' => 'required|min:50',
            'imagen' => 'required',
            'skills' => 'required'
        ]);
        $vacante->titulo = $data['titulo'];
        $vacante->skills = $data['skills'];
        $vacante->imagen = $data['imagen'];
        $vacante->descripcion = $data['descripcion'];
        $vacante->categoria_id = $data['categoria'];
        $vacante->experiencia_id = $data['experiencia'];
        $vacante->ubicacion_id = $data['ubicacion'];
        $vacante->salario_id = $data['salarios'];
        $vacante->save();
        return redirect()->action('VacanteController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vacante  $vacante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacante $vacante, Request $request)
    {
        $this->authorize('update',$vacante);
        $vacante->delete();
        return response()->json(['mensaje'=>'Se eliminó la vacante: ' . $vacante->titulo]);
    }

    public function imagen(Request $request)
    {
        $imagen = $request->file('file');
        $nombreImagen = time().'.'.$imagen->extension();
        $imagen->move(public_path('storage/vacantes'),$nombreImagen);
        return response()->json(['correcto' => $nombreImagen]);
    }

    public function borrarimagen(Request $request)
    {
        if($request->ajax()){
            $imagen = $request->get('imagen');
            if(File::exists('storage/vacantes/'.$imagen)){
                File::delete('storage/vacantes/'.$imagen);
            }
            return response('Imagen Eliminada',200);
        }
    }
    public function estado(Request $request, Vacante $vacante)
    {
        // Leer nuevo estado y asignarlo
        $vacante->activa = $request->estado;
        //guardarlo en la BD
        $vacante->save();
        return response()->json(['respuesta' => 'Correcto']);
    }
    public function buscar(Request $request)
    {
        //validar
        $data = $request->validate([
            'categoria' => 'required',
            'ubicacion' => 'required'
        ]);
        $categoria = $data['categoria'];
        $ubicacion = $data['ubicacion'];

        $vacantes = Vacante::latest()   
                                ->where('categoria_id',$categoria)
                                ->where('ubicacion_id',$ubicacion)
                                ->get();
        return view('buscar.index',compact('vacantes','categoria','ubicacion'));                                
    }
    public function resultados()
    {
        return 'mostrando...';
    }
}
