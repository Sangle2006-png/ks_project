<?php
include_once '../admin/session.php'; // chỉnh đường dẫn nếu cần

Session::init();
Session::destroy();

header("Location: index.php");
exit();
