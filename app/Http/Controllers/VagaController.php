<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VagaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Vaga::query()->orderBy('id', 'asc');

        if ($request->has('search') && $request->search != "") {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'ILIKE' ,"%{$request->search}%")->orWhere('company', 'ILIKE' ,"%{$request->search}%");
            });
        }

        if ($request->has('type') && $request->type != "Todas") {
            $query->where(function ($query) use ($request) {
                $query->where('type', $request->type);
            });
        }

        if ($request->has('modality') && $request->modality != "Todas") {
            $query->where(function ($query) use ($request) {
                $query->where('modality', $request->modality);
            });
        }

        if ($request->has('status')) {
            $query->where(function ($query) use ($request) {
                $query->where('status', $request->status);
            });
        }

        if ($request->has('candidaturas')) {
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

            $vaga = Vaga::create($data);

            if ($vaga) {
                return response()->json([
                    "message" => "Vaga cadastrada com sucesso."
                ], 200);
            } else {
                return response()->json([
                    "message" => "Erro ao cadastrar a vaga."
                ], 500);
            }
            
        } else {
            return response()->json($validator->errors());
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vaga
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vaga = Vaga::with('candidaturas')->find($id);

        if ($vaga) {
            return response()->json($vaga);
        } else {
            return response()->json([
                "message" => "Vaga não encontrada."
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vaga 
     * @return \Illuminate\Http\Response
     */
    public function edit(Vaga $vaga)
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

            $vaga = Vaga::find($id);

            $save = $vaga->update($data);

            if ($save) {
                return response()->json([
                    "message" => "Vaga atualizada com sucesso."
                ], 200);
            } else {
                return response()->json([
                    "message" => "Erro ao atualizar a vaga."
                ], 500);
            }
            
        } else {
            return response()->json($validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vaga 
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        $ids = json_decode($ids);
        $vaga = Vaga::whereIn('id', $ids);
        
        if ($vaga) {
            $deleted = $vaga->delete();
            return response()->json([
                "message" => "Vaga removida com sucesso."
            ], 200);
        } else {
            return response()->json([
                "message" => "Vaga inexistente."
            ], 500);
        }
    }

    private function validation($data) {
        return Validator::make($data, [
            'title' => 'required|max:255|string',
            'company' => 'required|max:255|string',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'salary' => 'required|numeric',
            'type' => 'required|in:remote,in_person,hybrid',
            'modality' => 'required|in:clt,pj,freelancer',
            'status' => 'in:active,paused,closed'
        ]);
    }
}
