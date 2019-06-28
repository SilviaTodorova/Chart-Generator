<aside class="teacher">
        <?php if ($model["user_data"]["gender_id"] == 1) {?>
            <img src=<?php echo ROOT."resources/assets/images/avatar-male.png"?> alt="Avatar" class="avatar">
        <?php } else if($model["user_data"]["gender_id"] == 2){ ?>
            <img src=<?php echo ROOT."resources/assets/images/avatar-female.png"?> alt="Avatar" class="avatar">
        <?php } else { ?>
            <img src=<?php echo ROOT."resources/assets/images/avatar.png"?> alt="Avatar" class="avatar">
        <?php } ?>

        <section class="user-data">
            <h3><?php echo $model["user_data"]['name'].' '.$model["user_data"]['lastname']?></h3> 
            <p><em><?php echo $model["user_data"]['email']?></em></p>
        </section>

        <ul>
        <li>
            <img src=<?php echo ROOT."resources/assets/images/charts.png"?> alt="profil" class="icon">
                <a href=<?php echo ROOT?>>Диаграми</a>
            </li>
            <li>
                <img src=<?php echo ROOT."resources/assets/images/profile.png"?> alt="profil" class="icon">
                <a href=<?php echo ROOT."user/profile"?>>Профил</a>
            </li>
            <li>
                <img src=<?php echo ROOT."resources/assets/images/students.png"?> alt="profil" class="icon">
                <a href=<?php echo ROOT."student/getAllStudents"?>>Студенти</a>
            </li>
            <li>
                <img src=<?php echo ROOT."resources/assets/images/marks.png"?> alt="profil" class="icon">
                <a href=<?php echo ROOT."student/getAllStudentsResults"?>>Резултати</a>
                
            </li>

        </ul>

    </aside>

    
<main class="teacher">

    <header>
        <table>
            <tbody>
                <tr>
                    <th width="10%">
                        <img src=<?php echo ROOT."resources/assets/images/web.png"?> alt="web" class="header">
                    </th>
                    <th width="90%">
                        <p>Web технологии, летен семестър 2018/2019</p>
                    </th>
                </tr>
            </tbody>
        </table>
    </header>