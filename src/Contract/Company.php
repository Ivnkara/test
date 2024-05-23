<?php

declare(strict_types=1);

namespace App\Contract;

use App\Entity\Company as CompanyEntity;

interface Company
{
    public function create(CompanyEntity $company): void;
    public function update(CompanyEntity $company): void;
    public function delete(CompanyEntity $company): void;
    public function show(int $companyId): ?CompanyEntity;
    public function list(): array;
}
