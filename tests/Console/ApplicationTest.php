<?php
namespace hanneskod\exemplify\Console;

use Symfony\Component\Console\Tester\CommandTester;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $command = $application->find('run');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array());
        $this->assertRegExp('//', $commandTester->getDisplay());
    }
}
