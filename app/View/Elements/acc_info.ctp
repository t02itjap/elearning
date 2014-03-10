<?php 
$user = $this->requestAction('app/acc_info');
?>
            <div id="acc_info">
                <img src="" alt="アバター"/>
                <p><?php echo $user['User']['user_name']?></p><br />
                <p>名前: <?php echo $user['User']['real_name']; ?></p><br />
                <p>勉強しているコーマ</p><br />
                <ul>
                    <li><a href="">個人情報を変更</a></li>
                    <?php 
                        switch ($user['User']['level']) {
                            case '1':
                                echo "<li><a href='#'>パスワード変更</a></li>";
                                break;

                            case '2':
                                echo "<li><a href='#'>報酬情報</a></li>";
                                echo "<li><a href='#'>パスワード変更</a></li>";
                                echo "<li><a href='#'>Verifycode変更</a></li>";
                                break;
                            
                            case '3':
                                echo "<li><a href='#'>課金情報</a></li>";
                                echo "<li><a href='#'>パスワード変更</a></li>";
                                break;

                            default:
                                # code...
                                break;
                        }
                    ?>               
                </ul>
            </div><!--End #acc_info-->