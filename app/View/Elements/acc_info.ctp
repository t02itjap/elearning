<?php 
$user = $this->requestAction('app/acc_info');
?>
            <div id="acc_info">
                <img src="" alt="アバター"/>
                <p><?php echo $user['User']['user_name']?></p><br />
                <p>名前: <?php echo $user['User']['real_name']; ?></p><br />
                <ul>
                    <?php 
                        switch ($user['User']['level']) {
                            case '1':
                            	echo "<li>";
                                echo $this->Html->link('個人情報を変更',array('controller'=>'Admins','action'=>'change_info'));
                                echo"</li>";
                                echo "<li>";
                                echo $this->Html->link('パスワード変更',array('controller'=>'Admins','action'=>'changePass'));
                                echo"</li>";
                                break;

                            case '2':
                            	echo "<li>";
                                echo $this->Html->link('個人情報を変更',array('controller'=>'Teachers','action'=>'change_info'));
                                echo"</li>";
                               	echo "<li>";
                                echo $this->Html->link('報酬情報',array('controller'=>'Teachers','action'=>'getSalary'));
                                echo"</li>";
                                echo "<li>";
                                echo $this->Html->link('パスワード変更',array('controller'=>'Teachers','action'=>'changePass'));
                                echo"</li>";
                                echo "<li>";
                                echo $this->Html->link('Verifycode変更',array('controller'=>'Teachers','action'=>'changeVerify'));
                                echo"</li>";
                                break;
                            
                            case '3':
                            	echo "<li>";
                                echo $this->Html->link('個人情報を変更',array('controller'=>'Students','action'=>'change_info'));
                                echo"</li>";
                                echo "<li>";
                                echo $this->Html->link('課金情報',array('controller'=>'Students','action'=>'getFees'));
                                echo"</li>";
                                echo "<li>";
                                echo $this->Html->link('パスワード変更',array('controller'=>'Students','action'=>'changePass'));
                                echo"</li>";
                                break;

                            default:
                                # code...
                                break;
                        }
                    ?>               
                </ul>
            </div><!--End #acc_info-->