<?php
namespace App\SystemChecks;
use Spatie\ServerMonitor\CheckDefinitions\CheckDefinition;
use Symfony\Component\Process\Process;

class Apache extends CheckDefinition
{
  public $command = 'service apache2 status';

  public function resolve(Process $process)
  {
    if (str_contains($process->getOutput(), 'active (running)')) {
      $this->check->succeed('is running');
      return;
    }

    $this->check->fail('is not running');
  }
}