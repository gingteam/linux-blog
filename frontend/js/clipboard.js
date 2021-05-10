$(function() {
  $('pre code').addClass('notranslate')
    .before('<div class="btn-copy" title="copy to clipboard"></div>')
    .parent().wrap('<div class="console"></div>');

  $('.btn-copy').on('click', function() {
    try {
      copyText($(this).parent().text());

      $(this).attr('title', 'copied!')
        .addClass('btn-copy-ok');
      setTimeout(() => {
        $(this).removeClass('btn-copy-ok');
      }, 3000);
    } catch (e) {
      console.error(e);
    }
  });

  const copyText = text => {
    const t = $('<textarea>');
    try {
      t.text(text);
      $('body').append(t);
      t.select();
      if (!document.execCommand('copy')) {
        throw new Error('copy command was unsuccessful');
      }
    } finally {
      t.remove();
    }
  };
})
