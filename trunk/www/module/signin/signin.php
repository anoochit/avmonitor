<?php 

if ((isset($_POST["signin"])) AND ($_POST["username"]!="") AND ($_POST["password"]!="") AND (($obav->getAuthen($_POST["username"],$_POST["password"]))==true)) {
 	// getinfo
	$res=$obav->getUserInfoByLogin($_POST['username']);
	// assign session
 	$_SESSION['AVID']=$res[0]->id;
 	// load dashboard
 	header("Location: ".$url."/dashboard");	
 	
 } else {
 	
 	
  	
?>
<div class="login-container">
<h1 id="login-logo"><a>One Console</a></h1>
<form name="login" id="login" method="post">
<table class="round">
<tr>
	<td colspan="2">
		<label for="username">Username</label><br>
		<input type="text" name="username" size="20" class="login-input">
	</td>
</tr>
<tr>
	<td colspan="2">
		<label for="password">Password</label><br>
		<input type="password" name="password" size="20" class="login-input">
	</td>
</tr>
<tr>
	<td>
		<p class="login">
			<a href="<?=$url; ?>/lostpassword">forgot password ?</a><br>			
		</p>
	</td>
	<td align="right">
		<input type="hidden" value="1" name="signin">
		<input type="submit" value="SignIn" class="submit">
	</td>
</tr>
</table>
</form>
</div>
<?php 
	
}

?>