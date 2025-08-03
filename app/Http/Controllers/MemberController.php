<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\File;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();

        foreach ($members as $member) {
            $qrFile = 'member-' . $member->id . '.png';
            $qrDir = public_path('qrcode/members/');
            $qrPath = $qrDir . $qrFile;

            if (!file_exists($qrPath)) {
                $this->generateQrFile($member);
            }

            $member->qr_url = asset('qrcode/members/' . $qrFile);
        }

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

        $member = Member::create($validated);

        // ✅ Optional #4: Auto-generate QR after creation
        $this->generateQrFile($member);

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

    public function destroy($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found.'], 404);
        }

        if ($member->photo) {
            $photoPath = public_path('resource/member_images/' . $member->photo);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }

        $member->delete();

        return response()->json(['success' => true, 'message' => '🗑️ Member deleted successfully.']);
    }

    private function generateQrFile(Member $member)
    {
        $dir = public_path('qrcode/members/');
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $qrPath = $dir . 'member-' . $member->id . '.png';

        if (!file_exists($qrPath)) {
            $options = new QROptions([
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel' => QRCode::ECC_H,
                'scale' => 8,
                'imageBase64' => false,
                'margin' => 10,
            ]);

            $qrData = route('members.show', $member->id); // Adjust this route as needed

            (new QRCode($options))->render($qrData, $qrPath);
        }

        return $qrPath;
    }
}
