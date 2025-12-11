<?php
if (!isset($title)) $title = 'MyApp';
?>
<!doctype html>
<html lang="vi">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title><?= htmlspecialchars($title) ?></title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css">
</head>
<body>
<div class="wrapper">
