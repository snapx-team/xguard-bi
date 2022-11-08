<?php

namespace Xguard\BusinessIntelligence\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Xguard\BusinessIntelligence\Repositories\ErpContractsRepository;
use Xguard\BusinessIntelligence\Repositories\ErpUsersRepository;

class ErpController extends Controller
{

    public function getAllUsers(): Collection
    {
        return ErpUsersRepository::getAllUsers();
    }

    public function getSomeUsers($search): Collection
    {
        return ErpUsersRepository::getSomeUsers($search);
    }

    public function getAllActiveContracts(): array
    {
        return ErpContractsRepository::getAllActiveContracts();
    }

    public function getSomeActiveContracts($search): array
    {
        return ErpContractsRepository::getSomeActiveContracts($search);
    }
}
