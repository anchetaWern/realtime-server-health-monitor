# Laravel Live Server Monitoring App
A sample Laravel app for monitoring the status of remote servers. This includes monitoring for the following:

- Disk space
- Memory
- CPU
- Apache
- MySQL
- Beanstalkd


### Prerequisites

- PHP development environment - you need to have Apache, PHP, MySQL, and Node. You can use either [Laravel Homestead](https://laravel.com/docs/5.7/homestead), [Laravel Valet](https://laravel.com/docs/5.7/valet), or [Laradock](https://laradock.io/).
- [Pusher channels app instance](https://pusher.com/channels)
- Remote server to monitor which already has the public ssh keys from your local machine. Note that the ssh keys shouldn't have a password assigned to it.


## Getting Started

1. Clone the repo:

```
git clone https://github.com/anchetaWern/realtime-server-health-monitor.git
```


2. Create a new Laravel project:

```
composer create-project --prefer-dist laravel/laravel liveservermonitor
```

3. Copy all the relevant files from the cloned repo over to your newly generate project. Note that only the files that were changed or added for the app is added in the repo. So don't replace entire folders in your project with the one's in the repo. Only copy over the relevant files.

4. Install the backend dependencies:

```
composer install
```

5. Install the frontend dependencies and compile the scripts:

```
npm install
npm run dev
```

6. Update the `.env` file with your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=server_monitor
DB_USERNAME=YOUR_DB_USERNAME
DB_PASSWORD=YOUR_DB_PASSWORD
```

And Pusher credentials:


```
BROADCAST_DRIVER=pusher
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

PUSHER_APP_ID=YOUR_PUSHER_APP_ID
PUSHER_APP_KEY=YOUR_PUSHER_APP_KEY
PUSHER_APP_SECRET=YOUR_PUSHER_APP_SECRET
PUSHER_APP_CLUSTER=YOUR_PUSHER_APP_CLUSTER
```

7. Migrate the database:

```
php artisan migrate
```

8. Add virtual host for your project (e.g. liveservermonitor.loc).


9. Add a host to monitor:

```
php artisan server-monitor:add-host
```

10. Run the checks:


```
php artisan server-monitor:run-checks
```


11. Add project to cron:

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

12. Monitor your servers.


## Built With

- [Laravel](https://laravel.com/)
- [Laravel server monitor](https://github.com/spatie/laravel-server-monitor)
- [Pusher Channels](https://pusher.com/channels)