document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".custom-post-slider").forEach((slider) => {
    const track = slider.querySelector(".wp-block-post-template");
    if (!track) return;

    track.style.display = "flex";
    track.style.willChange = "transform";

    const slides = [...track.children];
    if (!slides.length) return;

    let isDragging = false;
    let startX = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let animationId;
    let currentIndex = 0;
    let preventClick = false;

    const DRAG_THRESHOLD = 50;

    function getColumns() {
      // Mobile
      if (window.innerWidth < 430) return 1.1;

      // Tablet
      if (window.innerWidth < 768) return 2.1;

      // Desktop - Gutenberg columns class
      const columnClass = [...track.classList].find((cls) =>
        cls.startsWith("columns-"),
      );

      return columnClass
        ? parseInt(columnClass.replace("columns-", ""), 10)
        : 3;
    }

    function getGap() {
      return parseFloat(getComputedStyle(track).gap) || 0;
    }

    function applyWidths() {
      const columns = getColumns();
      const gap = getGap();

      const width = `calc((100% - ${(columns - 1) * gap}px) / ${columns})`;

      slides.forEach((slide) => {
        slide.style.flex = `0 0 ${width}`;
      });
    }

    function getSlideWidth() {
      const columns = getColumns();
      const gap = getGap();

      return (track.clientWidth - gap * (columns - 1)) / columns + gap;
    }

    function getMaxIndex() {
      return Math.max(0, slides.length - Math.ceil(getColumns()));
    }

    function setPosition() {
      track.style.transform = `translateX(${currentTranslate}px)`;
    }

    function animation() {
      setPosition();

      if (isDragging) {
        animationId = requestAnimationFrame(animation);
      }
    }

    function updatePosition() {
      currentTranslate = -(currentIndex * getSlideWidth());
      prevTranslate = currentTranslate;

      track.style.transition = "transform .35s ease";
      setPosition();
    }

    function getPointerX(e) {
      return e.type.startsWith("mouse") ? e.pageX : e.touches[0].clientX;
    }

    function dragStart(e) {
      isDragging = true;
      preventClick = false;

      startX = getPointerX(e);

      track.style.transition = "none";

      animationId = requestAnimationFrame(animation);
    }

    function dragMove(e) {
      if (!isDragging) return;

      const moved = getPointerX(e) - startX;

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

      const moved = currentTranslate - prevTranslate;

      if (moved < -DRAG_THRESHOLD && currentIndex < getMaxIndex()) {
        currentIndex++;
      }

      if (moved > DRAG_THRESHOLD && currentIndex > 0) {
        currentIndex--;
      }

      updatePosition();
    }

    slider.addEventListener(
      "click",
      (e) => {
        if (preventClick) {
          e.preventDefault();
          e.stopPropagation();
        }
      },
      true,
    );

    slider.addEventListener("mousedown", dragStart);
    slider.addEventListener("mousemove", dragMove);
    window.addEventListener("mouseup", dragEnd);

    slider.addEventListener("touchstart", dragStart, { passive: true });
    slider.addEventListener("touchmove", dragMove, { passive: false });
    window.addEventListener("touchend", dragEnd);

    window.addEventListener("resize", () => {
      currentIndex = Math.min(currentIndex, getMaxIndex());
      applyWidths();
      updatePosition();
    });

    applyWidths();
    updatePosition();
  });
});
