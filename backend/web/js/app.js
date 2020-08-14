/* global $ */
/* global document */
$(document).ready(() => {
  const approvedVacation = (e) => {
    e.preventDefault();
    const el = $(e.currentTarget);
    const confirmMessage = el.data('confirm-other');
    const url = el.data('url');
    const id = el.data('id');
    if (confirm(confirmMessage)) {
      $.ajax(url, {data: { id }}).done((data) => {
        $('.gridview').html(data);
      });
    }
  };

  $('.js_approve_vacation').on('click', approvedVacation);
});