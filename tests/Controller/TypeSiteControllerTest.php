<?php

namespace App\Test\Controller;

use App\Entity\TypeSite;
use App\Entity\Yard;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TypeSiteControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/admin/type/site/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(TypeSite::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        // Provides a dedicated test container with access to both public and private services.
        $userRepository = static::getContainer()->get(UserRepository::class);

        // Retrieve the test user.
        $testUser = $userRepository->findOneByEmail('aurelien');

        // Simulate $testUser being logged in.
        $this->client->loginUser($testUser);

        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Index des types de chantier');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        $this->client->submitForm('Save', [
            'type_site[labelSite]' => 'Testing',
            'type_site[teamSize]' => 'Testing',
            'type_site[describes]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $fixture = new TypeSite();
        $fixture->setLabelSite('Piscine');
        $fixture->setTeamSize(3);
        $fixture->setDescribes(new Yard('Ma piscine secondaire'));

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TypeSite');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $fixture = new TypeSite();
        $fixture->setLabelSite('Extension');
        $fixture->setTeamSize(2);
        $fixture->setDescribes(new Yard('Ma véranda de luxe'));

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'type_site[labelSite]' => 'Extension',
            'type_site[teamSize]' => 3,
            'type_site[describes]' => 'Ma vérandu pontificale',
        ]);

        self::assertResponseRedirects('/type/site/');

        $fixture = $this->repository->findAll();

        self::assertSame('Extension', $fixture[0]->getLabelSite());
        self::assertSame(3, $fixture[0]->getTeamSize());
        self::assertSame('Ma véranda pontificale', $fixture[0]->getDescribes());
    }

    public function testRemove(): void
    {
        $fixture = new TypeSite();
        $fixture->setLabelSite('Rénovation');
        $fixture->setTeamSize(4);
        $fixture->setDescribes(new Yard('Ma grange en ruine'));

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/type/site/');
        self::assertSame(0, $this->repository->count([]));
    }
}
