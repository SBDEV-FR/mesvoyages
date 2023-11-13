<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of VoyagesControllerTest
 *
 * @author selsa
 */
class VoyagesControllerTest extends WebTestCase{

    public function testAccessPage(){
        $client = static::createClient();
        $client->request('Get', '/voyages');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    public function testContenuPage(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');
        $this->assertSelectorTextContains('h1', 'Mes voyages');
        $this->assertSelectorTextContains('th', 'Ville');
        $this->assertCount(4, $crawler->filter('th'));
        $this->assertSelectorTextContains('h5', 'Le chambon Feugeorlles');
    }
    
    public function testLinkVille(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        // clic sur le lien (le nom d'une ville)
        $client->clickLink('Le chambon Feugeorlles');
        // récupération du résultat du clic
        $response = $client->getResponse();
//        dd($client->getRequest());
        // contrôle si le client existe
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        // récupération de la route et contrôle qu'elle est correcte
        $uri = $client->getRequest()->server->get('REQUEST_URI');
        $this->assertEquals('/voyages/voyage/102', $uri);
    }
    public function testFiltreVille()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');

        // Debug: Dump the HTML content to the console for inspection
        var_dump($client->getResponse()->getContent());

        // Simulation of form submission
        $form = $crawler->selectButton('filtrer')->form();
        $form['recherche'] = 'Saint Etienne';
        $crawler = $client->submit($form);

        // Debug: Dump the HTML content after form submission
        var_dump($client->getResponse()->getContent());

        // Check the number of 'h5' elements
        $this->assertCount(1, $crawler->filter('h5'));

        // Check if the 'h5' element contains the expected text
        $this->assertSelectorTextContains('h5', 'Saint Etienne');
    }
}
