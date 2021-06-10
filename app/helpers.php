<?php

if(! function_exists("error_json")){
	function error_json($msg, $data = NULL, $type = "error"){
		if(is_object($msg) && method_exists($msg, 'getMessage')){
			return response()->json(["type"=>$type, "data"=>$data, "msg"=>$msg->getMessage()], 200);
		}elseif(is_string($msg)){
			return response()->json(["type"=>$type, "data"=>$data, "msg"=>$msg], 200);
		}else{
			return response()->json(["type"=>$type, "data"=>$data, "msg"=>"Unexpected error occured! Try Again"], 200);
		}
	}
}

if(! function_exists("error_json_500")){
	function error_json_500($msg, $data = NULL, $type = "error"){
		if(is_object($msg) && method_exists($msg, 'getMessage')){
			return response()->json(["type"=>$type, "data"=>$data, "msg"=>$msg->getMessage()], 500);
		}elseif(is_string($msg)){
			return response()->json(["type"=>$type, "data"=>$data, "msg"=>$msg], 500);
		}else{
			return response()->json(["type"=>$type, "data"=>$data, "msg"=>"Unexpected error occured! Try Again"], 500);
		}
	}
}

if(! function_exists("array_walk_recursive_array")){
	function array_walk_recursive_array(array &$array, callable $callback) {
		foreach ($array as $k => &$v) {
			if (is_array($v)) {
				$callback($v, $k, $array);
				array_walk_recursive_array($v, $callback);
			} else {
				$callback($v, $k, $array);
			}
		}
	}
}

if(! function_exists("success_json")){
	function success_json($data, $msg = NULL, $type = "success"){
		return response()->json(["type"=>$type, "data"=>$data, "msg"=>$msg], 200);
	}
}
