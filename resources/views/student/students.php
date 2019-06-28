<h3 class="errorDesc"><?php echo isset($model["error_description"]) ? $model["error_description"] : ''?></h3>

<section class="students">

  <h2>Добави студенти към курса</h2>
  <hr>

  <form action="./upload/index.php" 
        method="post" 
        name="frmExcelImport"
        id="frm  ExcelImport" 
        enctype="multipart/form-data"
        class="upload-excel"
  >
      <img src=<?php echo ROOT."resources/assets/images/students.png"?> alt="Студенти">
      <label>Добави студенти към курса</label>
      <input type="file" name="file" id="file" accept=".xls,.xlsx" value=""/>
      <input type="hidden" name="action" value="uploadStudents">
      <button class="btn xs success" type="submit" id="submit" name="import">Запази</button>
  </form>

  <p>Записани студенти</p>
  <hr>

  <?php if (count($model['students']) > 0 && count($model['students']) > 0) { ?>
  <table>
    <tr>
      <th>Факултетен номер</th>
      <th>Имейл</th>
      <th>Име</th>
      <th>Група</th>
      <th>Специалност</th>
    </tr>
    <?php foreach($model['students'] as $key=>$value): ?>
      <tr>
        <td><?php echo $value['fn']?></td>
        <td><?php echo $value['email']?></td>
        <td><?php echo $value['name'].' '.$value['lastname']?></td>
        <td><?php echo $value['student_group']?></td>
        <td><?php echo $value['speciality']?></td>
     </tr>
     <?php endforeach; ?>
  </table>
  

<?php } else { ?>
  <h2>Няма добавени студенти</h2>
<?php } ?>

</section>
    

