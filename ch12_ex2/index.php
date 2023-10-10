<?php
$lifetime = 60 * 60 * 24 * 365;    // 1 years in seconds
session_set_cookie_params($lifetime, '/');
session_start();

$task_list = array();

if (isset($_SESSION['task_list'])) {
    $task_list = $_SESSION['task_list'];
}

$action = filter_input(INPUT_POST, 'action');
$errors = array();

switch( $action ) {
    case 'add':
        $new_task = filter_input(INPUT_POST, 'newtask');
        if (empty($new_task)) {
            $errors[] = 'The new task cannot be empty.';
        } else {
            $task_list[] = $new_task;
            $_SESSION['task_list'] = $task_list;
        }
        break;
    case 'delete':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be deleted.';
        } else {
            unset($task_list[$task_index]);
            $task_list = array_values($task_list);
            $_SESSION['task_list'] = $task_list;
        }
        break;
}

include('task_list.php');
?>