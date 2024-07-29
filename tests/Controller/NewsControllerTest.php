<?php

namespace App\Test\Controller;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/news/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(News::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Index des actualités');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'news[title]' => 'Testing',
            'news[body]' => 'Testing',
            'news[postDate]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $fixture = new News();
        $fixture->setTitle('My Title');
        $fixture->setBody('My Title');
        $fixture->setPostDate(new \DateTimeImmutable());

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Actualités');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $fixture = new News();
        $fixture->setTitle('Value');
        $fixture->setBody('Value');
        $fixture->setPostDate(new \DateTimeImmutable());

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Mise à jour', [
            'news[title]' => 'Lancement du site web',
            'news[body]' => 'UBC Création lance son site web pour conquérir de nouveaux horizons',
            'news[postDate]' => new \DateTimeImmutable('now'),
        ]);

        self::assertResponseRedirects('/news/');

        $fixture = $this->repository->findAll();

        self::assertSame('Lancement du site web', $fixture[0]->getTitle());
        self::assertSame('UBC Création lance son site web pour conquérir de nouveaux horizons', $fixture[0]->getBody());
        self::assertSame(new \DateTimeImmutable('now'), $fixture[0]->getPostDate());
    }

    public function testRemove(): void
    {
        $fixture = new News();
        $fixture->setTitle('Recrutement ouvert');
        $fixture->setBody('UBC Création recrute un enduiseur et un couvreur-zingeur');
        $fixture->setPostDate(new \DateTimeImmutable('2025-01-13'));

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Supprimer');

        self::assertResponseRedirects('/news/');
        self::assertSame(0, $this->repository->count([]));
    }
}
