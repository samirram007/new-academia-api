<?php

namespace App\Http\Services;

use App\Http\Contracts\FeeFeePaymentServiceInterface;
use App\Models\FeeFeePayment;
use Illuminate\Database\Eloquent\Collection;

class FeeFeePaymentService implements FeeFeePaymentServiceInterface
{
    public function getAll(): Collection
    {
        return FeeFeePayment::all();
    }

    public function getById(int $id): ?FeeFeePayment
    {
        return FeeFeePayment::find($id);
    }

    public function create(array $data): FeeFeePayment
    {
        return FeeFeePayment::create($data);
    }

    public function update(int $id, array $data): FeeFeePayment
    {
        $model = FeeFeePayment::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) FeeFeePayment::destroy($id);
    }
}
