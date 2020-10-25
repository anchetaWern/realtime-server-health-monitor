<?php
namespace App\SystemChecks;

use Spatie\ServerMonitor\CheckDefinitions\CheckDefinition;
use Symfony\Component\Process\Process;

class MemoryUsage extends CheckDefinition
{
  public $command = "cat /proc/meminfo";

  public function resolve(Process $process)
  {
    $percentage = $this->getMemoryUsage($process->getOutput());

    $message = "usage at {$percentage}%";
    $thresholds = config('server-monitor.memory_usage_threshold');

    if ($percentage >= $thresholds['fail']) {
      $this->check->fail($message);
      return;
    }

    if ($percentage >= $thresholds['warning']) {
      $this->check->warn($message);
      return;
    }

    $this->check->succeed($message);
  }


  protected function getMemoryUsage(string $commandOutput): float
  {
    preg_match_all('/(\d+)/', $commandOutput, $pieces);

    $used = round(($pieces[0][6] / $pieces[0][0]) * 100, 2);
    return $used;
  }
}