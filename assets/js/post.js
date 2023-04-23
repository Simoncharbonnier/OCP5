document.addEventListener('DOMContentLoaded', () => {
  const post = document.querySelector('.post');

  const img = document.getElementById('post-img');
  let imgSaved = '';
  if (img.src.match('/assets/img/post/')) {
    imgSaved = img.src;
  }

  const btnImgAdd = document.getElementById('btn-img-add');
  const btnImgDelete = document.getElementById('btn-img-delete');
  const btnImgCancel = document.getElementById('btn-img-cancel');

  const imgInput = document.getElementById('image-input');
  const imgChangedInput = document.getElementById('image-changed-input');

  document.getElementById('btn-edit-post').addEventListener('click', function(e) {
    post.classList.add('editing');
    if (imgSaved) {
      btnImgDelete.classList.remove('d-none');
    } else {
      btnImgAdd.classList.remove('d-none');
    }
  });

  document.getElementById('btn-edit-post-cancel').addEventListener('click', function(e) {
    post.classList.remove('editing');
    btnImgAdd.classList.add('d-none');
    btnImgDelete.classList.add('d-none');
    btnImgCancel.classList.add('d-none');
    img.src = imgSaved;
    imgChangedInput.setAttribute('value', 'false');
  });

  img.addEventListener('click', function(e) {
    if (post.classList.contains('editing')) {
      click(imgInput);
    }
  });

  btnImgAdd.addEventListener('click', function(e) {
    click(imgInput);
  });

  btnImgDelete.addEventListener('click', function(e) {
    img.src = '';
    btnImgDelete.classList.add('d-none');
    btnImgAdd.classList.remove('d-none');
    btnImgCancel.classList.remove('d-none');
    imgChangedInput.setAttribute('value', 'true');
  });

  btnImgCancel.addEventListener('click', function(e) {
    img.src = imgSaved;
    btnImgCancel.classList.add('d-none');
    if (imgSaved) {
      btnImgDelete.classList.remove('d-none');
      btnImgAdd.classList.add('d-none');
    } else {
      btnImgDelete.classList.add('d-none');
      btnImgAdd.classList.remove('d-none');
    }
    imgChangedInput.setAttribute('value', 'false');
  });

  imgInput.addEventListener('change', function(e) {
    const file = imgInput.files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onloadend = function() {
      img.src = reader.result;
    }

    btnImgAdd.classList.add('d-none');
    btnImgDelete.classList.add('d-none');
    btnImgCancel.classList.remove('d-none');

    imgChangedInput.setAttribute('value', 'true');
  });

  function click(target) {
    const event = new MouseEvent("click");
    target.dispatchEvent(event);
  };
})
