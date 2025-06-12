<?php
namespace App\Services;

use App\Repositories\GovernorateRepository;

class GovernorateService
{
    protected $governorateRepository;

    public function __construct(GovernorateRepository $governorateRepository)
    {
        $this->governorateRepository = $governorateRepository;
    }

    public function getAllGovernorates()
    {
        return $this->governorateRepository->getAllGovernorates();

    }

}
