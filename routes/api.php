<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Member;
use App\Http\Controllers\MemberController;

// Clean API route for getting member info
Route::get('/members/{id}', [MemberController::class, 'apiShow']);

Route::get('/members/{id}', function ($id) {
    $member = Member::find($id);
    if (!$member) {
        return response()->json(['message' => 'Not found'], 404);
    }
    return response()->json(['name' => $member->name]);
});