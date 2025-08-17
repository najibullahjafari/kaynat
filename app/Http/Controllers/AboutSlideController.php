<?php

namespace App\Http\Controllers;

use App\Models\AboutSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class AboutSlideController extends Controller
{
    public function index()
    {
        $slides = AboutSlide::all();
        return view('admin.about.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'general_heading' => 'required|string|max:255',
            'question' => 'required|string|max:255',
            'heading1' => 'required|string|max:255',
            'desc1' => 'required|string',
            'heading2' => 'required|string|max:255',
            'desc2' => 'required|string',
            'heading3' => 'required|string|max:255',
            'desc3' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $imagePath = $request->file('image')->store('about_slides', 'public');
            AboutSlide::create([
                'image' => $imagePath,
                'general_heading' => $request->general_heading,
                'question' => $request->question,
                'heading1' => $request->heading1,
                'desc1' => $request->desc1,
                'heading2' => $request->heading2,
                'desc2' => $request->desc2,
                'heading3' => $request->heading3,
                'desc3' => $request->desc3,
            ]);
            DB::commit();
            return redirect()->route('about-slides.index')->with('success', 'Slide added!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to add slide: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $slide = AboutSlide::findOrFail($id);
        return view('admin.about.edit', compact('slide'));
    }

    public function update(Request $request, $id)
    {
        $slide = AboutSlide::findOrFail($id);
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'general_heading' => 'required|string|max:255',
            'question' => 'required|string|max:255',
            'heading1' => 'required|string|max:255',
            'desc1' => 'required|string',
            'heading2' => 'required|string|max:255',
            'desc2' => 'required|string',
            'heading3' => 'required|string|max:255',
            'desc3' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('about_slides', 'public');
                $slide->image = $imagePath;
            }
            $slide->update($request->except('image'));
            DB::commit();
            return redirect()->route('about-slides.index')->with('success', 'Slide updated!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update slide: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $slide = AboutSlide::findOrFail($id);
        $slide->delete();
        return redirect()->route('about-slides.index')->with('success', 'Slide deleted!');
    }
}
