<?php
function textClass($status, $last_message) {
  if ($last_message == 'is running') {
    return ($status == 'success') ? 'text-success' : 'text-danger';
  }

  return ($status == 'failed') ? 'text-danger' : '';
}

function onlyEnabled($collection) {
  return $collection->filter(function($item) {
    return $item->enabled == 1;
  });
}

function minValue($checks) {
  return min(array_column($checks->toArray(), 'last_ran_at'));
}

function numberTextClass($type, $status, $text) {
  $configs = [
    'diskspace' => 'server-monitor.diskspace_percentage_threshold',
    'cpu' => 'server-monitor.cpu_usage_threshold',
    'memory' => 'server-monitor.memory_usage_threshold'
  ];

  preg_match('/(\d+)/', $text, $pieces);

  if (!empty($pieces)) {
    $number = (float) $pieces[0];
    $config = config($configs[$type]);
    return ($number >= $config['fail']) ? 'text-danger' : (($number >= $config['warning']) ? 'text-warning' : '');
  }

  return textClass($status, $text);
}