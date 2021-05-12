<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>矿车管理页面</title>
		<script src="../js/sweetalert2.all.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<link href="../css/index.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div class="wrapper">
    		<div id="web_bg" style="background-image: url(./img/bg/01.jpg);"></div>
		</div>
		<div class="class1">
			<div class="logo1">
				<h3 id="font1">Minecart </h3>
				<div class="title">
					<h2 id ="font2">登录</h2>
				</div>
			</div>
		<form action="index.php" method="post" name="formlogin">
			<div class="loginInput">
				<div class="centered">
					<div class="group">
<?php
error_reporting(E_ALL^E_NOTICE);
$conn=mysqli_connect('localhost','root','ljj12345','minecart');
if(mysqli_connect_errno($conn)){
  die("数据库BOOM".mysqli_connect_error());
}
$userinput='<input type="text" id="name" required="required" name="user"/>
					    <label for="name" class="username">用户名</label>';
$passinput='<input type="password" id="pass" required="required" name="pass"/>
									<label for="pass" class="password">密码</label>';
if ($_POST['user']!=null) {
	$userinput=null;
	echo $passinput;

}else{
	$passinput=null;
	echo $userinput;
}
?>
					    <div class="bar"></div>
					</div>
				</div>
			</div>
			<div class="register">
				<p style="font-family: Microsoft YaHei;font-size: 13px">没有帐户?<a href="javascript:Swal.fire({  type: 'info',  title: '暂未对外开放',  text: '请联系管理员!'})" style="font-family: Microsoft YaHei; color: #2196f3; font-size: 13px; text-decoration:none; ">创建一个!</a><a href="javascript:Swal.fire({  type: 'info',  title: '错误',  text: '请联系管理员重置密码!'})" style="font-family: Microsoft YaHei; color: #2196f3; font-size: 13px; text-decoration:none; position: absolute; right: 3.5em;">忘记密码?</a></p>
			</div>
			<div class="buttenposition">
			<button class="button" style="vertical-align:middle; font-size: 15px; font-family: Microsoft YaHei;" onclick="queryInfos()"><span>下一步</span></button>
			</div>
			</form>
<?php
$externalContent = file_get_contents('http://checkip.dyndns.com/');
preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
$externalIp = $m[1];
$sql="SELECT * FROM logincache;";
$query=mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array($query)) {
	$cacheuser=$row['user1'];
}
if ($cacheuser!=null) {
  $sql2="SELECT `username` FROM user WHERE username = '".$cacheuser."';";
  $query2=mysqli_query($conn,$sql2);
	while ($row2 = mysqli_fetch_array($query2)) {
  $sqluser=$row2['username'];
	}
	$sql3="SELECT `password` FROM user WHERE username = '".$cacheuser."';";
	$query3=mysqli_query($conn,$sql3);
	while ($row3 = mysqli_fetch_array($query3)) {
		$userpass=$row3['password'];
	}
	if ($userpass!=null) {
		if ($sqluser==$cacheuser and $userpass==$_POST['pass']) {
			$sqlip="UPDATE user SET ip = '".$externalIp."' WHERE username = '".$cacheuser."';";
			mysqli_query($conn,$sqlip);
			$today=date("Y/m/d");
			$sqldate="UPDATE user SET lastlogin = '".$today."' WHERE username = '".$cacheuser."';";
			mysqli_query($conn,$sqldate);
			setcookie('user',$cacheuser,time()+3600*2);
			echo "<script>Swal.fire({  type: 'success',  title: '登录成功!',  text: '欢迎回来 ".$cacheuser."' , showConfirmButton:false});setInterval('myInterval()',2000);function myInterval(){window.location.href='https://minecart.ljjserver.cn/dashboard/index/dashboard.php';}</script><meta http-equiv='Refresh' content='0; url=https://www.baidu.com>";
		}else{
		echo "<script>Swal.fire({  type: 'error',  title: '登录失败!',  text: '用户名或密码错误' ,timer: 1500 })</script><meta http-equiv='Refresh' content='2'; url=https://http://minecart.ljjserver.cn/>";
		}
	}else{
		echo "<script>Swal.fire({  type: 'error',  title: '登录失败!',  text: '验证错误',timer: 1500})</script><meta http-equiv='Refresh' content='2'; url=https://http://minecart.ljjserver.cn/>";
	}
}else{
	if ($_POST['user']!=null) {
		if ($userinput!=null) {
					echo "<script>Swal.fire({  type: 'error',  title: '数据已过期!',  text: ''})</script>";
		}
	}
}
$sqlcommand1="UPDATE logincache SET user1 = '".$_POST['user']."' WHERE userid = '1';";
mysqli_query($conn,$sqlcommand1);
?>
		</div>
		<div class="footer">
			<center><p id="footerword">Copyright &copy2021 LJJ Studios All rights reserved &nbsp&nbsp&nbsp&nbsp<a href="https://beian.miit.gov.cn/" target="_blank">粤ICP备20029412-2</a></p></center>
		</div>
	</body>
</html>
