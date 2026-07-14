document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('.custom-post-slider').forEach((slider) => {
		const track = slider.querySelector('.wp-block-post-template');
		if (!track) return;

		// Convert grid to flex slider
		track.style.display = 'flex';
		track.style.willChange = 'transform';

		const slides = [...track.children];
		if (!slides.length) return;

		let isDragging = false;
		let startX = 0;
		let currentTranslate = 0;
		let prevTranslate = 0;
		let animationId = null;
		let currentIndex = 0;
		let preventClick = false;

		const DRAG_THRESHOLD = 50;

		function getColumns() {
			if (window.innerWidth <= 767) return 1.1;
			if (window.innerWidth <= 991) return 2.1;

			const gridCols = getComputedStyle(track).gridTemplateColumns;
			const cols = gridCols.match(/repeat\((\d+),/)?.[1];

			return cols || 3;
		}

		function getGap() {
			return parseFloat(getComputedStyle(track).gap) || 0;
		}

		function applyWidths() {
			const columns = getColumns();
			const gap = getGap();

			slides.forEach((slide) => {
				slide.style.flex = `0 0 calc((100% - ${
					(columns - 1) * gap
				}px) / ${columns})`;

				slide.style.boxSizing = 'border-box';
			});
		}

		function getSlideWidth() {
			const columns = getColumns();
			const gap = getGap();

			return (track.clientWidth - gap * (columns - 1)) / columns + gap;
		}

		function getMaxIndex() {
			return Math.max(0, slides.length - getColumns());
		}

		function getPositionX(e) {
			return e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
		}

		function setSliderPosition() {
			track.style.transform = `translateX(${currentTranslate}px)`;
		}

		function animation() {
			setSliderPosition();

			if (isDragging) {
				animationId = requestAnimationFrame(animation);
			}
		}

		function setPositionByIndex() {
			currentTranslate = -(currentIndex * getSlideWidth());
			prevTranslate = currentTranslate;

			track.style.transition =
				'transform 0.4s cubic-bezier(0.25,1,0.5,1)';
			setSliderPosition();
		}

		function dragStart(e) {
			isDragging = true;
			preventClick = false;

			startX = getPositionX(e);

			track.style.transition = 'none';

			animationId = requestAnimationFrame(animation);
		}

		function dragMove(e) {
			if (!isDragging) return;

			const currentX = getPositionX(e);
			const moved = currentX - startX;

			if (Math.abs(moved) > 5) {
				preventClick = true;
			}

			currentTranslate = prevTranslate + moved;

			const maxTranslate = -(getMaxIndex() * getSlideWidth());

			if (currentTranslate > 0) {
				currentTranslate *= 0.3;
			} else if (currentTranslate < maxTranslate) {
				currentTranslate =
					maxTranslate + (currentTranslate - maxTranslate) * 0.3;
			}
		}

		function dragEnd() {
			if (!isDragging) return;

			isDragging = false;

			cancelAnimationFrame(animationId);

			const movedBy = currentTranslate - prevTranslate;

			if (movedBy < -DRAG_THRESHOLD && currentIndex < getMaxIndex()) {
				currentIndex++;
			}

			if (movedBy > DRAG_THRESHOLD && currentIndex > 0) {
				currentIndex--;
			}

			setPositionByIndex();
		}

		slider.addEventListener(
			'click',
			(e) => {
				if (preventClick) {
					e.preventDefault();
					e.stopPropagation();
				}
			},
			true
		);

		slider.addEventListener('mousedown', dragStart);
		slider.addEventListener('mousemove', dragMove);
		window.addEventListener('mouseup', dragEnd);

		slider.addEventListener('touchstart', dragStart, {
			passive: true,
		});

		slider.addEventListener('touchmove', dragMove, {
			passive: true,
		});

		window.addEventListener('touchend', dragEnd);

		window.addEventListener('resize', () => {
			applyWidths();

			currentIndex = Math.min(currentIndex, getMaxIndex());

			setPositionByIndex();
		});

		applyWidths();
		setPositionByIndex();
	});
});
