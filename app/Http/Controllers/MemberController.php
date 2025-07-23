<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\File;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'address' => 'required|string',
            'contactnumber' => 'required|string',
            'memberdate' => 'required|date',
            'member_time' => 'required|integer',
            'school' => 'required|string'
        ]);

        if ($request->hasFile('photo')) {
            $filename = time().'_'.$request->photo->getClientOriginalName();
            $request->photo->move(public_path('resource/member_images'), $filename);
            $validated['photo'] = $filename;
        }

        Member::create($validated);

        return response()->json(['message' => '✅ Member saved successfully.']);
    }

    public function update(Request $request, $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'address' => 'required|string',
            'contactnumber' => 'required|string',
            'school' => 'nullable|string',
        ]);

        $member->name = $request->input('name');
        $member->age = $request->input('age');
        $member->address = $request->input('address');
        $member->contactnumber = $request->input('contactnumber');
        $member->school = $request->input('school');
        $member->save();

        return response()->json(['success' => true, 'message' => 'Member updated']);
    }

    // ✅ DELETE MEMBER
    public function destroy($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found.'], 404);
        }

        // Delete photo if exists
        if ($member->photo) {
            $photoPath = public_path('resource/member_images/' . $member->photo);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }

        $member->delete();

        return response()->json(['success' => true, 'message' => '🗑️ Member deleted successfully.']);
    }
}
