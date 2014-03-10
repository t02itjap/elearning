<div id="main_content">
            <h2>Verifyコード変更する。</h2>
                <?php echo $this->Form->create('User',array(''))?>
                    <div id="change_info">
                    <table>
                        
                        <tr>
                            <td>質問</td>
                            <td><input type="text" value="自分の名前は？" disabled="true"/></td>
                        </tr>
                        <tr>
                            <td>現在答え</td>
                            <td><input type="text" value=""/></td>
                        </tr>
                        <tr>
                            <td>新しい答え</td>
                            <td><input type="text" value=""/></td>
                        </tr>
                        <tr>
                            <td>新しい答え確認</td>
                            <td><input type="text" value=""/></td>
                        </tr>
                    </table>
                    </div><!--End #change_info-->
                    <div id="submit">
                            <input type="submit" name="ok" value="作成"/>
                        </div><!--End #submit-->
                </form>
            </div><!--End #main_content-->
