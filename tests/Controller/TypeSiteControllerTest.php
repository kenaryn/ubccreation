<?php

namespace App\Test\Controller;

use App\Entity\TypeSite;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TypeSiteControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/type/site/';

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
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TypeSite index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

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
        $this->markTestIncomplete();
        $fixture = new TypeSite();
        $fixture->setLabelSite('My Title');
        $fixture->setTeamSize('My Title');
        $fixture->setDescribes('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TypeSite');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new TypeSite();
        $fixture->setLabelSite('Value');
        $fixture->setTeamSize('Value');
        $fixture->setDescribes('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'type_site[labelSite]' => 'Something New',
            'type_site[teamSize]' => 'Something New',
            'type_site[describes]' => 'Something New',
        ]);

        self::assertResponseRedirects('/type/site/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLabelSite());
        self::assertSame('Something New', $fixture[0]->getTeamSize());
        self::assertSame('Something New', $fixture[0]->getDescribes());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new TypeSite();
        $fixture->setLabelSite('Value');
        $fixture->setTeamSize('Value');
        $fixture->setDescribes('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/type/site/');
        self::assertSame(0, $this->repository->count([]));
    }
}
