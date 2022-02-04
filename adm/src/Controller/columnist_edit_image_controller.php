<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Columnist;


session_start();
isSessionValid();



loadView('columnist_edit_image');