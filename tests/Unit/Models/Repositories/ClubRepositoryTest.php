<?php

namespace Models\Repositories;

use App\Models\Repositories\ClubRepository;
use PHPUnit\Framework\TestCase;

class ClubRepositoryTest extends TestCase
{

    public function testGetNearestClubs()
    {
        $clubRepository = new ClubRepository();
        $clubs = $clubRepository->getNearestClubs(50.087451, 14.420671);
        $this->assertIsArray($clubs);
        $this->assertNotEmpty($clubs);

    }
}
