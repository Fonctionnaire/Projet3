<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlatformControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.scroll')->count()
        );

    }

    public function testTitre()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertGreaterThan(
            0,
            $crawler->filter('h1:contains("BILLETTERIE")')->count()
        );
    }

    public function testForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $buttonCrawlerNode = $crawler->selectButton('Valider');

        $form = $buttonCrawlerNode->form();

        $client->submit($form);

    }

    public function testLien()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $link = $crawler
            ->filter('a:contains("Horaire")')
            ->eq(0)
            ->link();

        $client->click($link);
    }

    public function testRecapContent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/recapitulatif');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("p")')->count()
        );

    }

    public function testRecapLien()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/recapitulatif');

        $link = $crawler
            ->filter('a:contains("lien")')
            ->link();

        $client->click($link);
    }

    public function testConfirmationLien()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/confirmation');

        $link = $crawler
            ->filter('a:contains("lien")')
            ->link();

        $client->click($link);
    }


}
