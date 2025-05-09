document.addEventListener('DOMContentLoaded', function () {
	const faqItems = document.querySelectorAll('.faq-item');

	faqItems.forEach(faq => {
		const question = faq.querySelector('.faq-item-title');
		const answer = faq.querySelector('.faq-item-description');

		question.addEventListener('click', () => {
			answer.classList.toggle('show');
			question.classList.toggle('open');
		});
	});
});