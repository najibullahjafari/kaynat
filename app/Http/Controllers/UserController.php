<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Redirect;

class UserController extends Controller
{


    // functions for Frond-end pannel
    public function index(Request $req)
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('brand', [
            'solutions' => \App\Models\Solution::where('is_active', 1)->get(),
            'features' => \App\Models\Feature::where('is_active', 1)->get(),
            'technologies' => \App\Models\TechnologyItem::where('is_active', 1)->get(),
            'industries' => \App\Models\IndustryCategory::where('is_active', 1)->get(),
            'testimonials' => \App\Models\Testimonial::where('is_active', 1)->get(),
            'teamMembers' => \App\Models\TeamMember::where('is_active', 1)->get(),
            'settings' => $settings,
        ]);
    }
    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'interest' => 'required|string|max:50',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->interest,
                'message' => $request->message,
                'is_read' => false,
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Thank you! Your message has been sent.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again.'], 500);
        }
    }
}
