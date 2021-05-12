<?php
$url = 'https://www.sparkpool.com/v1/bill/stats?currency=ETH&miner=sp_ljjss';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url );
        //参数为1表示传输数据，为0表示直接输出显示。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //参数为0表示不带头文件，为1表示带头文件
        curl_setopt($ch, CURLOPT_HEADER,0);
        $outputbill = curl_exec($ch);
        $arrbill=json_decode($outputbill,true);
        foreach ($arrbill as $valuebill) {
            $arrbill2 = $valuebill;
        }
        error_reporting(E_ALL^E_NOTICE);
        $conn=mysqli_connect('localhost','root','ljj12345','minecart');
        if(mysqli_connect_errno($conn)){
          die("数据库BOOM".mysqli_connect_error());
        } 
        $bill=array();
          $querybill = mysqli_query($conn,"SELECT * FROM (select * from billhistory order by id desc limit 7) aa ORDER BY id;");
          while ($rowbill = mysqli_fetch_array($querybill)) {
	        $billhistorytime=$rowbill['time'];
	       $bill[]=$rowbill['totalbalance'];
	       $billtime[]=$rowbill['time'];
          }
              $billeth1 = $bill[0];
              $billeth2 = $bill[1];
              $billeth3 = $bill[2];
              $billeth4 = $bill[3];
              $billeth5 = $bill[4];
              $billeth6 = $bill[5];
              $billeth7 = $bill[6];
              echo $bill1;
        $sql="INSERT INTO `billhistory` (`time`, `totalbalance`, `total1day`) VALUES ('".date("Y-m-d")."', '" . $arrbill2['balance'] . "','" . $arrbill2['pay1day'] . "');";
        $billupdate = "UPDATE `billhistory` SET `totalbalance`= '".$arrbill2['balance']."',`total1day`= '".$arrbill2['pay1day']."' WHERE `time` = '".date("Y-m-d")."';";
        mysqli_query($conn,$billupdate);
        if($billhistorytime != date("Y-m-d")){mysqli_query($conn,$sql);}
        curl_close($ch);
?>
