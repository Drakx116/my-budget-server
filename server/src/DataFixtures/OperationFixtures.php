<?php

namespace App\DataFixtures;

use App\Entity\Operation;
use App\Enum\OperationType;
use App\Enum\PaymentType;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OperationFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userRepository->findOneBy([]);

        $operations = [
            [
                'label' => 'L\'Oeil Vintage - Jeans Levis',
                'amount' => 25.00,
                'type' => OperationType::EXPENSE,
                'method' => PaymentType::CASH,
                'date' => (new \DateTime())->setDate(2022, 03, 26),
            ], [
                'label' => 'Bistrot d\'en face - Anniversaire Clara',
                'amount' => 48,
                'type' => OperationType::EXPENSE,
                'method' => PaymentType::MEAL_VOUCHER,
                'date' => (new \DateTime())->setDate(2022, 04, 10),
            ], [
                'label' => 'Facture Free - Mai 2022',
                'amount' => 15.99,
                'type' => OperationType::EXPENSE,
                'method' => PaymentType::CASH,
                'date' => (new \DateTime())->setDate(2022, 04, 15),
            ], [
                'label' => 'Remboursement Courses - Soirée Manon',
                'amount' => 10,
                'type' => OperationType::INCOME,
                'method' => PaymentType::CREDIT_CARD,
                'date' => (new \DateTime())->setDate(2022, 05, 02),
            ], [
                'label' => 'Chèque Théo - Cadeau Éva',
                'amount' => 20,
                'type' => OperationType::EXPENSE,
                'method' => PaymentType::CHECK,
                'date' => (new \DateTime())->setDate(2022, 05, 11),
            ]
        ];

        foreach ($operations as $data) {
            $operation = (new Operation())
                ->setAmount($data['amount'])
                ->setAuthor($user)
                ->setDate($data['date'])
                ->setLabel($data['label'])
                ->setMethod($data['method'])
                ->setType($data['type']);

            $manager->persist($operation);
        }

        $manager->flush();
    }
}
