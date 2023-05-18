document.addEventListener("DOMContentLoaded", () => {

	const formUser = document.getElementById("form-edit-user");

	const btnEdit = document.getElementById("btn-edit-user");
	const btnCancel = document.getElementById("btn-edit-user-cancel");
	const btnDeleteAvatar = document.getElementById("btn-delete-avatar");

	const avatar = document.getElementById("avatar");
	const avatarSaved = avatar.src;
	const avatarInput = document.getElementById("avatar-input");
	const avatarInputSaved = avatarInput.value;
	const fileInput = document.getElementById("file-input");

	btnEdit.addEventListener("click", function(e) {
		formUser.classList.add("editing");
		btnEdit.classList.add("d-none");
		btnCancel.classList.remove("d-none");

		if (avatarInput.getAttribute("value") === "default.jpg") {
			btnDeleteAvatar.classList.add("d-none");
		} else {
			btnDeleteAvatar.classList.remove("d-none");
		}
	});

	btnCancel.addEventListener("click", function(e) {
		formUser.classList.remove("editing");
		btnEdit.classList.remove("d-none");
		btnCancel.classList.add("d-none");

		avatar.src = avatarSaved;
		avatarInput.setAttribute("value", avatarInputSaved);
	});

	avatar.addEventListener("click", function(e) {
		if (formUser.classList.contains("editing")) {
			click(fileInput);
		}
	});

	fileInput.addEventListener("change", function(e) {
		const file = fileInput.files[0];
		const reader = new FileReader();
		reader.readAsDataURL(file);
		reader.onloadend = function() {
			avatar.src = reader.result;
		}
		avatarInput.setAttribute("value", "changed");

		btnCancel.classList.remove("d-none");
		btnDeleteAvatar.classList.remove("d-none");
	});

	btnDeleteAvatar.addEventListener("click", function(e) {
		avatar.src = "assets/img/user/default.jpg";
		avatarInput.setAttribute("value", "default.jpg");

		btnDeleteAvatar.classList.add("d-none");
	});
});
