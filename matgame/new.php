<?php
session_start();
?>
<?php
function newOperator(){
    newNums(rand(1,4));
}
function newNums($op){
    if ($op == 1){
        $num1 = gen(150);
        $num2 = gen(150);
    } else if ($op == 2) {
        $num1 = gen(150);
        $num2 = gen(150);
    } else if ($op == 3) {
        $num1 = gen(20);
        $num2 = gen(20);
    } else if ($op == 4){
        $num1 = gen(250);
        $num2 = gen(250);
    }
    if ($op == 4 and $num1 % $num2 != 0 or $num1 == $num2){
        newNums(4);
    } else {
        $result = calculate($op, $num1, $num2);
        $_SESSION["result"] = $result;
        if ($op == 1){
            $op = "+";
        } else if ($op == 2){
            $op = "-";
        } else if ($op == 3){
            $op = "*";
        } else if ($op == 4){
            $op = "/";
        }
        $_SESSION["n1"] = $num1;
        $_SESSION["n2"] = $num2;
        $_SESSION["op"] = $op;
        $random = rand(1, 4);
        $priklad4 = floor($num1*rand(1,3)) . " " . $op . " ". floor($num2 / rand(2,8));
        $priklad3 = floor($num1*rand(1,2)) . " " . $op . " ". floor($num2 / rand(2,8));
        $priklad2 = floor($num1*rand(1,3)) . " " . $op . " ". floor($num2 / rand(2,8));
        $priklad = "$num1 $op $num2";
        
        $h1 = "";
        $h2 = "";
        $h3 = "";
        $h4 = "";
        switch($random){
            case '1':
                $h1 = $priklad;
                break;
            case '2':
                $h2 = $priklad;
                break;
            case '3':
                $h3 = $priklad;
                break;
            case '4':
                $h4 = $priklad;
                break;
        }
        if (isset($_SESSION["last"])){
            $last = $_SESSION["last"];
        } else {
            $last = "32 * 49";
        }
        while (strlen($priklad2) + strlen($priklad3) > strlen($priklad4) + strlen($last)){
            $priklad4 = $priklad4 . rand(0,9);
        }
        while (strlen($priklad2) + strlen($priklad3) < strlen($priklad4) + strlen($last)){
            $priklad3 = $priklad3 . rand(0,9);
        }
        $s1="L4r+m0p39md4l4r-t8m+t2c4n3+ct+t9+r8d0p*c0ng+l0t6M-r*d0ct9mf8c0l**-g9+6N9ll88cc9m38n2+l0t-t8m+tv8r0933+mp+r2n9ll8m-r*m4ll*q98m2t+mp4r393c0p0td08mn9ll8v+ll+46N9ll8+3t6P+ll+nt+3q9+pr+t09ml+ct9-dt9rp*63+dc4nv8ll*m8gn8+93+m6C9m34c0*n8t4q9+p+n8t0b93+tm8gn*d*p8rt9r0+ntm4nt+32n-c+t9rr0d0c9l93m936+t08m38p0+n+l0t2c4n3+q98t+g+t2tr*t0q9+n4n2v+n+n8t*q9*28nt+60t8q9++8r9mr+r9mh0ct+n+t9r-8p0+nt+d+l+ct9329t-tr+0c0+nd*v4l9pt8t0b93m804r+38l0-c4n3+q98t9r-tp+rf+r+nd*d4l4r0b93-p+r04r+3r+p+ll8t6P+ll+nt+3q9+38p0+n63+dc4nv8ll*m8gn8+93+m68l0q98m0dd4l4r6+t08mc4mm4d4d90+g+tw*06";
        $t1 = rand(2,6);
        $text1 = substr($s1,rand(1,520),$t1);
        $text2 = substr($s1,rand(1,520),$t1);
        $_SESSION["last"] = $priklad;
        echo "<h3 class='d-none'>$text1</h3>";
        echo "<h6 class='text-warning'>$priklad2</h6>";
        echo "<h6>$priklad3</h6>";
        echo "<h1>$h1</h1>";
        echo "<h5>$h2</h5>";
        echo "<h3>$h3</h3>";
        echo "<h5>$h4</h5>";
        echo "<h6>$priklad4</h6>";
        echo "<h6 class='text-warning'>$last</h6>";
        echo "<h1 class='d-none'>$text2</h1>";
    }
    
}
if (!isset($_SESSION["MatGameInRowWrong"]) or !isset($_SESSION["MatGameInRowCorrect"])){
    $_SESSION["MatGameInRowWrong"] = 0;
    $_SESSION["MatGameInRowCorrect"] = 0;
}

function gen($max){
    return rand(3, $max);
}
function calculate($operator, $num1, $num2){
    switch($operator){
        case '1':
            $p = $num1 + $num2;
            break;
        case '2':
            $p = $num1 - $num2;
            break;
        case '3':
            $p = $num1 * $num2;
            break;
        case '4':
            $p = $num1 / $num2;
            break;
    }
    return $p;
}
newOperator();
?>