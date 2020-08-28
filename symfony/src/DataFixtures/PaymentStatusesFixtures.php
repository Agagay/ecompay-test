<?php

namespace App\DataFixtures;

use App\Entity\PaymentStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaymentStatusesFixtures extends Fixture
{
    const STATUSES = [
        'init',
        'external',
        'delivered',
        'awaiting_callback',
        'received',
        'decline',
        'success',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::STATUSES as $status) {
            $paymentStatus = new PaymentStatus();
            $paymentStatus->setCode($status);
            $manager->persist($paymentStatus);
        }

        $manager->flush();
    }
}
