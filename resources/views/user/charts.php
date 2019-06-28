<script src=<?php echo ROOT."resources/assets/js/widget-chart.js"?>></script>
<input id="url" type="hidden" value=<?php echo $model["url"]?>>

<section class="chart-widget">
	<form name="settings" method="post">
		<section class="type">
			<table class="charts">
				<tr>
                    <th colspan="4">Тип на диаграмата</th>
                </tr>
				<tr>
					<td>
						<div class="chart-type">
							<input type="radio" name="type" value="bar" id="type-bar" checked/>
							<label for="type-bar">
								<img src=<?php echo ROOT."resources/assets/images/bars.png"?> alt="Bar chart"/>
							</label>
						</div>
					</td>
					<td>
						<div class="chart-type">
							<input type="radio" name="type" value="line" id="type-line" />
							<label for="type-line">
								<img src=<?php echo ROOT."resources/assets/images/line.png"?> alt="Line chart"/>
							</label>
						</div>
					</td>
					<td>
						<div class="chart-type">
							<input type="radio" name="type" value="pie" id="type-pie" />
							<label for="type-pie">
								<img src=<?php echo ROOT."resources/assets/images/pie.png"?> alt="Pie chart"/>
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="chart-type">
							<input type="radio" name="type" value="radar" id="type-radar" />
							<label for="type-radar">
								<img src=<?php echo ROOT."resources/assets/images/radar.png"?> alt="Radar chart"/>
							</label>
						</div>
					</td>
					<td>
						<div class="chart-type">
							<input type="radio" name="type" value="doughnut" id="type-doughnut" />
							<label for="type-doughnut">
								<img src=<?php echo ROOT."resources/assets/images/doughnut.png"?> alt="Doughnut chart"/>
							</label>
						</div>
					</td>
					<td>
						<div class="chart-type">
							<input type="radio" name="type" value="horizontalBar" id="type-horizontal" />
							<label for="type-horizontal">
								<img src=<?php echo ROOT."resources/assets/images/horizontal.png"?> alt="Horizontal chart"/>
							</label>
						</div>
					</td>
					<td>
					</td>
				</tr>
			</table>
		</section>

		<section class="settings-chart">
			<table class="settings">
				<tr>
                    <th colspan="3">Настройки</th>
                </tr>
				<tr>
					<td>
						<label>Заглавие</label>
						<input type="text" name="title" value="">
					</td>
					<td>
						<label>X координати</label>
						<input type="text" name="x-title" value="">
					</td>
					<td>
						<label>Y координати</label>
						<input type="text" name="y-title" value="">
					</td>
				</tr>
				<tr>
					<td>
						<label>Мин. Y</label>
						<input type="number" step="20" min="0" name="min-y" value="0">
					</td>
					<td>
						<label>Макс. Y</label>
						<input type="number" step="20" min="0" name="max-y" value="100">
					</td>
					<td>
						<label>Стъпка</label>
						<input type="number" min="0" name="step" value="20">
					</td>
				</tr>
				<tr>
					<th colspan="100%">Данни</th>
				</tr>
				<tr>
					<td colspan="100%">
						<button class="btn success" id="add-data">
							<img src=<?php echo ROOT."resources/assets/images/add.png"?> alt="add" class="icon">
							Добави
						</button>
						<button class="btn danger" id="delete-data">
							<img src=<?php echo ROOT."resources/assets/images/delete.png"?> alt="add" class="icon">
							Изтрий
						</button>
						<button class="btn warning" id="open-preview-chart">
							Създай диаграма
						</button>
					</td>
				</tr>
				<tr>
					<table id="data" class="data settings">
							<tr id="tr-x">
								<td class="aligncenter">
									<h3>X координати</h3>
								</td>
							</tr>
							<tr id="tr-dropdown">
								<td>
									<select id="x-coord">
										<option value="1">Всички студенти</option>
										<option value="2">Група студенти</option>
										<option value="3">Пол</option>
									</select>
									<select id="all-student" multiple>
									</select>
								</td>
							</tr>
							<tr id="tr-data">
								<td id="x-data">
									
								</td>
							</tr>
					</table>
				</tr>
				
			</table>
		</section>

		<section class="all-charts">
			<table class="settings images" id="charts">
				<tr>
					<th colspan="100%">
						Всички диаграми 
					</th>
				</tr>
				<tr>
					<td class="aligncenter">
						
					</td>
				</tr>
				
			</table>
		</section>

	</form>

	<!-- Chart Preview Modal -->
	<div class="modal" id="preview-chart" >
		<!-- Modal content -->
		<div class="modal-content">

			<div class="modal-header">
				<span id="close-preview-chart" class="close">&times;</span>
			<h4>Диаграма</h4>
			</div>

			<div class="modal-body">
				<div id="generate" class="chart-container">
				</div>
			</div>

			<div class="modal-footer">
				<form name="chart" method="post" action=<?php echo LOCATION.'chart/save'?> >
					<input type="hidden" name="img" id="base64" value="">

					<div class="form-buttons">
						<a class="btn md success" id="save" href="" type="submit">Запази</a>
						<a class="btn md info" href="" id="hrefBase64" href="" download="ChartJpg.jpg">Изтегли</a>
					</div>
				</form>
			</div>

		</div>
	</div>
</section>

