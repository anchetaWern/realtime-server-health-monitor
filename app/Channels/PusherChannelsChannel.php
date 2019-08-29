<?php
namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;
use App\Events\FinishedCheck;

class PusherChannelsChannel
{

  public function send($notifiable, Notification $notification)
  {
    if (Cache::get('page_visibility') == 'visible') {

      $id = $notification->event->check->id;
      $type = $notification->event->check->type;
      $status = $notification->event->check->status;
      $last_run_message = $notification->event->check->last_run_message;
      $host_id = $notification->event->check->host_id;

      event(new FinishedCheck([
        'id' => 'check-' . $id,
        'type' => $type,
        'status' => $status,
        'last_run_message' => $last_run_message,
        'element_class' => numberTextClass($type, $status, $last_run_message),
        'last_update' => now()->toDateTimeString(),
        'host_id' => 'host-' . $host_id
      ]));

    }

  }
}