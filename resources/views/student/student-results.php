<h3 class="errorDesc"><?php echo isset($model["error_description"]) ? $model["error_description"] : ''?></h3>

    <section class="students">
      <h2>Добави резултати</h2>
      <hr>

      <form action="./upload/index.php" 
        method="post" 
        name="frmExcelImport"
        id="frm  ExcelImport" 
        enctype="multipart/form-data"
        class="upload-excel"
  >
      <img src=<?php echo ROOT."resources/assets/images/students.png"?> alt="Студенти">
      <label>Категория</label>
      <select name="category">
        <option value="1" selected>Домашно</option>
        <option value="2">Реферат</option>
        <option value="3">Проект</option>
      </select>

      <label>Етап</label>
      <input type="number" name="stage" value=""/>

      <input type="file" name="file" id="file" accept=".xls,.xlsx" value=""/>

      <input type="hidden" name="action" value="uploadMarksByCategoryAndStage">
      <button class="btn xs success" type="submit" id="submit" name="import">Запази</button>
  </form>
  
      <h2>Резултати на всички студенти</h2>
      <hr>

      <?php if (count($model['results']) > 0 && count($model['results']) > 0) { ?>

      <table>
        <tr>
          <th>Факултетен номер</th>
          <th>Име</th>
          <th>Категория</th>
          <th>Оценка</th>
          <th>Оценил</th>
          <th>Коментар</th>
        </tr>
        <?php foreach($model['results'] as $key=>$value): ?>
          <tr>
            <td><?php echo $value['fn']?></td>
            <td><?php echo $value['name'].' '.$value['lastname']?></td>
            <td><?php echo $value['category_name'].' '.$value['stage']?></td>
            <td><?php echo $value['mark_value']?></td>
            <td><?php echo $value['author']?></td>
            <td><?php echo $value['comment']?></td>
        </tr>
        <?php endforeach; ?>
      </table>

 
  <?php } else { ?>
    <p>Няма добавени оценки</p>
  <?php } ?>

  </section>
    