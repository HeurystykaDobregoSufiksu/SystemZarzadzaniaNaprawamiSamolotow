<?php
		  session_start();
			$flag=true;
            $email = $_SESSION['email'];
			$passOld = $_POST['passOld'];
			$pass1 = $_POST['pass1'];
			$pass2 = $_POST['pass2'];
      if($passOld=='' || $pass1=='' || $pass2=='')
			{
				$flag=false;
        $_SESSION['error']='Pola nie mogą być puste';
        header("location: myProfile.php");
        exit();
			}
			if(strlen($pass1)<=8 && strlen($pass1)>=50)
			{
				$flag=false;
        $_SESSION['error']='Niepoprawne hasło formatem.';
        header("location: myProfile.php");
        exit();
			}
			if($pass1!=$pass2)
			{
				$flag=false;
        $_SESSION['error']='Hasła nie są takie same';
        header("location: myProfile.php");
        exit();
			}
if($flag){
			try
			{
					include_once('config.php');
					$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
					$pdo->query("SET NAMES utf8");
                    $prep = $pdo->prepare("SELECT password FROM user WHERE email=:email");
					$prep->execute([':email'=>$email]);
					$passBase=$prep->fetchColumn();
                    $salt = substr($passBase,7,22);

					$options = [
									'cost' => 11,
									'salt' => $salt,
								];
					$hashPassword = password_hash($passOld, PASSWORD_BCRYPT, $options);
					$prep = $pdo->prepare("SELECT id FROM user WHERE email=:email AND password=:passwd");
					$prep->execute([':email'=>$email,':passwd'=>$hashPassword]);
                    $exists=$prep->fetchAll();
//********************************************************************************************************************************
                    if($exists[0]['id'] != 0){
                        // update password here!
                    $options = [
									'cost' => 11,
									'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
								];
					$hashPassword = password_hash($pass1, PASSWORD_BCRYPT, $options);
					$prep = $pdo->prepare("UPDATE user SET password=:passwd WHERE email=:email");
					$prep->execute([':email'=>$email,':passwd'=>$hashPassword]);
                    $pdo=null;
					$_SESSION['info-log']='Hasło zostało zmienione, zaloguj się ponownie.';
                    header("location: index.php");
					exit();
                    }
//********************************************************************************************************************************
                    else{
                        $_SESSION['error']='Stare hasło nieprawidłowe';
                        header("location: myProfile.php");
                        exit();
                    }

			}
			catch(PDOException $e)
			{
				echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
			}
}
else
    header("location: myProfile.php");
?>