<?php
$url = 'https://www.sparkpool.com/v1/worker/list?currency=ETH&miner=sp_ljjss';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url );
        //参数为1表示传输数据，为0表示直接输出显示。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //参数为0表示不带头文件，为1表示带头文件
        curl_setopt($ch, CURLOPT_HEADER,0);
        $outputmine = curl_exec($ch);
        $arrmine=json_decode($outputmine,true);
        foreach ($arrmine as $valuemine) {
            $arrmine2 = $valuemine;
        }
        $notebook1=$arrmine2[2];
        $notebook2=$arrmine2[0];
        $kang=$arrmine2[1];
        curl_close($ch);
        $onlineminer = 0;
        if ($kang['online']==1){
            $onlineminer ++;
            $kangonline='Yes';
        }else{$onlineminer - 1;
             $kangonline='No';
        }
        if ($notebook1['online']==1){
            $onlineminer ++;
            $notebook1online='Yes';
        }else{$onlineminer - 1;
             $notebook1online='No';
        }
        if ($notebook2['online']==1){
            $onlineminer ++;
            $notebook2online='Yes';
        }else{$onlineminer - 1;
            $notebook2online='No';
        }
        error_reporting(E_ALL^E_NOTICE);
        $conn=mysqli_connect('localhost','root','ljj12345','minecart');
        if(mysqli_connect_errno($conn)){
          die("数据库BOOM".mysqli_connect_error());
        } 
        $hashratesqlall = "SELECT * FROM (select * from hashrate order by id desc limit 7) aa ORDER BY id;";
       $queryhash = mysqli_query($conn,$hashratesqlall);
       while ($rowhash = mysqli_fetch_array($queryhash)) {
	       $hash[]=$rowhash['totalmeanhashrate'];
	       $hashtime[]=$rowhash['time'];
          }
          $hash0=round($hash[0] * 0.000001,2);$hash1=round($hash[1] * 0.000001,2);$hash2=round($hash[2] * 0.000001,2);$hash3=round($hash[3] * 0.000001,2);$hash4=round($hash[4] * 0.000001,2);$hash5=round($hash[5] * 0.000001,2);$hash6=round($hash[6] * 0.000001,2);
         $totalmh1 = $kang['meanHashrate24h']+$notebook1['meanHashrate24h']+$notebook2['meanHashrate24h'];
         $nowtotalmh1 = $kang['hashrate']+$notebook1['hashrate']+$notebook2['hashrate'];
        $hashratesql="INSERT INTO `hashrate` (`time`, `totalhashrate`, `totalmeanhashrate`) VALUES ('".date("Y-m-d")."', '".$nowtotalmh1."', '".$totalmh1."');";
        $hashupdate = "UPDATE `hashrate` SET `totalhashrate`= '".$nowtotalmh1."',`totalmeanhashrate`= '".$totalmh1."' WHERE `time` = '".date("Y-m-d")."';";
        mysqli_query($conn,$hashupdate);
        if($hashtime[6] != date("Y-m-d")){mysqli_query($conn,$hashratesql);}
        
?>
