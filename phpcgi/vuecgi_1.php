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
//header('Access-Control-Allow-Headers:Authorization');
// 响应类型  
header("Access-Control-Allow-Methods: GET, POST, DELETE");  
// 允许跨域请求带cookie
header("Access-Control-Allow-Credentials: true");
// 响应头设置  
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Cache-Control,Authorization");







// 在每个涉及到的业务cgi中利用 header头authorization 进行验证，验证通过，才允许执行业务逻辑代码
function GetAllHeader()
{
	// 忽略获取的header数据。这个函数后面会用到。主要是起过滤作用
	$ignore = array('host','accept','content-length','content-type'); 
	$headers = array();
	//这里大家有兴趣的话，可以打印一下。会出来很多的header头信息。咱们想要的部分，都是‘http_'开头的。所以下面会进行过滤输出。
	/*var_dump($_SERVER);
	exit;*/

	foreach($_SERVER as $key=>$value){
		if(substr($key, 0, 5)==='HTTP_'){
			//这里取到的都是'http_'开头的数据。
			//前去开头的前5位
			$key = substr($key, 5);
			//把$key中的'_'下划线都替换为空字符串
			$key = str_replace('_', ' ', $key);
			//再把$key中的空字符串替换成‘-’
			$key = str_replace(' ', '-', $key);
			//把$key中的所有字符转换为小写
			$key = strtolower($key);

			//这里主要是过滤上面写的$ignore数组中的数据
			if(!in_array($key, $ignore)){
				$headers[$key] = $value;
			}
		}
	}
	//输出获取到的header
	return $headers;
}  
	  
$headers = GetAllHeader();

if(isset($headers['authorization']) && !empty($headers['authorization']))
{

	//获取java后台的redis 的authorization值进行比较,这里简写 123456
	if($headers['authorization'] == '123456')
	{
		//验证成功
		$res = logicCode();
		exit(json_encode(array('msg'=>'auth success','code'=>200,'data'=>$res)));
	}else
	{
		exit(json_encode(array('msg'=>'auth fail','code'=>500,'data'=>'')));
	}
}









function logicCode()
{
		
	//模拟制作假数据
	$arr = array();
	for($i = 0;$i<263; $i++)
	{
		$arr[$i]['id'] = $i +1 ;
		$arr[$i]['date'] = '2016-05-04';
		$arr[$i]['name'] = '张炳';
		$arr[$i]['address'] = '上海市普陀区金沙江路 1517 号';
	}



	$currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;
	$pageSize = isset($_POST['pageSize']) ? $_POST['pageSize'] : 10;

	$totalCount = count($arr);
	$largePage = ceil($totalCount/$pageSize);
	if($currentPage > $largePage) $currentPage = $largePage;

	$data = [];
	$start = ($currentPage - 1) * $pageSize;
	$end = $currentPage* $pageSize > $totalCount ? $totalCount : $currentPage* $pageSize;
	for($i=$start; $i<$end;$i++){
		$data[] = $arr[$i];
	}


	$res = array(
		'totalCount'=>$totalCount,
		'data' => $data,
		'currentPage' => (int)$currentPage,
		'pageSize' => (int)$pageSize
	);
	return $res;
}





