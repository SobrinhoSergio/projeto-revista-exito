<?php

if ($AppException) {
	$message = [
	    'type' => 'error',
	    'message' => $AppException->getMessage()
	];
}

?>

<?php if ($message): ?>
        <?= $message['message'] ?>
<?php endif ?>