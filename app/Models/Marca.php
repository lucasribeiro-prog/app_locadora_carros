<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['nome', 'imagem'];

    public function rules() {
        return [
            'nome' => 'required|unique:marcas|min:3',
            'imagem' => 'required',
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório!',
            'nome.unique' => 'Esse nome já existe!',
            'nome.min' => 'O campo nome deve conter no mínimo 3 caracteres!',
        ];
    }
}
