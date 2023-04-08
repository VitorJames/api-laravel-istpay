<?php

namespace App\Http\Controllers;

use App\Models\Candidatura;
use App\Models\Candidato;
use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class CandidaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Candidatura::query()->orderBy('id', 'asc');

        if ($request->has('candidato_id') && $request->candidato_id != "") {
            $query->where(function ($query) use ($request) {
                $query->where('candidato_id', $request->candidato_id);
            });
        }

        if ($request->has('vaga_id') && $request->vaga_id != []) {
            $query->where(function ($query) use ($request) {
                $query->where('vaga_id', $request->vaga_id);
            });
        }

        if ($request->has('candidato') && $request->candidato == 'true') {
            $query->with('candidato');
        }

        if ($request->has('vaga') && $request->vaga == 'true') {
            $query->with('vaga');
        }

        if ($request->has('paginate') && $request->paginate == 'true') {
            $data = $query->paginate($request->per_page);
        } else {
            $data = $query->get();
        }

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $candidato = Candidato::find($data['candidato_id']);
        $vaga = Vaga::find($data['vaga_id']);
        $check_candidatura = Candidatura::where('vaga_id', $data['vaga_id'])->where('candidato_id', $data['candidato_id'])->get();

        if ($candidato == null) {
            return response()->json([
                "message" => "Candidato inexistente."
            ], 500);
        }
        if ($vaga == null) {
            return response()->json([
                "message" => "Vaga inexistente."
            ], 500);
        } else {
            if ($vaga->status == 'paused') {
                return response()->json([
                    "message" => "A vaga se encontra pausada."
                ], 500);
            }
            if ($vaga->status == 'closed') {
                return response()->json([
                    "message" => "A vaga se encontra encerrada."
                ], 500);
            }
        }
        
        if (count($check_candidatura) > 0) {
            return response()->json([
                "message" => "Candidatura já realizada pelo candidato."
            ], 500);
        }
        
        $validator = $this->validation($data);
        
        if (!$validator->fails()) {
            $candidatura = Candidatura::create($data);

            if ($candidatura) {
                return response()->json([
                    "message" => "Candidatura realizada com sucesso."
                ], 200);
            } else {
                return response()->json([
                    "message" => "Erro ao realizar a candidatura."
                ], 500);
            }
            
        } else {
            return response()->json($validator->errors());
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidatura
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidatura = Candidatura::find($id);

        if ($candidatura) {
            return response()->json($candidatura);
        } else {
            return response()->json([
                "message" => "Candidatura não encontrada."
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidatura 
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidatura $candidatura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validator = $this->validation($data);

        if (!$validator->fails()) {
            $candidatura = Candidatura::find($id);

            $save = $candidatura->update($data);

            if ($save) {
                return response()->json([
                    "message" => "Candidatura atualizada com sucesso."
                ], 200);
            } else {
                return response()->json([
                    "message" => "Erro ao atualizar a candidatura."
                ], 500);
            }
            
        } else {
            return response()->json($validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidatura 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidatura = Candidatura::find($id);

        
        if ($candidatura) {
            $deleted = $candidatura->delete();

            return response()->json([
                "message" => "Candidatura removida com sucesso."
            ], 200);
        } else {
            return response()->json([
                "message" => "Candidatura inexistente."
            ], 500);
        }
    }

    private function validation($data) {
        return Validator::make($data, [
            'candidato_id' => 'required|int',
            'vaga_id' => 'required|int'
        ]);
    }
}
