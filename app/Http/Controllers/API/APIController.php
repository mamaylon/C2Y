<?php
namespace C2Y\Http\Controllers\API;

class APIController {
  public static function success ($arr = []) {
    return response()->json([ 'data' => $arr ]);
  }
  public static function error ($err, $response = 200) {
    if (is_array($err))
      return response()->json(['error' => $err ], $response);
    return response()->json(['error' => [ 'message' => $err ]], $response);
  }
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
}