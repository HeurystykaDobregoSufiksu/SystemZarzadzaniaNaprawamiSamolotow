<?php
$id_report = $_GET['reportId'];
$numpage = $_GET['numpage'];

try
			{
					include_once('config.php');
					$pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset.'', $user, $password);
					$pdo->query("SET NAMES utf8");
                    $prep = $pdo->prepare("UPDATE report SET numpage=:numpage WHERE id=:id");
					$prep->execute([':numpage'=>$numpage,':id'=>$id_report]);
                    $pdo = null;
                    exit();
			}
			catch(PDOException $e)
			{
				echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
			}

?>