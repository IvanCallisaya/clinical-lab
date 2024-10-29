<?php

namespace App\Http\Controllers;

use App\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('customer.customer');
    }

    public function MemberList(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;

        $customer = Member::join('customers', 'members.customer_id', '=', 'customers.id')
            ->select(
                'customers.customer_name',
                'customers.ci',
                'customers.email',
                'customers.phone',
                'customers.address',
                'members.membresy_type',
                'members.status'
            )

            ->orderBy('customers.customer_name', 'asc');

        if (!empty($name)) {
            $customer->where('customers.customer_name', 'LIKE', '%' . $name . '%');
        }

        if (!empty($email)) {
            $customer->where('customers.email', 'LIKE', '%' . $email . '%');
        }

        if (!empty($phone)) {
            $customer->where('customers.phone', 'LIKE', '%' . $phone . '%');
        }

        $customer = $customer->paginate(10);

        return $customer;
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


        try {
            Log::info($request->all());

            if ($request->hasFile('image_ci')) {
                $filename_ci = $request->file('image_ci')->store('miembros', 'local');
                Log::info('Ruta guardada para image_ci: ' . $filename_ci);
            }

            if ($request->hasFile('image_photo')) {
                $filename_photo = $request->file('image_photo')->store('miembros', 'local');                
                Log::info('Ruta guardada para image_photo: ' . $filename_photo);
            }

            if ($request->hasFile('image_payment')) {
                $filename_payment = $request->file('image_payment')->store('miembros', 'local');
                Log::info('Ruta guardada para image_payment: ' . $filename_payment);
            }

            // if ($request->hasFile('image_photo')) {
            //     $path_photo = $request->file('image_photo')->store('public/imagenes');
            //     $filename_photo = basename($path_photo);
            // }
            // if ($request->hasFile('image_payment')) {
            //     $path_payment = $request->file('image_payment')->store('public/imagenes');
            //     $filename_payment = basename($path_payment);
            // }
            Log::info($filename_ci);
            Log::info($filename_photo);
            Log::info($filename_payment);
            $member = new Member;
            $member->membresy_type = $request->membresy_type;
            $member->path_ci = $filename_ci;
            $member->path_photo = $filename_photo;
            $member->path_proof_payment = $filename_payment;
            $member->status = 0;
            $member->customer_id = $request->customer_id;
            $member->user_id = $request->user_id;




            // Guardar datos del cliente

            $member->save();
            return response()->json(['status' => 'success', 'message' => 'Cliente agregado']);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Member $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $customer)
    {
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'customer_name' => 'required',
            'email' => 'nullable|email|unique:customers,email,' . $request->id,
            'phone' => 'nullable|numeric|unique:customers,email,' . $request->id,
        ]);

        try {
            $customer = Member::find($id);
            $customer->customer_name = $request->customer_name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->update();

            return response()->json(['status' => 'success', 'message' => 'Información del cliente actualizada']);
        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => '¡Algo salió mal!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $customer)
    {
        //
    }
}
