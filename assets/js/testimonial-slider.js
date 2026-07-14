document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('.testimonial-slider').forEach((slider) => {
		const track = slider.querySelector('.wp-block-post-template');

		if (!track) {
			return;
		}

		const slides = [...track.children];

		if (slides.length <= 1) {
			return;
		}

		const nav = document.createElement('div');

		nav.className = 'testimonial-slider-nav';

		nav.innerHTML = `
				<button class="testimonial-slider-prev" aria-label="Previous">
					<img src="${lawfirmpro.assetsUrl}images/Right.png" alt="Previous">
				</button>

				<button class="testimonial-slider-next" aria-label="Next">
					<img src="${lawfirmpro.assetsUrl}images/Left.png" alt="Next">
				</button>
			`;

		slider.appendChild(nav);

		const prevBtn = nav.querySelector('.testimonial-slider-prev');

		const nextBtn = nav.querySelector('.testimonial-slider-next');

		let currentIndex = 1;

		function updateSlider() {
			const activeSlide = slides[currentIndex];

			const sliderRect = slider.getBoundingClientRect();
			const slideRect = activeSlide.getBoundingClientRect();

			const currentTranslate = track._translateX || 0;

			const slideCenter = slideRect.left + slideRect.width / 2;

			const sliderCenter = sliderRect.left + sliderRect.width / 2;

			const diff = sliderCenter - slideCenter;

			const newTranslate = currentTranslate + diff;

			track.style.transform = `translateX(${newTranslate}px)`;

			track._translateX = newTranslate;

			slides.forEach((slide, index) => {
				slide.classList.toggle('is-active', index === currentIndex);
			});
		}

		nextBtn.addEventListener('click', () => {
			currentIndex++;

			if (currentIndex >= slides.length) {
				currentIndex = 0;
			}

			updateSlider();
		});

		prevBtn.addEventListener('click', () => {
			currentIndex--;

			if (currentIndex < 0) {
				currentIndex = slides.length - 1;
			}

			updateSlider();
		});

		window.addEventListener('resize', updateSlider);

		updateSlider();
	});
});
