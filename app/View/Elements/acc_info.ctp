<?php 
$user = $this->requestAction('app/acc_info');
?>
            <div id="acc_info">
                <img src="" alt="アバター"/>
                <p><?php echo $user['User']['user_name']?></p><br />
                <p>ログイン時間</p><br />
                <p>勉強しているコーマ</p><br />
                <ul>
                    <li><a href="">個人情報を変更</a></li>
                    <li><a href="">学習の歴史</a></li>
                    <li><a href="">課金情報</a></li>
                </ul>
            </div><!--End #acc_info-->