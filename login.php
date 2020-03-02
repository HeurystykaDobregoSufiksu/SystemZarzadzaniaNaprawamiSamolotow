<?php
		session_start();
			$flag=true;
			$email = $_POST['email'];
			$pass1 = $_POST['pass1'];
      if($email=='' || $pass1=='')
			{
				$flag=false;
			}
			if(strlen($pass1)<=8 && strlen($pass1)>=50)
			{
				$flag=false;
			}
			try
			{
                include_once('config.php');
					$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
					$pdo->query("SET NAMES utf8");
					$prep = $pdo->prepare("SELECT count(*) FROM user WHERE email=:email");
					$prep->execute([':email'=>$email]);
					$emailCount=(int)$prep->fetchColumn();
					if($emailCount != 0)
                    {
                    $prep = $pdo->prepare("SELECT password FROM user WHERE email=:email");
					$prep->execute([':email'=>$email]);
					$passBase=$prep->fetchColumn();
                        $salt = substr($passBase,7,22);
                    }
                    else{
                        $flag = false;
                    $_SESSION['error'] = 'takie konto nie istnieje';
                    header("location: index.php");
                    }
					if($flag)
					{
					$options = [
									'cost' => 11,
									'salt' => $salt,
								];
					$hashPassword = password_hash($pass1, PASSWORD_BCRYPT, $options);
					$prep = $pdo->prepare("SELECT id,name,surname,status FROM user WHERE email=:email AND password=:passwd");
					$prep->execute([':email'=>$email,':passwd'=>$hashPassword]);
                    $exists=$prep->fetchAll();
                    if($exists[0]['id'] != 0){
                        $exists = $exists[0];
                        $_SESSION['id'] = $exists['id'];
                        $_SESSION['name'] = $exists['name'];
                        $_SESSION['surname'] = $exists['surname'];
                        $_SESSION['email'] = $email;
                        $_SESSION['status'] = $exists['status'];
                        header("location: index.php");
                        exit();
                    }
                    else{
                        $_SESSION['error']='Hasło nieprawidłowe';
                        header("location: index.php");
                        exit();
                    }
        }
			}
			catch(PDOException $e)
			{
				echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
			}

?>