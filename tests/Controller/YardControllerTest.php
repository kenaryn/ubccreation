<?php

namespace App\Test\Controller;

use App\Entity\Yard;
use App\Entity\Proposal;
use App\Entity\TypeSite;
use App\Entity\Urgency;
use App\Repository\TypeSiteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class YardControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/yard/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Yard::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        /**
         * Test the nominal end-user scenario performing an log in action.
         * The expected result MUST be the HTTP response code 200.
         */
        $userRepository = static::getContainer()->get(UserRepository::class);

        // Retriever the test user.
        $testUser = $userRepository->findOneByEmail('aurelien');
        // Simulate $testUser being logged in.
        $this->client->loginUser($testUser);

        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Index des chantiers');
    }

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());

    public function testNew(): void
    {
        /**
         * Test the nominal end-user scenario performing an log in action.
         */
        $this->client->request('GET', sprintf('%snew', $this->path));


        $this->client->submitForm('Save', [
            'yard[city]' => 'Argelès',
            'yard[budget]' => 16500,
            'yard[materials]' => 'Bio-membrane, frêne',
            'yard[projectDate]' => (new \DateTimeImmutable('2024-10-31')),
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $fixture = new Yard();
        $fixture->setCity('Orléans');
        $fixture->setBudget(3200);
        $fixture->setMaterials('chêne');
        $fixture->setProjectDate(new \DateTimeImmutable());

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Chantier');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $fixture = new Yard();
        $fixture->setCity('Ur');
        $fixture->setBudget(4500);
        $fixture->setMaterials('Polyuréthane, polystyrène, chêne');
        $fixture->setProjectDate(new \DateTimeImmutable());

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Mise à jour', [
            'yard[city]' => 'Ur',
            'yard[budget]' => 4500,
            'yard[materials]' => 'Polyuréthane, polystyrène, chêne',
            'yard[date]' => (new \DateTimeImmutable("2025-03-20 08:30"))->format("Y-m-d H:i"),
        ]);

        self::assertResponseRedirects('/yard/');

        $fixture = $this->repository->findAll();

        self::assertSame('Ur', $fixture[0]->getCity());
        self::assertSame(4500, $fixture[0]->getBudget());
        self::assertSame('Polyuréthane, polystyrène, chêne', $fixture[0]->getMaterials());
        self::assertSame((new \DateTimeImmutable("2025-03-20 08:30")), $fixture[0]->getDate());
    }

    public function testRemove(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        // Retriever the test user.
        $testUser = $userRepository->findOneByEmail('aurelien');
        // Simulate $testUser being logged in.
        $this->client->loginUser($testUser);

        $repository = static::getContainer()->get(TypeSiteRepository::class);
        $nb = count($repository->findAll());

        $fixture = new Yard();
        $fixture->setCity('Moscou');
        $fixture->setBudget(432);
        $fixture->setMaterials('Hêtre');
        $fixture->setProjectDate(new \DateTimeImmutable(2024 - 12 - 12));
        $fixture->setCreationDate(new \DateTimeImmutable());
        $typeSite = new TypeSite();

        $typeSite->setLabelSite('Ravalement');
        $typeSite->setTeamSize(42);
        $this->manager->persist($typeSite);

        $fixture->setTypeSite($typeSite);
        $fixture->setUrgency(Urgency::Low);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('POST', sprintf('%s%s', $this->path, $fixture->getId()));


        self::assertResponseRedirects('/yard/');
        self::assertSame($nb, $this->repository->count([]));
    }
}
