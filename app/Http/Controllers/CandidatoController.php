<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Candidato::query()->orderBy('id', 'asc');

        if ($request->has('search') && $request->search != "") {
            $query->where(function ($query) use ($request) {
                $query->where('first_name', 'ILIKE' ,"%{$request->search}%")
                    ->orWhere('full_name', 'ILIKE' ,"%{$request->search}%")
                    ->orWhere('job_title', 'ILIKE' ,"%{$request->search}%");
            });
        }

        if ($request->has('experience_level') && $request->experience_level != "Todos") {
            $query->where(function ($query) use ($request) {
                $query->where('experience_level', $request->experience_level);
            });
        }

        if ($request->has('skills') && $request->skills != []) {
            $query->where(function ($query) use ($request) {
                $query->whereJsonContains('skills', $request->skills);
            });
        }

        if ($request->has('candidaturas') && $request->candidaturas == 'true') {
            $query->with('candidaturas');
        }

        if ($request->has('paginate')) {
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
        
        $validator = $this->validation($data);
        
        if (!$validator->fails()) {
            $data['skills'] = json_encode($data['skills']);

            $candidato = Candidato::create($data);

            if ($candidato) {
                return response()->json([
                    "message" => "Candidato cadastrado com sucesso."
                ], 200);
            } else {
                return response()->json([
                    "message" => "Erro ao cadastrar o candidato."
                ], 500);
            }
            
        } else {
            return response()->json($validator->errors());
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidato
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidato = Candidato::with('candidaturas')->find($id);

        if ($candidato) {
            return response()->json($candidato);
        } else {
            return response()->json([
                "message" => "Candidato não encontrado."
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidato 
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidato $candidato)
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
            $data['skills'] = json_encode($data['skills']);

            $candidato = Candidato::find($id);

            $save = $candidato->update($data);

            if ($save) {
                return response()->json([
                    "message" => "Candidato atualizado com sucesso."
                ], 200);
            } else {
                return response()->json([
                    "message" => "Erro ao atualizar o candidato."
                ], 500);
            }
            
        } else {
            return response()->json($validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidato 
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        $ids = json_decode($ids);
        $candidato = Candidato::whereIn('id', $ids);
        
        if ($candidato) {
            $deleted = $candidato->delete();

            return response()->json([
                "message" => "Candidato removido com sucesso."
            ], 200);
        } else {
            return response()->json([
                "message" => "Candidato inexistente."
            ], 500);
        }
    }

    private function validation($data) {
        return Validator::make($data, [
            'first_name' => 'required|max:255|string',
            'full_name' => 'required|max:255|string',
            'phone' => 'required|string',
            'address' => 'required|max:255|string',
            'job_title' => 'required|string',
            'experiences' => 'required|string',
            'skills' => 'required|array|min:3',
            'experience_level' => 'required|in:junior,pleno,senior'
        ]);
    }
}
