<?php
ini_set('display_errors', 'Off');
    class Converter
    {
        private static function _Lower()
        {
            return array(
                'q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m', 'ё','й','ц','у','к','е','н','г','ш','щ','з','х','ъ','ф','ы','в','а','п','р','о','л','д','ж','э','я','ч','с','м','и','т','ь','б','ю');  
        }
        
        private static function _Upper()
        {
            return array(
                'Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M', 'Ё','Й','Ц','У','К','Е','Н','Г','Ш','Щ','З','Х','Ъ','Ф','Ы','В','А','П','Р','О','Л','Д','Ж','Э','Я','Ч','С','М','И','Т','Ь','Б','Ю');
        }
        
        public static function ToUpper($string)
        {
            return str_replace(self::_Lower(), self::_Upper(), $string);   
        }
        
        public static function ToLower($string)
        {
            return str_replace(self::_Upper(), self::_Lower(), $string);   
        }
    }
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING); 
    $type = $_POST['type'];
    if ($username != '') {
        $mysql = new mysqli('localhost', 'root', '', 'register-bd');
        if ($type == '1') {
            $result = $mysql->query("SELECT * FROM `users`");
            $users = $result->fetch_all();
            $count = 0;
            foreach ($users as $user) {
                if ((!is_bool(strpos(Converter::ToLower($user[3]), Converter::ToLower($username))) || Converter::ToLower($user[0]) == Converter::ToLower($username)) && $user[8] == 0) {
                    $count++;
                    echo '
                    <a href="userpage.php?id=' . $user[0] . '" style="-webkit-tap-highlight-color: transparent;">
                    <div class="user">
                        <ul>
                            <li>
                                <img src="' . $user[4] . '?<?php echo time();?>" width="100" height="100" class="user-image">
                            </li>
                            <li>
                                <p class="user-name"><b>' . $user[3] . '</b></p>
                            </li>';
                    echo '
                        </ul>
                    </div>
                    </a>';
                }
            }
            if ($count == 0) {
                echo '
                <p style="text-align: center; font-size: 1.2em;">К сожалению, по вашему запросу ничего не найдено.</p>
                ';
            }
        } else {
            $result = $mysql->query("SELECT * FROM `communities`");
            $users = $result->fetch_all();
            $count = 0;
            foreach ($users as $user) {
                if (!is_bool(strpos(Converter::ToLower($user[1]), Converter::ToLower($username))) || Converter::ToLower($user[0]) == Converter::ToLower($username)) {
                    $count++;
                    echo '
                    <a href="community.php?id=' . $user[0] . '" style="-webkit-tap-highlight-color: transparent;">
                    <div class="user">
                        <ul>
                            <li>
                                <img src="' . $user[3] . '" width="100" height="100" class="user-image">
                            </li>
                            <li>
                                <p class="user-name"><b>' . $user[1] . '</b></p>
                            </li>';
                    if ($user[9] == 1 || $user[8] == 1) {
                        echo '
                            <li>
                                <ion-icon name="checkmark-circle" class="check-mark"></ion-icon>
                            </li>';
                    }
                    echo '
                        </ul>
                    </div>
                    </a>';
                }
            }
            if ($count == 0) {
                echo '
                <p style="text-align: center; font-size: 1.2em;">К сожалению, по вашему запросу ничего не найдено.</p>
                ';
            }
        }
        $mysql->close();
    } else {
        if ($type == '1') {
            echo '
            <div style="text-align: center; margin-top: 10vh;">
                <img src="images/user.jpg" style="border-radius: 40px 40px 40px 40px;" width="100">
                <div class="title">
                    <img src="images/lavkalogo.png" width="158" height="28">
                </div>
            </div>
            ';
        } else {
            $mysql = new mysqli('localhost', 'root', '', 'register-bd');
            $result = $mysql->query("SELECT * FROM `communities`");
            $users = $result->fetch_all();
            $count = 0;
            foreach ($users as $user) {
                $count++;
                echo '
                <a href="community.php?id=' . $user[0] . '" style="-webkit-tap-highlight-color: transparent;">
                <div class="user">
                    <ul>
                        <li>
                            <img src="' . $user[3] . '" width="100" height="100" class="user-image">
                        </li>
                        <li>
                            <p class="user-name"><b>' . $user[1] . '</b></p>
                        </li>';
                if ($user[9] == 1 || $user[8] == 1) {
                    echo '
                        <li>
                            <ion-icon name="checkmark-circle" class="check-mark"></ion-icon>
                        </li>';
                }
                echo '
                    </ul>
                </div>
                </a>';
            }
            if ($count == 0) {
                echo '
                <p style="text-align: center; font-size: 1.2em;">К сожалению, сообществ не найдено.</p>
                ';
            }
            $mysql->close();
        }
    }
?>