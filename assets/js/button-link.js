document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.wp-block-post').forEach((post) => {
		const titleLink = post.querySelector('.wp-block-post-title a');
		const arrowImage = post.querySelector('.button-link');

		if (!titleLink || !arrowImage) {
			return;
		}

		arrowImage.style.cursor = 'pointer';

		arrowImage.addEventListener('click', function () {
			window.location.href = titleLink.href;
		});
	});
});
