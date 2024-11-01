readyDOM(() => {
	BX.bindDelegate(document, 'click', { class: '_vk-video' }, function () {
		const src = this.dataset.url;
		if (!src) return;

		const nodeIframe = BX.create('iframe', {
			attrs: {
				height: '100%',
				width: '100%',
				allow: 'clipboard-write; autoplay',
				frameborder: "0",
				webkitAllowFullScreen: '',
				mozallowfullscreen: '',
				allowFullScreen: '',
				src,
			},
		});

		const nodeParent = this.parentNode;

		nodeParent.innerHTML = '';
		nodeParent.appendChild(nodeIframe);
	});
})