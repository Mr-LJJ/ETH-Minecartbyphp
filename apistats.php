<?php
$url = 'https://www.sparkpool.com/v1/pool/stats?currency=ETH&miner=sp_ljjss';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url );
        //参数为1表示传输数据，为0表示直接输出显示。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //参数为0表示不带头文件，为1表示带头文件
        curl_setopt($ch, CURLOPT_HEADER,0);
        $outputpool = curl_exec($ch);
        $arrpool=json_decode($outputpool,true);
        foreach ($arrpool as $valuepool) {
            $arrpool2 = $valuepool;
        }
        $ETH=$arrpool2[0];
        $ETHCNY=$ETH['cny'];
        curl_close($ch);
?>
