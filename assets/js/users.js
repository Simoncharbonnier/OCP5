document.addEventListener("DOMContentLoaded", () => {
	document.querySelectorAll(".btn-delete-user").forEach(btn => {
		btn.addEventListener("click", function(e) {
			const user = document.getElementById("user-" + e.target.getAttribute("data-user-id"));
			user.classList.add("deleting");
		});
	});

	document.querySelectorAll(".btn-cancel-delete-user").forEach(btn => {
		btn.addEventListener("click", function(e) {
			const user = document.getElementById("user-" + e.target.getAttribute("data-user-id"));
			user.classList.remove("deleting");
		});
	});
});
