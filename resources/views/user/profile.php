
<h3 class="errorDesc"><?php echo isset($model["error_description"]) ? $model["error_description"] : ''?></h3>

<section class="profile-details">
    <form id="profile-info" name="profile-edit" method="POST" action=<?php echo LOCATION.'user/editAccount'?>>

        
        <section class="main-data">
            <table class="profile-info">
                <tr>
                    <th colspan="3">Лични данни</th>
                </tr>
                <tr>
                    <td>
                        <label class="control-placeholder not-empty">Роля</label>
                        <input type="text" name="role" value="<?php echo ($model["user_data"]["role_id"] == 1) ? 'Учител' : 'Студент' ?>" placeholder disabled>
                    </td>
                    <td>
                        <label class="control-placeholder not-empty">Имейл</label>
                        <input type="email" name="email" value="<?php echo $model["user_data"]["email"] ?>" placeholder disabled>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-placeholder not-empty">Име</label>
                        <input type="text" name="name" value="<?php echo $model["user_data"]["name"] ?>"
                        placeholder
                        require
                        <?php if ($model["user_data"]["role_id"] == 2) {
                                    echo 'disabled';
                                }
                        ?>>
                    </td>
                    <td>
                        <label class="control-placeholder not-empty">Фамилия</label>
                        <input type="text" name="lastname" value="<?php echo $model["user_data"]["lastname"] ?>"
                        placeholder
                        require
                        <?php if ($model["user_data"]["role_id"] == 2) {
                            echo 'disabled';
                        }
                        ?>>
                    </td>
                </tr>
            </table>
        </section>

        <section class="change-password">
            <table class="profile-info">
                <tr>
                    <th colspan="3">Смяна на парола</th>
                </tr>
                <tr>
                    <td>
                        <label>Парола</label>
                        <input type="password" name="password" placeholder require>
                    </td>
                    <td>
                        <label>Нова парола</label>
                        <input type="password" name="new-password" placeholder require>
                    </td>
                    <td>
                        <label>Повтори паролата</label>
                        <input type="password" name="confirm-password" placeholder require>
                    </td>
                </tr>
            </table>

            <button class="btn lg success" type="submit" id="form-login-submit">Запази</button>
    </form>
</section>




