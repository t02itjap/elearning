               <?php echo $this->Session->flash();?>          
            <?php echo $this->Form->create('Document',array('type'=>'post'))?>

                    <table>
                        <tr>
                            <td>ファイル名</td>
                            <td><p><?php echo $document['Document']['file_name']?></p></td>
                        </tr>
                        <tr>
                            <td>アップロード時間</td>
                            <td><p><?php echo $document['Document']['create_date']?></p></td>
                        
                        <tr>
                            <td>リンク</td>
                            <td><p><?php echo $document['Document']['file_link']?></p></td>
                        </tr>  
                    </table>
                    <div id="submit">
                    <?php
                        echo $this->Form->button ( 'ブロック', array (
                                'value' => $document ['Document'] ['id'],
                                'name' => 'data[block_file]',
                                'class' => 'link-button',
                                'onClick' => "return confirm('このファイルをブロックしたいですか?')",
                                'escape' => 'flase',
                                'title' => 'xac nhan' 
                        ) );
                    ?>
                    <?php
                        
                        echo $this->Form->button ( '削除', array (
                                'value' => $document ['Document'] ['id'],
                                'name' => 'data[delete_file]',
                                'class' => 'link-button',
                                'onClick' => "return confirm('このファイルを削除したいですか?')",
                                'escape' => 'flase',
                                'title' => 'xac nhan' 
                        ) );
                    ?>
                    </div><!--End #submit-->
        <?php echo $this->Form->end();?>