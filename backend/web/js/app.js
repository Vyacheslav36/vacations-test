/* global $ */
/* global document */
$(document).ready(() => {
  const approvedVacation = (e) => {
    e.preventDefault();
    const el = $(e.currentTarget);
    const confirmMessage = el.data('confirm-other');
    const url = el.data('url');
    const id = el.data('id');
    console.log(el, confirmMessage, url, id)
    if (confirm(confirmMessage)) {
      $.ajax({
        type: 'GET',
        url,
        data: {
          id
        },
        success: data => $('.gridview').html(data),
        error: () => console.log('error')
      });
    }
  };

  $('.js_approve_vacation').on('click', approvedVacation);
});