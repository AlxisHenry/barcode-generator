<?php
const PER_PAGE = 8;

$barcodes = glob(__DIR__ . '/barcodes/*.png');
$barcodesCount = count($barcodes);
$page = (isset($_GET['page']) ? $_GET['page'] : 1) ?? 1;
$pagesCount = ceil(count($barcodes) / PER_PAGE);
$offset = ($page - 1) * PER_PAGE;
$barcodes = array_slice($barcodes, $offset, PER_PAGE);

function pagination(int $page, int $pagesCount): string {
	$div = '<div class="pagination"><div>';
	if ($page > 1) $div .= '<a href="?page=' . ($page - 1) . '">Previous</a>';
	$div .= '</div><div>';

	// For the paginator don't show more than 5 pages and show the current page in the middle,
	// But if the current page is less than 3, show the first 5 pages and if the current page is
	// more than the last 3 pages, show the last 5 pages.
	$min = $page - 2 > 0 ? $page - 2 : 1;
	$max = $page + 2 <= $pagesCount ? $page + 2 : $pagesCount;
	if ($page < 3 && $pagesCount > 5) {
		$min = 1;
		$max = 5;
	}
	if ($page > $pagesCount - 2 && $pagesCount > 5) {
		$min = $pagesCount - 4;
		$max = $pagesCount;
	}
	
	for ($i = $min; $i <= $max; $i++) {
		$class = $i === $page ? 'active' : '';
		$href = $i === $page ? '' : 'href="?page=' . $i . '"';
		$div .= "<a class='$class' $href>$i</a>";
	}

	
	$div .= '</div><div>';
	if ($page < $pagesCount) $div .= '<a href="?page=' . ($page + 1) . '">Next</a>';
	$div .= '</div></div>';
	return $div;
}

function show(string $barcode): string {
	$src = str_replace(__DIR__, '', $barcode);
	$title = explode('.',  basename($barcode))[0];
	return "<div class='barcode'>
		<img src='./$src' alt=''>
		<h3 class='barcode__title'>$title</h3>
	</div>";
}

function isEmpty(array $barcodes): string {
	return count($barcodes) === 0 ? "<span>No barcodes found...</span>" : "";
}

function moreThanOnePage(int $barcodesCount, int $page, int $pagesCount): string {
	return $barcodesCount > PER_PAGE ? "<h3 class='page__count'>Page $page of $pagesCount</h3>" : '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Barcode Generator</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Barcodes</h1>
		<div class="barcode__generate">
			<label for="code">Generate barcode</label>
			<input type="text" id="code" name="code" placeholder="Code">
			<input type="submit" value="Generate">
		</div>
		<?= isEmpty($barcodes); ?>
		<?= moreThanOnePage($barcodesCount, $page, $pagesCount); ?>
		<?= pagination($page, $pagesCount); ?>
		<div class="barcodes">
			<?php foreach ($barcodes as $barcode) { ?>
				<?= show($barcode); ?>
			<?php } ?>
		</div>
		<?= pagination($page, $pagesCount); ?>
	</div>
	<script src="app.js"></script>
</body>
</html>	