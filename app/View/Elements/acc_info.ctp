<?php 
$user = $this->requestAction('app/acc_info');
?>
            <div id="acc_info">
                <img src="" alt="アバター"/>
<<<<<<< HEAD
                <p>ユーザネーム: <?php echo '<br>'.$user['user_name']; ?></p><br />
                <p>名前: <?php echo $user['real_name']; ?></p><br />
=======
                <p><?php echo $user['User']['user_name']?></p><br />
                <p>ログイン時間</p><br />
                <p>勉強しているコーマ</p><br />
>>>>>>> khanhnd
                <ul>
                    <li><a href="">個人情報を変更</a></li>
                    <li><a href="">学習の歴史</a></li>
                    <li><a href="">課金情報</a></li>
                </ul>
            </div><!--End #acc_info-->