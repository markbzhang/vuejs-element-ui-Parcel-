<?php

// 指定允许其他域名访问  
$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';  
  
$allow_origin = array(  
    'http://localhost:1234',
	'http://cms.cjwsc.com'
);  

if(in_array($origin, $allow_origin)){  
    header('Access-Control-Allow-Origin:'.$origin);       
}



// 响应类型  
header("Access-Control-Allow-Methods: GET, POST, DELETE");  
// 允许跨域请求带cookie
header("Access-Control-Allow-Credentials: true");
// 响应头设置  
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Cache-Control,Authorization");


//获取java后台的redis 的authorization值进行比较,这里简写 123456
if($_POST['Authorization'] == '123456')
{
	exit(json_encode(array('msg'=>'auth success','code'=>200)));
}else{
	exit(json_encode(array('msg'=>'auth fail','code'=>500)));
}




