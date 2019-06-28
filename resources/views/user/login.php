<section class="login">
    <div class="fancy-login-form">
        <table>
            <tbody>
                <tr>
                    <th width="50%">
                        <img src=<?php echo ROOT."resources/assets/images/login.jpg"?> alt="Login">
                    </th>
                    <th width="50%">
                        <form name="signIn" method="POST" action=<?php echo LOCATION.'user/login'?>>
                            <label class="control-placeholder">Имейл</label>
                            <input type="text" id="email" name="email" placeholder>
                            
                            <label class="control-placeholder">Парола</label>
                            <input type="password" id="password" name="password" placeholder>
                        
                            <section class="buttons-group">
                                <button class="btn success" type="submit" id="form-login-submit">Вход</button>
                                <p class="error"><?php echo (isset($model["error_description"])) ? $model["error_description"] : '';?></p>
                            </section>
                           
                         </form>
                    </th>
                </tr>
            </tbody>
        </table>
     </div>
</section>