<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Money\Money;
use Money\Currency;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        try {    
            $data = $request->validate([
                '*' => ['required', 'array'],
                '*.date' => ['required', 'string'],
                '*.name' => ['required', 'string'],
                '*.amount' => ['required', 'string'],
                '*.category' => ['nullable', 'array'],
                '*.category.*' => ['integer'],
            ]);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }

        if (count($request->all()) > 100) {
            abort(422, 'Too many transactions in one request');
        }

        $transactions = DB::transaction(function () use ($data) {
            $result = [];

            foreach ($data as $item) {
                $date = Carbon::createFromFormat('d.m.Y H:i:s', $item['date']);

                $money = new Money(
                    (int) bcmul($item['amount'], '100'),
                    new Currency('RUB')
                );

                $transaction = Transaction::create([
                    'date' => $date,
                    'name' => $item['name'],
                    'amount' => $money,
                ]);

               $validCategoryIds = DB::table('transaction_categories')
                ->whereIn('id', $item['category'] ?? [])
                ->pluck('id')
                ->toArray();

                if (!empty($validCategoryIds)) {
                    $transaction->categories()->sync($validCategoryIds);
                }

                $result[] = $transaction->load('categories');
            }

            return $result;
        });

        return response()->json($transactions, 201);
    }

    public function index()
    {
        $transactions = Transaction::with('categories')->get();
        return response()->json($transactions, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
