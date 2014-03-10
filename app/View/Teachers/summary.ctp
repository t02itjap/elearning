<div id="main_content">
            <div id="summary">
            <h2>授業サマリー</h2>
            <p>Like数：<?php echo $lesson['Lesson']['voters']?>件（<?php echo $lesson['Lesson']['voters']/$snum*100?>％受講者数)</p>
            <p>参照数：<?php echo $lesson['Lesson']['viewers']?></p>
            <p>受講者数：<?php echo $snum;?>人</p>
            <h2>受講者リスト</h2>
                <table>
                    <thead>
                        <tr>
                            <th>順番</th>
                            <th>名前</th>
                            <th>時間</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($students as $s) {?>
                        <tr>
                            <td><?php echo $i?></td>
                            <td><?php $i++; echo $s['Bill']['user_name']?></td>
                            <td><?php echo $s['Bill']['learn_date']?></td>
                        </tr>
                    </tbody>
                    <?php }?>
                </table>
            <h2>ブロック学生リスト</h2>
                <table>
                    <tr>
                        <td>順番</td>
                        <td>名前</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <input type="text" style="margin-left: 30px;"/><button>ブロック</button>
                </div>
            </div><!--End #main_content-->