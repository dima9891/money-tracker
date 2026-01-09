<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionCategory;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            TransactionCategory::all(),
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'categories' => ['required', 'array', 'min:1'],
                'categories.*' => ['required', 'string', 'min:1', 'max:255'],
            ]);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }

        $created = [];

        DB::transaction(function () use ($data, &$created) {
            foreach ($data['categories'] as $name) {
                $category = TransactionCategory::firstOrCreate(
                    ['name' => $name]
                );

                if ($category->wasRecentlyCreated) {
                    $created[] = $category;
                }
            }
        });

        return response()->json(
            [
                'created' => $created,
                'total_created' => count($created),
            ],
            201,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
