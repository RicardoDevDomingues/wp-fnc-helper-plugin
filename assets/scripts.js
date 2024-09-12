jQuery(document).ready(function ($) {
  $('.wc-fnc-helper-form').on('submit', function (e) {
    $('.wc-fnc-helper-submit-button')
      .prop('disabled', true)
      .html('<div class="wc-fnc-helper-loader"></div>');
  });
});
