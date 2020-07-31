<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MercatodoModels\Product;

class AutocompleteController extends Controller
{
    /**
     * Autocompletes the search word.
     *
     * @param Request $request
     * @return array
     */
    public function autocomplete(Request $request): array
    {
        $palabraabuscar = $request->get('palabraabuscar');

        $Productos = Product::where('name', 'like', '%'.$palabraabuscar .'%')->orderBy('name')
            ->get();

        $resultados=[];

        foreach ($Productos as $prod) {
            $encontrartexto =  stristr($prod->name, $palabraabuscar);
            $prod->encontrar = $encontrartexto;

            $recortar_palabra = substr($encontrartexto, 0, strlen($palabraabuscar));
            $prod->substr = $recortar_palabra;

            $prod->name_negrita =  str_ireplace($palabraabuscar, "<b>$recortar_palabra</b>", $prod->name);

            $resultados[] = $prod;
        }

        return  $resultados;
    }
}
