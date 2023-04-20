document.addEventListener('DOMContentLoaded', () => {
  function edit() {
    const post = document.querySelector('.post');
    if (post.classList.contains('editing')) {
      document.querySelector('.post').classList.remove('editing');
    } else {
      document.querySelector('.post').classList.add('editing');
    }
  }

  document.getElementById('btn-edit-post').addEventListener('click', function(e) {
    edit();
  });

  document.getElementById('btn-edit-post-cancel').addEventListener('click', function(e) {
    edit();
  });
})
