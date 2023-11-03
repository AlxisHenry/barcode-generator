const barcodes = document.querySelectorAll('.barcode');
barcodes.forEach(barcode => {
	barcode.addEventListener('click', () => {
		const img = barcode.querySelector('img');
		const imgSrc = img.getAttribute('src');
		const imgTitle = barcode.querySelector('.barcode__title').innerText;
		const div = document.createElement('div');
		div.classList.add('barcode__show');
		const imgEl = document.createElement('img');
		imgEl.setAttribute('src', imgSrc);
		imgEl.setAttribute('alt', '');
		imgEl.classList.add('barcode__show__img');
		const title = document.createElement('h3');
		title.classList.add('barcode__title');
		title.innerText = imgTitle;
		div.appendChild(imgEl);
		div.appendChild(title);
		document.body.appendChild(div);
		div.addEventListener('click', () => {
			document.body.removeChild(div);
		});
	});
});

document.querySelector('.barcode__generate input[type="submit"]').addEventListener('click', (e) => {
	const code = document.querySelector('.barcode__generate input[name="code"]').value;
	if (code === '') return;
	fetch(`./generate.php?code=${code}`)
		.then(res => {
			if (res.ok) {
				window.location.reload();
			} else {
				alert(res.message);
			}
		});
});