document.addEventListener("DOMContentLoaded", () => {
	document.querySelectorAll(".btn-delete-comment").forEach(btn => {
		btn.addEventListener("click", function(e) {
			const comment = document.getElementById("comment-" + e.target.getAttribute("data-comment-id"));
			comment.classList.add("deleting");
		});
	});

	document.querySelectorAll(".btn-cancel-delete-comment").forEach(btn => {
		btn.addEventListener("click", function(e) {
			const comment = document.getElementById("comment-" + e.target.getAttribute("data-comment-id"));
			comment.classList.remove("deleting");
		});
	});
});
