<?php

namespace App\Http\Controllers\Relation;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Phone;
use App\User;
use Illuminate\Http\Request;

class RelationsController extends Controller
{
    public function hasOneRelation()
    {
        return $user = \App\User::with(['phone' => function ($q) {
            $q->select('code', 'phone', 'user_id');
        }])->find(15);

        //return $user -> phone -> code;
        // $phone = $user -> phone;

        return response()->json($user);
    }


    public function hasOneRelationReverse()
    {
        //$phone = Phone::with('user')->find(1);

        $phone = Phone::with(['user' => function ($q) {
            $q->select('id', 'name');
        }])->find(1);

        //make some attribute visible
        $phone->makeVisible(['user_id']);
        //$phone->makeHidden(['code']);
        //return  $phone -> user;  //return user of this phone number
        // get all data  phone + user

        return $phone;
    }


    public function getUserHasPhone()
    {
        return User::whereHas('phone')->get();
    }

    public function getUserNotHasPhone()
    {
        return User::whereDoesntHave('phone')->get();
    }

    public function getUserWhereHasPhoneWithCondition()
    {
        return User::whereHas('phone', function ($q) {
            $q->where('code', '02');
        })->get();
    }


    ################### one to many relationship mehtods #########

    public function getHospitalDoctors()
    {
        $hospital = Hospital::find(1);  // Hospital::where('id',1) -> first();  //Hospital::first();

        // return  $hospital -> doctors;   // return hospital doctors

        $hospital = Hospital::with('doctors')->find(1);

        //return $hospital -> name;


        $doctors = $hospital->doctors;

        /* foreach ($doctors as $doctor){
            echo  $doctor -> name.'<br>';
         }*/

        $doctor = Doctor::find(3);

        return $doctor->hospital->name;


    }

    public function hospitals()
    {

        $hospitals = Hospital::select('id', 'name', 'address')->get();
        return view('doctors.hospitals', compact('hospitals'));
    }

    public function doctors($hospital_id)
    {

        $hospital = Hospital::find($hospital_id);
        $doctors = $hospital->doctors;
        return view('doctors.doctors', compact('doctors'));
    }


    // get all hospital which must has doctors
    public function hospitalsHasDoctor()
    {
        return $hospitals = Hospital::whereHas('doctors')->get();
    }

    public function hospitalsHasOnlyMaleDoctors()
    {
        return $hospitals = Hospital::with('doctors')->whereHas('doctors', function ($q) {
            $q->where('gender', 1);
        })->get();
    }


    public function hospitals_not_has_doctors()
    {

        return Hospital::whereDoesntHave('doctors')->get();
    }

    public function deleteHospital($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        if (!$hospital)
            return abort('404');
        //delete doctors in this hospital
        $hospital->doctors()->delete();
        $hospital->delete();

        //return redirect() -> route('hospital.all');
    }
}
