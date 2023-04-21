document.addEventListener('DOMContentLoaded', () => {
  const post = document.querySelector('.post');

  document.getElementById('btn-edit-post').addEventListener('click', function(e) {
    document.querySelector('.post').classList.add('editing');
  });

  document.getElementById('btn-edit-post-cancel').addEventListener('click', function(e) {
    document.querySelector('.post').classList.remove('editing');
  });
})
