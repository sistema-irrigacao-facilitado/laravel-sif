<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use App\Http\Traits\Filterable;
use App\Models\AverageData;
use App\Models\Collaborator;
use Illuminate\Http\Request;

class CollaboratorController extends Controller
{
    

    public function index(){
        return view('admin.dashboard');
    }

    use Filterable;
    public function list(Request $request)
    {
        $query = Collaborator::query();
        $filters = [
            'id' => '=',
            'name' => function ($query, $value) {
                $query->where('name', 'like', '%' . $value . '%');
            },
            'lastname' => function ($query, $value) {
                $query->where('lastname', 'like', '%' . $value . '%');
            },
            'telephone' => function ($query, $value) {
                $query->where('telephone', 'like', '%' . $value . '%');
            },
            'email' => function ($query, $value) {
                $query->where('email', 'like', '%' . $value . '%');
            },
            'cpf' => function ($query, $value) {
                $query->where('cpf', 'like', '%' . $value . '%');
            },
            'created_at_from' => function ($query, $value) {
                $query->whereDate('created_at', '>=', $value);
            },
            'created_at_to' => function ($query, $value) {
                $query->whereDate('created_at', '<=', $value);
            },
            'status' => '=',
        ];
        $this->applyFilters($query, $request->session(), 'admins', $filters);
        $collection = $query->orderBy('id')->paginate(30);
        return view('admin.list', ['collection' => $collection]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
