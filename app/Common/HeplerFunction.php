<?php


/**
 * get_id_from_request
 *
 * @param  mixed $request
 * @return void
 */
function get_id_from_request($request)
{
    if($request->has('id')){
        if(isset($request->id)) {
            return $request->id;
        }
        return $request->get('id');
    }
    foreach ($request->route()->parameters as $parameter) {
        if(is_numeric($parameter)) {
            return $parameter;
        }
    }
    return $request['id'];
}

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
