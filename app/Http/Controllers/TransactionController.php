<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Get list transaction history
     *
     */
    public function index() {
        return Transaction::all('id', 'description', 'user_id', 'created_at');
    }
}
