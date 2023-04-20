const url = window.location.href;
const regex = /controller=(\w+)&action=(\w+)/;
const found = url.match(regex);

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('.nav-item').forEach(item => {
    if (item.getAttribute('controller') === found[1] && item.getAttribute('action') === found[2]) {
      item.classList.add('active');
    }
  });
});
