
<table class="homepage">
    <tr>
        <th class="alignleft">
           <?php echo $model["student_data"]["email"]?>
        </th>
        <th class="aligncenter">
            <?php echo $model["student_data"]["name"].' '.$model["student_data"]["lastname"]?>
        </th>
        <th class="alignright">
            <?php echo ' ФН: '.$model["student_data"]["fn"].', Специалност: '.$model["student_data"]["speciality"].', Група: '.$model["student_data"]["student_group"]?>
        </th>
    </tr>
    <tr>
        <td colspan="3">
            <img src=<?php echo ROOT."resources/assets/images/header.jpg"?> alt="Заглавна страница" class="header">
        </td>
    </tr>
    <tr class="buttons">
        <td width="30%" class="aligncenter">
            <a href="#results">
                <img src=<?php echo ROOT."resources/assets/images/marks.png"?> alt="Оценки" width="150px">
                <span class="title">Резултати</span>
            </a>
        </td>
        <td width="30%" class="aligncenter">
            <a href="#statistics">
                <img src=<?php echo ROOT."resources/assets/images/charts.png"?> alt="Статистика" width="150px">
                <span class="title">Статистика</span>
            </a>
        </td>
        <td width="30%" class="aligncenter">
            <a href="#password">
                <img src=<?php echo ROOT."resources/assets/images/password.png"?> alt="Смяна на парола" width="150px">
                <span class="title">Смяна на парола</span>
            </a>
        </td>
    </tr>
    <tr class="allData" id="results">
        <td colspan="3">
            <section class="students">
                <h1>Резултати</h1>

                <?php if (count($model['results']) > 0 && count($model['results']) > 0) { ?>
                    <table>
                    <tr>
                        <th>Оценка</th>
                        <th>Категория</th>
                        <th>Оценил</th>
                        <th>Коментар</th>
                    </tr>
                    <?php foreach($model['results'] as $key=>$value): ?>
                        <tr>
                            <td><?php echo $value['mark_value']?></td>
                            <td><?php echo $value['category_name'].' '.$value['stage']?></td>
                            <td><?php echo $value['author']?></td>
                            <td><?php echo $value['comment']?></td>
                        </tr>
                    <?php endforeach; ?>                   
                </table>
                <?php } else { ?>
                    <p>Няма добавени резултати</p>
                <?php } ?>
                

            </section>
               
        </td>
    </tr>
    <?php if (count($model['charts']) > 0 ) { ?>
        <tr class="allData" id="statistics">
            <td colspan="3">
                <?php foreach($model['charts'] as $key=>$value): ?>
                   <div class="aligncenter">
                        
                        <img id=<?php echo $value['chart_id']?> src=<?php echo $value['img']?>>
                    </div>
                    
                <?php endforeach; ?>
            </td>
      
        </tr>
    <?php }?>
    <tr class="allData" id="password">
        <td colspan="3">
            <section class="students">
                <h1>Смяна на парола</h1>

                <form name="password" method="post" action=<?php echo LOCATION.'user/editAccount'?>>
                    <table>
                        <tr>
                            <th>Парола</th>
                            <th>Нова парола</th>
                            <th>Повтори паролата</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td><input type="password" name="password" placeholder="Парола" require></td>
                            <td><input type="password" name="new-password" placeholder="Нова парола" require></td>
                            <td><input type="password" name="confirm-password" placeholder="Потвърди новата парола" require></td>
                            <td><button class="btn lg success" type="submit">Запази</button></td>
                        </tr>          
                    </table>
                </form>

            </section>
               
        </td>
    </tr>

</table>