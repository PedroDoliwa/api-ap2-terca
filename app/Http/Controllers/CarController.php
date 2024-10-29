<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function listarTodos()
    {
        $cars = Car::all();
        return response()->json([
            'status' => true,
            'message' => 'Cars listado com sucesso',
            'data' => $cars
        ], 200);
    }

    public function listarPeloId($id)
    {
        $car = Car::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Car encontrado com sucesso',
            'data' => $car
        ], 200);
    }

    public function criar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'placa' => 'required|string|max:10',
            'quilometragem'=> 'required|numeric',
            'modelo' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $car = Car::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Car criado com sucesso',
            'data' => $car
        ], 201);
    }

    public function editar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'placa' => 'required|string|max:10',
            'quilometragem'=> 'required|numeric',
            'modelo' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $car = Car::findOrFail($id);
        $car->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Car atualizado com sucesso',
            'data' => $car
        ], 200);
    }

    public function remover($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Car removido com sucesso'
        ], 200);
    }
}
