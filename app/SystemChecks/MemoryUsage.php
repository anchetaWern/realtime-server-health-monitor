<?php
namespace App\SystemChecks;

use Spatie\ServerMonitor\CheckDefinitions\CheckDefinition;
use Symfony\Component\Process\Process;

class MemoryUsage extends CheckDefinition
{
  public $command = "";

  public function resolve(Process $process)
  {
    $percentage = $this->getMemoryUsage();

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


  protected function getMemoryUsage(): float
  {
    $fh = fopen('/proc/meminfo', 'r');
    $mem = 0;
    $all_str = '';

    while ($line = fgets($fh)) {
        $all_str .= $line;
    }
    fclose($fh);

    preg_match_all('/(\d+)/', $all_str, $pieces);

    $used = round($pieces[0][6] / $pieces[0][0], 2);
    return $used;
  }
}