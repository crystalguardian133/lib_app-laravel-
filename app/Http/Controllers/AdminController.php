<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrower;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
 public function dashboard()
    {
        $booksCount = DB::table('books')->count();
        $membersCount = DB::table('members')->count();
        $transactionsCount = DB::table('transactions')->count();

        return view('dashboard', compact('booksCount', 'membersCount', 'transactionsCount'));
    }
}
