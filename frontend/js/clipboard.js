$(function() {
  $('pre code').before('<div class="btn-copy" title="copy to clipboard"></div>')
  for (const button of document.querySelectorAll('.btn-copy')) {
    button.addEventListener('click', () => {
        try {
            const elem = button.parentNode;
            copyText(elem.innerText);

            button.title = 'copied!';
            button.classList.add('btn-copy-ok');
            setTimeout(() => {
                button.classList.remove('btn-copy-ok');
            }, 3000);
        } catch (e) {
            console.error(e);
        }
    });
  }

  const copyText = text => {
    const t = document.createElement('textarea');
    try  {
        t.value = text;
        document.body.appendChild(t);
        t.select();
        t.setSelectionRange(0, 99999); /*For mobile devices*/
        if (!document.execCommand('copy')) {
            throw new Error('copy command was unsuccessful');
        }
    } finally {
        t.parentNode.removeChild(t);
    }
  };
})
