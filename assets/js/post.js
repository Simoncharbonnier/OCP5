document.addEventListener('DOMContentLoaded', () => {
  function edit() {
    const post = document.querySelector('.post');
    if (post.classList.contains('editing')) {
      document.querySelector('.post').classList.remove('editing');
      document.getElementById('btn-delete-post').classList.remove('d-none');
    } else {
      document.querySelector('.post').classList.add('editing');
      document.getElementById('btn-delete-post').classList.add('d-none');
    }
  }

  document.getElementById('btn-edit-post').addEventListener('click', function(e) {
    edit();
  });

  document.getElementById('btn-edit-post-cancel').addEventListener('click', function(e) {
    edit();
  });
})
