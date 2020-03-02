<?php
		  session_start();
			$flag=true;
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$email = $_POST['email'];
			$pass1 = $_POST['pass1'];
			$pass2 = $_POST['pass2'];
      if($name=='' || $surname=='' || $email=='' || $pass1=='' || $pass2=='')
			{
				$flag=false;
        $_SESSION['error']='Pola nie mogą być puste';
        header("location: index.php");
        exit();
			}
			if(strlen($pass1)<=8 && strlen($pass1)>=50)
			{
				$flag=false;
        $_SESSION['error']='Niepoprawne hasło';
        header("location: index.php");
        exit();
			}
			if($pass1!=$pass2)
			{
				$flag=false;
        $_SESSION['error']='Hasła nie są takie same';
        header("location: index.php");
        exit();
			}
			try
			{
					include_once('config.php');
					$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
					$pdo->query("SET NAMES utf8");
					$prep = $pdo->prepare("SELECT count(*) FROM user WHERE email=:email");
					$prep->execute([':email'=>$email]);
					$emailCount=(int)$prep->fetchColumn();
					if($emailCount!=0)
					{
						$flag=false;
            $_SESSION['error']='Takie konto już istnieje';
            header("location: index.php");
					}
					if($flag)
					{
					$options = [
									'cost' => 11,
									'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
								];
					$hashPassword = password_hash($pass1, PASSWORD_BCRYPT, $options);
					$prep = $pdo->prepare("INSERT INTO user(name,surname,email,password) VALUES(:name,:surname,:email,:passwd)");
					$prep->execute([':name'=>$name,':surname'=>$surname,':email'=>$email,':passwd'=>$hashPassword]);
          $pdo=null;
					$_SESSION['info']='Konto zostalo poprawnie utworzone';
          header("location: index.php");
					exit();
        }
			}
			catch(PDOException $e)
			{
        $_SESSION['error']='Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
        header("location: index.php");
        exit();
			}

?>
