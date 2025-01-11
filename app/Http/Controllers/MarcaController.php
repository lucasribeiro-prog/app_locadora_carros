<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    protected $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = $this->marca->all();
        return $marcas;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->marca->rules(), $this->marca->feedback());
        $image = $request->file('imagem');
        $image_urn = $image->store('imagens', 'public');

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $image_urn,
        ]);
        return $marca;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null) {
            return response()->json(["erro" => "Impossível realizar a exibição, o recurso infomado não existe!"], 404);
        }
        return $marca;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);
        if($marca === null) {
            return response()->json(["erro" => "Impossível realizar a atualização, o recurso infomado não existe!"], 404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            foreach($this->marca->rules() as $input => $regra) {
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $marca->feedback());
        } else {
            $request->validate($this->marca->rules(), $this->marca->feedback());
        }
        

        $marca->update($request->all());
        return $marca;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null) {
            return response()->json(["erro" => "Impossível realizar a exclusão, o recurso infomado não existe!"], 404);
        }
        $marca->delete();
        return ['msg'=>'marca removida com sucesso!'];
    }
}
