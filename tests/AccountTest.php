<?php
use CodeIgniter\Test\FeatureTestCase;

class AccountTest extends FeatureTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testRegisterPage()
    {
        $result = $this->get('/');

        $this->assertTrue($result->isOK());
    }

    public function testHomePage()
    {
        $result = $this->get('/home');

        $result->assertRedirect();
    }
}