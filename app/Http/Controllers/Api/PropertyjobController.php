<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyjobResource;
use App\Models\Propertyjob;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PropertyjobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $data = DB::table('propertyjobs')
//            ->join('properties', 'propertyjobs.property_id', '=', 'properties.id')
//            ->join('users', 'propertyjobs.user_id', '=', 'users.id')
//            ->select('propertyjobs.id', 'propertyjobs.summary', 'propertyjobs.status',
//                'propertyjobs.created_at', 'users.first_name', 'users.last_name',  'properties.name')
//            ->orderBy('propertyjobs.id','desc')->paginate(3);
//
//        return PropertyjobResource::collection($data);

        return PropertyjobResource::collection(Propertyjob::with('property','user')
            ->orderBy('id','desc')->paginate(3));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->first_name = $request->firstname;
        $user->last_name = $request->lastname;
        $user->email = Str::random(10) . '@example.com';
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->password = Hash::make('password');
        $user->is_admin = false;
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();

        $propertyjob = Propertyjob::create([
            'property_id' => $request->property_id,
            'summary' => $request->jobsummary,
            'description' => $request->jobdescription,
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return new PropertyjobResource($propertyjob);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
