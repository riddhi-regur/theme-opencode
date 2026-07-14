// document.addEventListener('DOMContentLoaded', () => {
// 	const faqItems = document.querySelectorAll('.lawfirmpro-faq-item');

// 	// Open first FAQ by default
// 	if (faqItems.length > 0) {
// 		faqItems[0].classList.add('active');
// 	}

// 	faqItems.forEach((item) => {
// 		const title = item.querySelector('.faq-title');

// 		title?.addEventListener('click', () => {
// 			const isActive = item.classList.contains('active');

// 			// Close all FAQs
// 			faqItems.forEach((faq) => {
// 				faq.classList.remove('active');
// 			});

// 			// Re-open clicked one if it wasn't already open
// 			if (!isActive) {
// 				item.classList.add('active');
// 			}
// 		});
// 	});
// });
document.addEventListener('DOMContentLoaded', () => {
	const PLUS_ICON = `${lawfirmpro.assetsUrl}images/plus.png`;
	const MINUS_ICON = `${lawfirmpro.assetsUrl}images/minus.png`;

	const faqItems = document.querySelectorAll('.faq-item');

	// Open first FAQ by default
	if (faqItems.length) {
		faqItems.forEach((item, index) => {
			const icon = item.querySelector('.faq-icon img');

			if (index === 0) {
				item.classList.add('active');

				if (icon) {
					icon.src = MINUS_ICON;
				}
			} else {
				item.classList.remove('active');

				if (icon) {
					icon.src = PLUS_ICON;
				}
			}
		});
	}

	// Accordion functionality
	faqItems.forEach((item) => {
		const header = item.querySelector('.faq-header');

		header.addEventListener('click', () => {
			// Prevent closing currently open item
			if (item.classList.contains('active')) {
				return;
			}

			// Close all items
			faqItems.forEach((faq) => {
				faq.classList.remove('active');

				const icon = faq.querySelector('.faq-icon img');

				if (icon) {
					icon.src = PLUS_ICON;
				}
			});

			// Open clicked item
			item.classList.add('active');

			const icon = item.querySelector('.faq-icon img');

			if (icon) {
				icon.src = MINUS_ICON;
			}
		});
	});
});
