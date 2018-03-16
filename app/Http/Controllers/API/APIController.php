<?php
namespace C2Y\Http\Controllers\API;

class APIController {
  /* Success json format */
  public static function success ($arr = []) {
    return response()->json([ 'data' => $arr ]);
  }

  /* Error json format */
  public static function error ($err, $response = 200) {
    if (is_array($err))
      return response()->json(['error' => $err ], $response);
    return response()->json(['error' => [ 'message' => $err ]], $response);
  }

  /* Verify params */
  public static function verify ($required = [], $request = [], $map = []) {
    $return = [];
    foreach ($required as $key) {
      if (!isset($request[ $key ])) {
        return null;
      }
      $val = $request[ $key ];
      unset($request[ $key ]);
      if (isset($map[ $key ])) {
        $return[ $map[ $key ] ] = $val;
        continue;
      }
      $return[ $key ] = $val;
    }
    foreach ($request as $key => $item) {
      if (isset($map[ $key ])) {
        $return[ $map[ $key ] ] = $item;
        continue;
      }
      $return[ $key ] = $item;
    }
    return $return;
  }

  public static function errorRequired ($params = []) {
    $size = count($params);
    if (!$size) {
      return self::error('');
    }
    $ret = 'Required field not found. Request must contain "'.($params[0]).'"';
    for ($i = 1; $i < $size; $i++) {
      $ret .= ($i < $size - 1 ? ', ' : ' and ').'"'.($params[$i]).'"';
    }
    return self::error($ret);
  }
}