<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Live Server Monitor</title>

  <script src="{{ asset('js/app.js') }}" defer></script>

  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
  <div id="app">
    <header>
      <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}">Live Server Monitor</a>
        </div>
      </nav>
    </header>

    <main class="py-4 container">
      <div class="row">

        @forelse ($hosts as $host)
          <div class="col">
            <div class="card" style="width: 18rem;">
              <div class="card-body">
                <h5 class="card-title">{{ $host->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted" id="host-{{ $host->id }}">Last updated: {{ minValue($host->checks) }}</h6>
                @forelse (onlyEnabled($host->checks) as $check)
                <ul class="mt-3">
                  <li id="check-{{ $check->id }}">
                    {{ $check->type }}: <span class="{{ $check->type }} {{ numberTextClass($check->type, $check->status, $check->last_run_message) }}">{{ $check->last_run_message }}</span>
                  </li>
                </ul>
                @empty
                <p class="card-text">No checks yet</p>
                @endforelse
              </div>
            </div>
          </div>
        @empty
          <p>No hosts yet</p>
        @endforelse

      </div>
    </main>
  </div>

  <script src="{{ asset('js/index.js') }}" defer></script>

</body>
</html>