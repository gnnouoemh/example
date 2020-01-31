<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon_2.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        // 안드로이드 코드의 postParameters 변수에 적어준 이름을 가지고 값을 전달 받습니다.

        $name=$_POST['name'];
        $id=$_POST['id'];
        $password=$_POST['password'];
        $age=$_POST['age'];

        if(empty($name)){
            $errMSG = "이름을 입력하세요.";
        }
        else if(empty($id)){
            $errMSG = "아이디를 입력하세요.";
        }
        else if(empty($password)){
            $errMSG = "패스워드를 입력하세요.";
        }
       else if(empty($age)){
            $errMSG = "나이를 입력하세요.";
        }

        if(!isset($errMSG)) // 이름과 아이디 패스워드 나이 모두 입력이 되었다면 
        {
            try{
                // SQL문을 실행하여 데이터를 MySQL 서버의 person 테이블에 저장합니다. 
                $stmt = $con->prepare('INSERT INTO login(name, id, password, age) VALUES(:name, :id, :password, :age)');
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':age', $age);

                if($stmt->execute())
                {
                    $successMSG = "회원가입이 완료 되었습니다.";
                }
                else
                {
                    $errMSG = "회원가입 오류";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
            }
        }

    }

?>


<?php 
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;

	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
   
    if( !$android )
    {
?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST">
                Name: <input type = "text" name = "name" /><br>
                ID: <input type = "text" name = "id" /><br>
                Password: <input type = "password" name = "password" /><br>
                Age: <input type = "text" name = "age" /><br>
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>