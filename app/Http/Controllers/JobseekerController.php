<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Jobseekers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class JobseekerController extends Controller
{
    public function postRegistration(Request $request)
    {
        $validated = $request->validate([
       
            'email' => 'required|email|unique:jobseekers,email',
            'phone_number' => 'required|digits:10|unique:jobseekers,phone_number',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required|min:6',
        ]);
     

         $jobseekers = Jobseekers::create([
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'pass' => $request->password,
             
        ]);
        session([
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);
        return view('site.jobseeker.registration');
    }
  
    public function showDetailsForm()
    {
        $email = session('email');
        $phone = session('phone_number');

        return view('site.jobseeker.registration', compact('email', 'phone'));
    }


   
    

    // public function saveStep1(Request $request)
    // {

    //     $validated = $request->validate([
    //         'name'     => 'required|string',
    //         'email'         => 'required|email',
    //         'gender'        => 'required|string',
    //         'phone_number'  => 'required|digits:10',
    //         'dob'           => 'required|date',
    //         'city'      => 'required|string',
    //         'address'       => 'required|string',
    //     ]);

    //     Session::put('jobseeker_step1', $validated);

    //     return response()->json(['message' => 'Step 1 saved']);
    // }
    public function saveStep1(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email',
            'gender'        => 'required|string',
            'phone_number'  => 'required|digits:10',
            'dob'           => 'required|date',
            'city'          => 'required|string',
            'address'       => 'required|string',
        ]);

        $jobseeker = new Jobseeker();
        $jobseeker->name = $validated['name'];
        $jobseeker->email = $validated['email'];
        $jobseeker->gender = $validated['gender'];
        $jobseeker->phone_code = '+91'; // or get from request if dynamic
        $jobseeker->phone_number = $validated['phone_number'];
        $jobseeker->date_of_birth = $validated['dob'];
        $jobseeker->city = $validated['city'];
        $jobseeker->address = $validated['address'];
       // $jobseeker->password = bcrypt('123456'); // or handle password properly
        $jobseeker->role = 'jobseeker'; // if needed
        $jobseeker->save();

        return response()->json([
            'message' => 'Step 1 saved successfully',
            'id' => $jobseeker->id,
        ]);
    }
    // Save Step 2 (Education Info)
    public function saveStep2(Request $request)
    {
        // Validate education fields
        $validated = $request->validate([
            'qualification.*' => 'required|string',
            'field.*'         => 'required|string',
            'institution.*'   => 'required|string',
            'year.*'          => 'required|string',
        ]);

        // Convert parallel arrays to structured array
        $educationData = [];
        foreach ($request->qualification as $index => $qualification) {
            $educationData[] = [
                'high_education'  => $qualification,
                'field_of_study'  => $request->field[$index],
                'institution'     => $request->institution[$index],
                'graduate_year'   => $request->year[$index],
            ];
        }

        Session::put('jobseeker_step2', $educationData);

        return redirect()->route('jobseeker.review'); 
    }



}