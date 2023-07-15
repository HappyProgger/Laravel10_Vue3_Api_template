<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserResourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ?sortBy=name&sortdir=desc
        //&_name=Joh&_firstname=Jacob&_lastname=Benery
        $collection = User::query();
        $allowedFilters = (new User())->getFillable();
        $allowedFilters = [ 'id',...$allowedFilters];
        $allowedDirection=['asc','desc'];

        $sortBy = $request->query($request->query('sortBy','id'));
        $sortdir = $request->query('sortdir',"asc");

        if (!in_array($sortBy, $allowedFilters)) $sortBy = $allowedFilters[0];
        if (!in_array($sortdir, $allowedFilters)) $allowedDirection = $allowedDirection[0];
        $collection->orderBy($sortBy,$sortdir);

        foreach($allowedFilters as $key) {
            if ($paramFilter = $request->query('_' . $key)) {
                $paramFilter = preg_replace('#([%?_+])#', "\\$1", $paramFilter);
                $collection->where($key, 'LIKE', '%' . $paramFilter . '%');
            }
        }
        $limit = intval($request->query('limit',20));
        $limit = max($limit, 20);
        $collection->limit($limit);

        $offset = intval($request->query('offset',0));
        $offset = max( $offset, 0);
        $collection->offset($offset);

        return $collection->get();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
