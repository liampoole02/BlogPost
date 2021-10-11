<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');

        $response->assertSeeText('Welcome to the home page');

        $response->assertSeeText('Laravel App');

    }

    public function testContactPageIsWorkingCorrectly()
    {
        $reponse=$this->get('/contact');

        $reponse->assertSeeText('Please feel free to contact us by submitting your query in the form below');

        $reponse->assertSeeText('First Name');

    }
}
