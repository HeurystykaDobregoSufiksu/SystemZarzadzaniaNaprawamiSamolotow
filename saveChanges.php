<?php
    session_start();

    $nameOld = $_SESSION['name'];
    $surnameOld = $_SESSION['surname'];
    $emailOld = $_SESSION['email'];
    $id = $_SESSION['id'];

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];

    if($nameOld != $name | $surnameOld != $surname | $emailOld != $email){
        $flag = true;
        if($name=='' || $surname=='' || $email=='')
			{
				$flag = false;
                $_SESSION['error']='Pola nie mogą być puste';
                header("location: myProfile.php");
                exit();
			}
        if($flag){
            try{
                include_once('config.php');
				$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
                $pdo->query("SET NAMES utf8");
                $prep = $pdo->prepare("UPDATE user SET name=:name, surname=:surname, email=:email WHERE id=:id");
                $prep->execute([':email'=>$email,':name'=>$name,'surname'=>$surname,':id'=>$id]);
                $pdo=null;
                $_SESSION['info']='Dane zostały zmienione.';
                $_SESSION['name'] = $name;
                $_SESSION['surname'] = $surname;
                $_SESSION['email'] = $email;
                header("location: myProfile.php");
                exit();
            }
			catch(PDOException $e)
			{
				echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
			}
        }
    }
    else
        header('location: myProfile.php');


?>