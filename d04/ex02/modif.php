<?php

function is_valid($tab, $user) {
	$number = 0;
	foreach ($tab as $cur) {
		if ($user['login'] == $cur['login'] && $user['passwd'] === $cur['passwd'] && $user['newpasswd'] != $cur['passwd'])
			return ($number);
		$number++;
	}
	return (-1);
}
if ($_POST['submit'] == 'OK' && $_POST['login'] && $_POST['oldpw'] && $_POST['newpw']) 
{
    $user[] = ['login' => $_POST['login'],'passwd' => hash('sha256',$_POST['oldpw']) ,'newpasswd' =>  hash('sha256', $_POST['newpw'])];
    if (strlen($_POST['newpw']) < 6)
            {
                echo "ERROR\n";
                exit;
            }
     if ($str = file_get_contents("../private/passwd")) 
     {
		 $tab = unserialize($str);
         if (($num = is_valid($tab, $user[0])) >= 0) 
         {
			 $tab[$num]['passwd'] = $user[2];
			 if (file_put_contents("../private/passwd", serialize($tab)))
				 echo "OK\n";
			 else
				 echo "ERROR\n";
		 }
		 else
			 echo "ERROR\n";
	 }
	 else
		 echo "ERROR\n";
}
else
	echo "ERROR\n";
?>