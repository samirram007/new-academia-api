<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\FeeReceiptFacade;
use App\Http\Resources\FeeReceipt\FeeReceiptCollection;


use App\Http\Resources\FeeReceiptResource;
use App\Models\FeeReceipt;
use Illuminate\Http\Request;

class FeeReceiptController extends Controller
{
    public function index(Request $request)
    {
        $data = FeeReceiptFacade::getAll();
        return new FeeReceiptCollection($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receipt_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_mode' => 'nullable|string|max:50',
            'receipt_no' => 'nullable|string|max:100',
            'receipt_note' => 'nullable|string',
            'paid_by_user_id' => 'required|exists:users,id',
            'fee_ids' => 'nullable|array',
            'fee_ids.*' => 'exists:fees,id',
        ]);

        $receipt = FeeReceipt::create($validated);

        if (!empty($validated['fee_ids'])) {
            $receipt->fees()->attach($validated['fee_ids']);
        }

        $receipt->load('paidBy', 'fees');

        return new FeeReceiptResource($receipt);
    }

    public function show(FeeReceipt $feeReceipt)
    {
        $feeReceipt->load('paidBy', 'fees');

        return new FeeReceiptResource($feeReceipt);
    }

    public function update(Request $request, FeeReceipt $feeReceipt)
    {
        $validated = $request->validate([
            'receipt_date' => 'sometimes|date',
            'amount' => 'sometimes|numeric|min:0',
            'payment_mode' => 'nullable|string|max:50',
            'receipt_no' => 'nullable|string|max:100',
            'receipt_note' => 'nullable|string',
            'paid_by_user_id' => 'sometimes|exists:users,id',
            'fee_ids' => 'nullable|array',
            'fee_ids.*' => 'exists:fees,id',
        ]);

        $feeReceipt->update($validated);

        if (array_key_exists('fee_ids', $validated)) {
            $feeReceipt->fees()->sync($validated['fee_ids'] ?? []);
        }

        $feeReceipt->load('paidBy', 'fees');

        return new FeeReceiptResource($feeReceipt);
    }

    public function destroy(FeeReceipt $feeReceipt)
    {
        $feeReceipt->fees()->detach();
        $feeReceipt->delete();

        return response(null, 204);
    }
}
