<?php
    // START SESSIONS 
    session_start();

    // DESTROYING SESSIONS
	unset($_SESSION['SESS_TYPE']);
	unset($_SESSION['SESS_MEMBER_ID']);
    unset($_SESSION['SESS_COMPANY_ID']);
    unset($_SESSION['SESS_ADMIN_ID']);

    session_destroy();
?>
