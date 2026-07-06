<?php

namespace App\Http\Contracts;

use App\Models\FeeFeePayment;
use Illuminate\Database\Eloquent\Collection;

interface FeeFeePaymentServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?FeeFeePayment;
    public function create(array $data): FeeFeePayment;
    public function update(int $id, array $data): FeeFeePayment;
    public function delete(int $id): bool;
}
