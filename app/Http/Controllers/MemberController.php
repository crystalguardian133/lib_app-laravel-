<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use PhpOffice\PhpWord\TemplateProcessor;

class MemberController extends Controller
{
    public function index()
    {   
        $members = Member :: orderBy('created_at', 'desc')->get();
        $members = Member::all();

        foreach ($members as $member) {
            $qrFile = 'member-' . $member->id . '.png';
            $qrPath = public_path('qrcode/members/' . $qrFile);

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
            'firstName'     => 'required|string|max:100',
            'middleName'    => 'nullable|string|max:100',
            'lastName'      => 'required|string|max:100',
            'age'           => 'required|integer|min:1',
            'houseNumber'   => 'required|string|max:50',
            'street'        => 'required|string|max:100',
            'barangay'      => 'required|string|max:100',
            'municipality'  => 'required|string|max:100',
            'province'      => 'required|string|max:100',
            'contactNumber' => 'required|string|max:15',
            'school'        => 'required|string|max:255',
            'memberdate'    => 'required|date',
            'member_time'   => 'required|integer',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = [
            'first_name'    => $validated['firstName'],
            'middle_name'   => $validated['middleName'] ?? null,
            'last_name'     => $validated['lastName'],
            'age'           => $validated['age'],
            'house_number'  => $validated['houseNumber'],
            'street'        => $validated['street'],
            'barangay'      => $validated['barangay'],
            'municipality'  => $validated['municipality'],
            'province'      => $validated['province'],
            'contactnumber' => $validated['contactNumber'],
            'school'        => $validated['school'],
            'memberdate'    => $validated['memberdate'],
            'member_time'   => $validated['member_time'],
        ];

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $uploadPath = public_path('resource/member_images');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);
            $data['photo'] = $filename;
        }

        $member = Member::create($data);

        // Generate QR and Card
        $this->generateQrFile($member);
        

        return response()->json([
    'success' => true,
    'message' => '✅ Member registered successfully!',
    'member_id' => $member->id,
    'cardUrl' => asset("card/member_{$member->id}.pdf")
]);

    }

    public function update(Request $request, $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ], 404);
        }

        $validated = $request->validate([
            'firstName'     => 'required|string|max:100',
            'middleName'    => 'nullable|string|max:100',
            'lastName'      => 'required|string|max:100',
            'age'           => 'required|integer|min:1|max:150',
            'houseNumber'   => 'required|string|max:50',
            'street'        => 'required|string|max:100',
            'barangay'      => 'required|string|max:100',
            'municipality'  => 'required|string|max:100',
            'province'      => 'required|string|max:100',
            'contactNumber' => 'required|string|max:15',
            'school'        => 'nullable|string|max:255',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $member->first_name   = $validated['firstName'];
        $member->middle_name  = $validated['middleName'];
        $member->last_name    = $validated['lastName'];
        $member->age          = $validated['age'];
        $member->house_number = $validated['houseNumber'];
        $member->street       = $validated['street'];
        $member->barangay     = $validated['barangay'];
        $member->municipality = $validated['municipality'];
        $member->province     = $validated['province'];
        $member->contactnumber = $validated['contactNumber'];
        $member->school       = $validated['school'];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('member_photos', 'public');
            $member->photo = $photoPath;
        }

        $member->save();

        return response()->json([
            'success' => true,
            'message' => '✅ Member updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found.'
            ], 404);
        }

        if ($member->photo) {
            $photoPath = public_path('resource/member_images/' . $member->photo);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }

        $qrPath = public_path('qrcode/members/member-' . $member->id . '.png');
        if (File::exists($qrPath)) {
            File::delete($qrPath);
        }

        $member->delete();

        return response()->json([
            'success' => true,
            'message' => '🗑️ Member deleted successfully.'
        ]);
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
                'eccLevel'   => QRCode::ECC_H,
                'scale'      => 8,
                'margin'     => 10,
            ]);

            $qrData = route('members.show', $member->id);
            (new QRCode($options))->render($qrData, $qrPath);
        }

        return $qrPath;
    }

    public function apiShow($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        return response()->json([
            'id'      => $member->id,
            'name'    => $member->first_name . ' ' . $member->last_name,
            'school'  => $member->school,
            'contact' => $member->contactnumber
        ]);
    }


    public function show($id)
{
    $member = Member::findOrFail($id);

    if (!$member) {
        return response()->json(['error' => 'Member not found'], 404);
    }

    // Ensure null values are replaced with empty strings
    $first = $member->first_name ?? '';
    $middle = $member->middle_name ?? '';
    $last = $member->last_name ?? '';

    // Remove extra spaces if middle name is empty
    $fullName = trim("{$first} {$middle} {$last}");

    return response()->json($member);
}


}