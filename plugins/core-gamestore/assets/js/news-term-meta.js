jQuery(document).ready(function ($) {
	function mediaUploader(button, input) {
		var custom_uploader = wp.media({
			title: 'Select Icon',
			button: { text: 'Use this icon' },
			multiple: false
		})
			.on('select', function () {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				input.val(attachment.url);
			})
			.open();
	}
	$(document).on('click', '.news-category-upload-icon', function (e) {
		e.preventDefault();
		var input = $(this).prev('input');
		mediaUploader($(this), input);
	});
});