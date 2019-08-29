$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

window.Visibility = require('visibilityjs');

window.Echo.channel('live-monitor')
.listen('.finished.check', (e) => {

  const { id, type, last_run_message, element_class, last_update, host_id } = e.message;

  $(`#${id} .${type}`)
    .text(last_run_message)
    .removeClass('text-success text-danger text-warning')
    .addClass(element_class);

  $(`#${host_id}`).text(`Last update: ${last_update}`);
});


Visibility.change(function (e, state) {
  $.post('/page-visibility', { state });
});