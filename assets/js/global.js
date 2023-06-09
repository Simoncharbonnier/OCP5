const url = window.location.href;
const regex = /controller=(\w+)&action=(\w+)/;
const found = url.match(regex);

function click(target) {
	const event = new MouseEvent("click");
	target.dispatchEvent(event);
}

document.addEventListener("DOMContentLoaded", () => {
	// Active navbar

	document.querySelectorAll(".nav-item").forEach(item => {
		if (found && item.getAttribute("controller") === found[1] && item.getAttribute("action") === found[2]) {
			if (found[2] === "login") {
				const regexForm = /&form=(\w+)/;
				const foundForm = url.match(regexForm);
				if (item.getAttribute("form") === foundForm[1]) {
					item.classList.add("active");
				}
			} else {
				item.classList.add("active");
			}
		} else if (found === null && item.getAttribute("controller") === "home" && item.getAttribute("action") === "index") {
			item.classList.add("active");
		}
	});

	// Responsive navbar

	if (document.getElementById("btn-menu-responsive")) {
		document.getElementById("btn-menu-responsive").addEventListener("click", function() {
			const navbar = document.querySelector(".navbar");
			if (navbar.classList.contains("responsive-menu-open")) {
				document.querySelector(".navbar").classList.remove("responsive-menu-open");
			} else {
				document.querySelector(".navbar").classList.add("responsive-menu-open");
			}
		})
	}

	// Notif cross

	if (document.getElementById("notif-cross")) {
		document.getElementById("notif-cross").addEventListener("click", function(e) {
			e.target.closest(".notif").classList.add("d-none");
		})
	}

	// Handle image in modal form add post

	const modalAddPostImg = document.getElementById("modal-add-post-img");
	const modalAddPostImgInput = document.getElementById("modal-add-post-img-input");
	const modalAddPostBtnImgAdd = document.getElementById("modal-add-post-btn-img");
    const modalAddPostBtnImgCancel = document.getElementById("modal-add-post-btn-img-cancel");

	if (modalAddPostImg) {
		modalAddPostImg.addEventListener("click", function() {
			click(modalAddPostImgInput);
		});

		modalAddPostBtnImgAdd.addEventListener("click", function() {
			click(modalAddPostImgInput);
		});

		modalAddPostBtnImgCancel.addEventListener("click", function() {
			modalAddPostImg.src = "";
			modalAddPostBtnImgCancel.classList.add("d-none");
			modalAddPostBtnImgAdd.classList.remove("d-none");
			modalAddPostImgInput.value = "";
		});

		modalAddPostImgInput.addEventListener("change", function() {
			const file = modalAddPostImgInput.files[0];
			const reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onloadend = function() {
				modalAddPostImg.src = reader.result;
			}

			modalAddPostBtnImgAdd.classList.add("d-none");
			modalAddPostBtnImgCancel.classList.remove("d-none");
		});
	}
});
