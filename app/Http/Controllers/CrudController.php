<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrudController extends Controller
{

    public function __construct()
    {

    }

    public function getOffers()
    {
        return Offer::select('id', 'name')->get();
    }


    /* public function store()
     {

         Offer::create([
             'name' => 'Offer3',
             'price' => '5000',
             'details' => 'offer details',
         ]);
     }*/


    public function create()
    {
        return view('offers.create');
    }


    public function store(Request $request)
    {
        //validate data before insert to database

        $rules = $this->getRules();
        $messages = $this->getMessages();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        //insert
        Offer::create([
            'name' => $request->name,
            'price' => $request->price,
            'details' => $request->details,
        ]);

        return redirect()->back()->with(['success' => 'تم اضافه العرض بنجاح ']);

    }


    protected function getMessages()
    {

        return $messages = [
            'name.required' => __('messages.offer name required'),
            'name.unique' => 'اسم العرض موجود ',
            'price.numeric' => 'سعر العرض يجب ان يكون ارقام',
            'price.required' => 'السعر مطلوب',
            'details.required' => 'ألتفاصيل مطلوبة ',
        ];
    }

    protected function getRules()
    {

        return $rules = [
            'name' => 'required|max:100|unique:offers,name',
            'price' => 'required|numeric',
            'details' => 'required',
        ];
    }
}
