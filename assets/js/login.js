const regexForm = /&form=(\w+)/;
const foundForm = url.match(regexForm);

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('form-' + foundForm[1]).classList.remove('d-none');
})
