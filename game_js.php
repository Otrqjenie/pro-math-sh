<?php
if (!defined('proverka')) {
	die();
};
// require_once "connect2.php";
// require_once "lib/request.php";
?>

<div align  = "center">

	<div id="left_conteiner">
	<div id="imya">
		<p>
			<?=htmlspecialchars($_SESSION['imya'])?>
			&nbsp;
			<?=htmlspecialchars($_SESSION['familiya'])?>
			<a href="<?=$_SERVER['SCRIPT_NAME']?>?statist=1">(Статистика)</a>
		</p>
	</div>
	<div id="vkladki">
		<div id="oge" <?if($_SESSION['razdel'] == "oge"){echo "style = 'background-color: #FA8072'";}?>>
			<p>ОГЭ</p>
		</div>
		<div id="ege" <?if($_SESSION['razdel'] == "ege"){echo "style = 'background-color: #FA8072'";}?>>
			<p>ЕГЭ</p>
		</div>
		<div id="sh_f" <?if($_SESSION['razdel'] == "sh_f"){echo "style = 'background-color: #FA8072'";}?>>
			<p>Ш_св</p>
		</div>
		<div id="U_f" <?if($_SESSION['razdel'] == "U_f"){echo "style = 'background-color: #FA8072'";}?>>
			<p>У_св</p>
		</div>
	</div>

	<div id="shield_cont">
	<!-- 	<div>
			<p>Щит</p>
		</div>
 -->		<div id = "shield">
			<div id="sh1" <?php if ($_SESSION['razdel'] !== "oge"){echo "style = display:none";} else{echo "style = display:block";}; ?>>
			<?
			// переделать запрос
						$shield4 = $db->prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z 
							ON s.id_zsh = z.id
							WHERE s.id_user = ? and z.razdel = ? ORDER BY id_zsh
							 ");
						$oge = "oge";
						$shield4->bind_param('is', $_SESSION['id'], $oge);
						$shield4->execute();
						$shield4->bind_result($id_rz, $nazvanie);
						$m = "";
						$i = 1;
						while ($shield4->fetch()) {
							$m = $m."
			<div id = 'sh_p".$i."'>
			
				<span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie."</span>
				<span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span>
			
			</div>
			";
						$i++;
						};
						if ($m == "") {
							echo "Щит пуст!";
						}
						else{
							echo $m;
						};
						
						$shield4->close();
					?>
			</div>
			<div id="sh2" <?php if ($_SESSION['razdel'] !== "ege"){echo "style = display:none";} else{echo "style = display:block";}; ?> >
				<?
							$shield4 = $db->
				prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z 
							ON s.id_zsh = z.id
							WHERE s.id_user = ? and z.razdel = ? ORDER BY id_zsh
							");
							$ege = "ege";
							$shield4->bind_param('is', $_SESSION['id'], $ege);
							$shield4->execute();
							$shield4->bind_result($id_rz, $nazvanie);
							$m = "";
							while ($shield4->fetch()) {
								$m = $m."
				<p>
					<span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie."</span>
					<span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span>
				</p>
				";
							};
							if ($m == "") {
								echo "Щит пуст!";
							}
							else{
								echo $m;
							};
							$shield4->close();
						?>
			</div>
			<div id="sh3" <?php if ($_SESSION['razdel'] !== "sh_f"){echo "style = display:none";} else{echo "style = display:block";}; ?>>
				<?
							$shield4 = $db->
				prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z 
							ON s.id_zsh = z.id
							WHERE s.id_user = ? and z.razdel = ? ORDER BY id_zsh
							");
							$sh_f = "sh_f";
							$shield4->bind_param('is', $_SESSION['id'], $sh_f);
							$shield4->execute();
							$shield4->bind_result($id_rz, $nazvanie);
							$m = "";
							while ($shield4->fetch()) {
								$m = $m."
				<p>
					<span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie."</span>
					<span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span>
				</p>
				";
							};
							if ($m == "") {
								echo "Щит пуст!";
							}
							else{
								echo $m;
							};
							$shield4->close();
						?>
			</div>
			<div id="sh4" <?php if ($_SESSION['razdel'] !== "U_f"){echo "style = display:none";} else{echo "style = display:block";}; ?>>
				<?
							$shield4 = $db->
				prepare("SELECT s.id_zsh, z.nazvanie FROM shield s INNER JOIN zadania z 
							ON s.id_zsh = z.id
							WHERE s.id_user = ? and z.razdel = ? ORDER BY id_zsh");
							$U_f = "U_f";
							$shield4->bind_param('is', $_SESSION['id'], $U_f);
							$shield4->execute();
							$shield4->bind_result($id_rz, $nazvanie);
							$m = "";
							while ($shield4->fetch()) {
								$m = $m."
				<p>
					<span class = 'my_sh' onclick = show_z(".$id_rz.")>".$nazvanie."</span>
					<span class = 'my_sh' onclick = del_z(".$id_rz.")>-</span>
				</p>
				";
							};
							if ($m == "") {
								echo "Щит пуст!";
							}
							else{
								echo $m;
							};
							$shield4->close();
						?>
			</div>
		</div>
	</div>
	<div id="arsenal">
		<!-- <p>Арсенал</p>
		<p id="go">
			Попап
		</p> -->
		<div id="ars1" <?php if ($_SESSION['razdel'] !== "oge"){echo "style = display:none";} else{echo "style = display:block";} ?>>
		
		<!-- <select name = "type2">
			<option>Выберите тип задачи</option>
			<option value = "Числа_и_вычисления">Числа_и_вычисления</option>
			<option value = "Алгебраические_выражения">Алгебраические_выражения</option>
			<option value = "Уравнения_и_неравенства">Уравнения_и_неравенства</option>
			<option value = "Числовые_последовательности">Числовые_последовательности</option>
			<option value = "Функции">Функции</option>
			<option value = "Координаты_на_прямой_и_плоскости">Координаты_на_прямой_и_плоскости</option>
			<option value = "Геометрия">Геометрия</option>
			<option value = "Статистика_и_теория_вероятности">Статистика_и_теория_вероятности</option>

		</select> -->
		<!-- #dec4b0 -->
		<div id="accc">
		<div id="accordion">
			<h3>Арсенал</h3>
			<div id="ars_in">
				<div class="accordeon_ars actif" id="accordeon1">
					Числа_и_вычисления
				</div>
				<div class="accordeon_ars" id="accordeon2">
					Алгебраические_выраж...
				</div>
				<div class="accordeon_ars" id="accordeon3">
					Уравнения_и_неравенс...
				</div>
				<div class="accordeon_ars" id="accordeon4">
					Числовые_последовател...
				</div>
				<div class="accordeon_ars" id="accordeon5">
					Функции
				</div>
				<div class="accordeon_ars" id="accordeon6">
					Координаты_на_прямой_и...
				</div>
				<div class="accordeon_ars" id="accordeon7">
					Геометрия
				</div>
				<div class="accordeon_ars" id="accordeon8">
					Статистика_и_теория_вер...
				</div>
			</div>
			<h3>База заданий</h3>
			<div>
				<div class="accordeon_input actif_b" id="accordeon1">
					Числа_и_вычисления
				</div>
				<div class="accordeon_input" id="accordeon2">
					Алгебраические_выраж...
				</div>
				<div class="accordeon_input" id="accordeon3">
					Уравнения_и_неравенс...
				</div>
				<div class="accordeon_input" id="accordeon4">
					Числовые_последовател...
				</div>
				<div class="accordeon_input" id="accordeon5">
					Функции
				</div>
				<div class="accordeon_input" id="accordeon6">
					Координаты_на_прямой_и...
				</div>
				<div class="accordeon_input" id="accordeon7">
					Геометрия
				</div>
				<div class="accordeon_input" id="accordeon8">
					Статистика_и_теория_вер...
				</div>
			</div>
			
		</div>
		</div>

		<script src="js/external/jquery/jquery.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script>

		$( "#accordion" ).accordion({collapsible:true, fillSpace:true});
		$( "#resizerWrap" ).resizable({
		  minHeight:300,
		  resize: function(){
		    $( "#accordion" ).accordion("resize");
		  }
		});
		// $( "#dialog-link, #icons li" ).hover(
		// 	function() {
		// 		$( this ).addClass( "ui-state-hover" );
		// 	},
		// 	function() {
		// 		$( this ).removeClass( "ui-state-hover" );
		// 	}
		// );
		</script>

		<div id="list2" ></div>
		</div>
		<div id="ars2" class="ars" <?php if ($_SESSION['razdel'] !== "ege"){echo "style = display:none";} else{echo "style = display:block";}; ?>>1
			<div id="ars2_list"></div>
		</div>
		<div id="ars3" class="ars" <?php if ($_SESSION['razdel'] !== "sh_f"){echo "style = display:none";}  else{echo "style = display:block";};?>>2
			<div id="ars3_list"></div>
		</div>
		<div id="ars4" class="ars" <?php if ($_SESSION['razdel'] !== "U_f"){echo "style = display:none";} else{echo "style = display:block";}; ?>>3
			<div id="ars4_list"></div>
		</div>
	</div>
	</div>
	<div id="text_z">
		
	</div>
	
	<div id="baza">
		
		<label>Тип задачи:</label>
		<br>
		<div id="baza1" <?php if ($_SESSION['razdel'] !== "oge"){echo "style = display:none";} else{echo "style = display:block";}; ?>>
		<select name = "type">
			<option>Выберите тип задачи</option>
			<option value = "Числа_и_вычисления">Числа_и_вычисления</option>
			<option value = "Алгебраические_выражения">Алгебраические_выражения</option>
			<option value = "Уравнения_и_неравенства">Уравнения_и_неравенства</option>
			<option value = "Числовые_последовательности">Числовые_последовательности</option>
			<option value = "Функции">Функции</option>
			<option value = "Координаты_на_прямой_и_плоскости">Координаты_на_прямой_и_плоскости</option>
			<option value = "Геометрия">Геометрия</option>
			<option value = "Статистика_и_теория_вероятности">Статистика_и_теория_вероятности</option>
		</select>
		<div id="list"></div>
		</div>
		<div id="baza2" class="baza" <?php if ($_SESSION['razdel'] !== "ege"){echo "style = display:none";} else{echo "style = display:block";}; ?>>2<div id="list2"></div></div>
		<div id="baza3" class="baza" <?php if ($_SESSION['razdel'] !== "sh_f"){echo "style = display:none";} else{echo "style = display:block";}; ?>>3<div id="list3"></div></div>
		<div id="baza4" class="baza" <?php if ($_SESSION['razdel'] !== "U_f"){echo "style = display:none";} else{echo "style = display:block";}; ?>>4<div id="list4"></div></div>
	</div>

<div  id="doska">
	<div id="head_doski">
		
	</div>
	<div id="baza_popup">
		<div id="pole_doski">
			<div id="pole_zadanii">
				
			</div>
			<div id="pole_texta">
				
			</div>
			<div class="message">
				<div id="head_message">
					
				</div>
				<div id="message_text">
					<div id="message_box">
						
					</div>
					<div id="message_close">
						<p id="scrit"><span>Скрыть</span></p>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
</div>
</div>
