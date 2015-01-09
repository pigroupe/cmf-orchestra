<?php
/**
 * This file is part of the <Core> project.
 *
 * @subpackage Core
 * @package    Tests
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 * @since      2012-03-08
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sfynx\CoreBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * This is the base test case for all functional tests.
 * It bootstraps the database before each test class.
 *
 * @todo Decide if this shouldn't go to bootstrap ?
 *       Maybe replace the database by a SQLite in memory ?
 *
 * @subpackage Core
 * @package    Tests
 * @author     Etienne de Longeaux <etienne.delongeaux@gmail.com>
 */
abstract class WebTestCase extends BaseWebTestCase
{
    const USER_EMAIL = 'user@gmail.com';
    const USER_PASS = 'user';
    
    const ADMIN_EMAIL = 'admin@hotmail.com';
    const ADMIN_PASS = 'admin';

    const URL_CONNECTION = '/login';
    const URL_DECONNECTION = '/logout';

    /** @var Application */
    private static $application;

    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new \Symfony\Component\Console\Input\StringInput($command));
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new \Symfony\Bundle\FrameworkBundle\Console\Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }


    protected static function loadUser()
    {
        self::runCommand('doctrine:fixtures:load @SfynxAuthBundle --yml');
    }

    protected static function emptyDatabase()
    {
        self::runCommand('doctrine:database:drop --force');
        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:create');
    }

    /**
     * @param  \Symfony\Bundle\FrameworkBundle\Client $client
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function loginRoleUser(Client $client = null)
    {
        if (!$client) {
            $client = static::createClient();
        }
        $client->request('GET', self::URL_CONNECTION);
        $form = $client->getCrawler()->filter('#login_form input[type=submit]')->first()->form();
        $client->submit(
            $form,
            array(
                'roles' => '{"0":"ROLE_USER"}',
                '_username' => self::USER_EMAIL,
                '_password' => self::USER_PASS
            )
        );
        $client->followRedirect();

        return $client;
    }

    /**
     * @param  \Symfony\Bundle\FrameworkBundle\Client $client
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function loginRoleAdmin(Client $client = null)
    {
        if (!$client) {
            $client = static::createClient();
        }
        $client->request('GET', self::URL_CONNECTION);
        $form = $client->getCrawler()->filter('#login_form input[type=submit]')->first()->form();
        $client->submit(
            $form,
            array(
                'roles' => '{"0":"ROLE_ADMIN","1":"ROLE_SUPER_ADMIN"}',
                '_username' => self::ADMIN_EMAIL,
                '_password' => self::ADMIN_PASS
            )
        );
        $client->followRedirect();

        return $client;
    }

    /**
     * @param  \Symfony\Bundle\FrameworkBundle\Client $client
     * @return WebTestCase
     */
    protected function logout(Client $client)
    {
        $client->request('GET', static::URL_DECONNECTION);
        $client->followRedirect();

        return $this;
    }

    /**
     * Asserts that client's response is of given status code.
     * If not it traverses the response to find symfony error and display it.
     *
     * @param integer $statusCode
     * @param Client  $client
     */
    protected function assertStatusCode($statusCode, Client $client)
    {
        /** @var $response Response */
        $response = $client->getResponse();
        if ($response->isServerError() && $response->getStatusCode() >= 500 && $response->getStatusCode() < 600) {
            $this->assertEquals(
                $statusCode,
                $response->getStatusCode(),
                $client->getCrawler()->filter('.block_exception h1')->text()
            );
        } else {
            $this->assertEquals($statusCode, $response->getStatusCode());
        }
    }

    protected function assertSEOCompatible(Client $client, $type = 'article')
    {
        $crawler = $client->getCrawler();
        $url = $client->getRequest()->getUri();
        $title = $crawler->filter('title')->text();

        // title
        $this->assertNotEmpty($title, 'The title is empty.');
        // meta
        $this->assertCount(1, $crawler->filter('meta[charset=UTF-8]'));
        $this->assertCount(1, $crawler->filter('meta[property="og:title"][content="' . $title . '"]'));
        $this->assertCount(1, $crawler->filter('meta[property="og:type"][content="' . $type . '"]'));
        $this->assertCount(1, $crawler->filter('meta[property="og:url"][content="' . $url . '"]'));
        // img
        // $this->assertCount(0, $crawler->filter('img[alt=""]'));
        $crawler->filter('img:not([alt])')->each(function ($node, $i) {
            $this->assertTrue( false, 'An image with no alt attribute has been found src='. $node->attr('src'));
        });
    }

    protected function dumpCrawler($crawler)
    {
        foreach ($crawler as $dom) {
            print $dom->ownerDocument->saveHTML($dom) . PHP_EOL;
        }
    }

    protected function assertHasPropelHandlerCalled($profile, $event)
    {
        $calledEvents = $profile->getCollector('propel_events')->getCalledListeners();
        $this->assertContains($event, implode(array_keys($calledEvents)));
    }
}