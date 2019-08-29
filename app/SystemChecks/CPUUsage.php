<?php
namespace App\SystemChecks;

use Spatie\ServerMonitor\CheckDefinitions\CheckDefinition;
use Symfony\Component\Process\Process;

class CPUUsage extends CheckDefinition
{
  public $command = "";

  public function resolve(Process $process)
  {
    $percentage = $this->getCPUUsagePercentage();
    $usage = round($percentage, 2);

    $message = "usage at {$usage}%";
    $thresholds = config('server-monitor.cpu_usage_threshold');

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


  protected function getCPUUsagePercentage(): float
  {
    $cpu = shell_exec("grep 'cpu ' /proc/stat | awk '{usage=($2+$4)*100/($2+$4+$5)} END {print usage}'");
    return (float) $cpu;
  }
}