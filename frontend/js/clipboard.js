$(function() {
  $('pre code').append('<span class="command-copy"><i class="fa fa-clipboard" aria-hidden="true"></i></span>')

  $('code span.command-copy').on('click', function(e) {
    const text = $(this).parent().text().trim()
    const textArea = document.createElement('textarea')
    textArea.value = text
    document.body.appendChild(textArea)
    textArea.select()
    textArea.setSelectionRange(0, 99999)
    document.execCommand('copy')
    document.body.removeChild(textArea)
  })
})
