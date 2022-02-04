<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Columnist;


session_start();
isSessionValid();



loadView('ad_edit_image');