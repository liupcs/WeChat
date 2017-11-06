<?php










//===== 点击菜单拉取消息时的事件推送？？？？？？？？ ============
    public function tuiMsg()
    {
        //get post data, May be due to the different environments
        if (PHP_VERSION >= 7) {
            $postStr = file_get_contents('php://input');
        } else {
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        }

        file_put_contents('999.txt', $postStr);
        //extract post data
        if (!empty($postStr)){

                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
                            <ToUserName><![CDATA[toUser]]></ToUserName>
                            <FromUserName><![CDATA[FromUser]]></FromUserName>
                            <CreateTime>123456789</CreateTime>
                            <MsgType><![CDATA[event]]></MsgType>
                            <Event><![CDATA[CLICK]]></Event>
                            <EventKey><![CDATA[EVENTKEY]]></EventKey>
                            </xml>";             
                if($postObj->MsgType == 'event')
                {
                    if ($postObj->Event == 'CLICK') {
                       if ($postObj->EventKey == 'V1001_TODAY_MUSIC') {
                            $contentStr = "推事件";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                       }
                    }
                }
        } else {
            echo "success";
            exit;
        }
    }

// ==================  结束   ==============

















/*// 1.将timestamp， nonce，token按字典序排序
	$timestamp 	= $_GET['timestamp'];
	$nonce 		= $_GET['nonce']; 	// 随机参数（子串）
	$token 		= 'weixin';  		// 微信中填写的 token
	$signature 	= $_GET['signature'];// 微信公众平台已经加密好的一个子串
	$array		= array( $timestamp, $nonce, $token); // 将三个参数放在一个数组中
	sort( $array );  // 按字典序排序
// 将排序后的三个参数拼接之后用sha1加密
	$tmpstr = implode('', $array); // join 将数组拼接成字串
	$tmpstr = sha1( $tmpstr );
// 将加密后的字符串与signature进行对比，判断请求是否来至微信 
	if ($tmpstr == $signature) {
		echo $_GET['echostr'];  // 从微信服务器传过来的参数
		exit;
	}*/