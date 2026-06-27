<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $property = Property::latest();
            return DataTables::of($property)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="'.asset('property/'.$row->image).'" width="60" height="50" style="object-fit:cover;border-radius:8px;">';
                    }
                    return 'No Image';
                })
                ->addColumn('rent_price', function ($row) {
                    return '₹ '.number_format($row->rent_price, 2);
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'available') {
                        return '<span class="badge bg-success">Available</span>';
                    }
                    return '<span class="badge bg-danger">Rented</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button
                            class="btn btn-warning btn-sm edit-btn"
                            data-id="'.$row->id.'"
                            data-title="'.$row->title.'"
                            data-location="'.$row->location.'"
                            data-rent_price="'.$row->rent_price.'"
                            data-description="'.$row->description.'"
                            data-status="'.$row->status.'">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="'.route('admin.property.delete', $row->id).'"
                           class="btn btn-danger btn-sm delete-btn">
                            <i class="fa fa-trash"></i>
                        </a>
                    ';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
        return view('admin.property');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'location' => 'required',
            'rent_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'description' => 'required',
            'status' => 'required',
        ]);
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('property'), $imageName);
        }
        Property::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'location' => $request->location,
            'rent_price' => $request->rent_price,
            'image' => $imageName,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return back()->with('success', 'Property added successfully!');
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'location' => 'required',
            'rent_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'description' => 'nullable',
            'status' => 'required',
        ]);

        $imageName = $property->image;
        if ($request->hasFile('image')) {
            if ($property->image && file_exists(public_path('property/'.$property->image))) {
                unlink(public_path('property/'.$property->image));
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('property'), $imageName);
        }
        $property->fill([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'location' => $request->location,
            'rent_price' => $request->rent_price,
            'image' => $imageName,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        if ($property->isDirty()) {
            $property->save();
            return back()->with('success', 'Property updated successfully!');
        }

        return back()->with('info', 'No changes made to the property.');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        if ($property->image && file_exists(public_path('property/'.$property->image))) {
            unlink(public_path('property/'.$property->image));
        }
        $property->delete();
        return back()->with('success', 'Property deleted successfully!');
    }
}