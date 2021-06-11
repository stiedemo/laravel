<?php


/**
 * get_free_disk_root
 *
 * @param  mixed $class
 * @return sprintf
 */
function get_free_disk_root($class = 3)
{
    $bytes = disk_free_space(".");
    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    $base = 1024;
    return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
}

/**
 * get_total_disk_root
 *
 * @param  mixed $class
 * @return sprintf
 */
function get_total_disk_root($class = 3)
{
    $bytes = disk_total_space(".");
    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    $base = 1024;
    return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
}

/**
 * api_resualt_common
 *
 * @param  mixed $data
 * @return collect
 */
function api_resualt_common($data)
{
    return collect([
        'status' => true,
        'result' => collect($data)
    ]);
}

/**
 * api_errors_common
 *
 * @param  mixed $msg
 * @param  mixed $data
 * @return collect
 */
function api_errors_common($msg, $data)
{
    return collect([
        'status' => false,
        'msg' => $msg,
        'errors' => collect($data)
    ]);
}

?>
