<?php
	
   require_once('config.php');


echo "<style>";
echo "body {";
echo "font-size: 50px;";
echo "color: white;";
echo "background-image: url('images.jpg');";
echo "background-repeat: no-repeat;";
echo "background-attachment: fixed;";
echo "background-size: cover;";
echo "}";
echo "</style>";


    	if ($_POST['sav'])                            //сохранение изменений
	{

		$sal_id=get_post('sal_id');
        	$sum=get_post('sum');
        	$emp_id=get_post('emp_id');
        	$date=get_post('date');          

           	$q1="update salary set sum ='".$sum."', emp_id ='".$emp_id."', date ='".$date."' where sal_id='".$sal_id."'";
           	mysql_query($q1);
	}


	if (($_POST['add']) && ($_POST['sum']!=''))// && ($_POST['emp_id']!='') && ($_POST['date']!='') && ($_POST['class']!='') && ($_POST['madein']!='') && ($_POST['V_gastank']!=''))   //добавление новой информации
	{
		$sum=get_post('sum');
		$q="insert into salary value(null,'".$sum."','".$_POST['emp_id']."','".$_POST['date']."')";
		mysql_query($q);
	} 


   	if (($_POST['rad']) && ($_POST['del']))        //удаление выбранной информации
       	{
		$q="delete from salary where sal_id='".$_POST['rad']."'";
		mysql_query($q);
        }


	
	// основной блок - вывод данных	
        $query ="select sum, date, drivers.fio as fio, sal_id from salary left join drivers on salary.emp_id = drivers.emp_id"; 
        $result=mysql_query($query)or die ("Ошибка при выполнении запроса: " .mysql_error ());
 
         echo "<h2 align=center> Зарплата </h2>";
	 //echo "<tr><th><h2 align=center>  </h2></th></tr>";
        //echo "<table border=0 width=50% align=center>";
        //      echo "<tr><th colspan='3' ><bh>Зарплата</bh></th></tr>";
        //      echo "<tr>";

         echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
         echo "<br><br>";
         echo "<table border=4 width=30% align=center>";

         echo "<tr><th width=10%></th><th width=30%>sum</th><th width=40%>emp FIO</th><th width=60%>date</th></tr>";
         while ($row = mysql_fetch_array ($result)) 
            { 
              echo "<tr>";
              echo "<td align=right><input type=radio name='rad' value='".$row['sal_id']."'>";
              echo "<td><i>"; echo $row ["sum"]; echo "</i></td>";
		echo "<td><b>"; echo $row ["fio"]; echo "</b></td>";   
              echo "<td>"; echo $row ["date"]; echo "</td>";    
              echo "</tr>";
            }
         echo "</table>";
		 

        //$result1=MYSQL_QUERY("select fio from employees ") or die ("Ошибка при выполнении запроса: " .mysql_error ()); 
         
	// добавление
	echo "<table border=0 width=25% align=center>";
        echo "<tr></tr><tr>";
	echo "<td><pre>sum <input type=text name=sum value='' size=15></pre></td>";
	echo "<td><pre>date<input type=text name=date value='' size=15></pre></td>";
	echo "<td><pre>FIO";       
	echo "<select name=emp_id>";    // формирование выпадающего списка
	$result1=MYSQL_QUERY("select emp_id, fio from drivers") or die ("Ошибка при выполнении запроса: " .mysql_error ());
        while ($row1 = mysql_fetch_array($result1)) 
        	{ echo "<option value=".$row1['emp_id'].">".$row1['fio']."</option>";}
        echo "</select></pre></td>";
        echo "<td><input type=submit name=add value='Добавить запись в базу'></td></tr><tr></tr>";

        echo "<tr><td colspan=3 align=left><input type=submit name=del value='Удалить'>  выбранную запись</td></tr>";
	echo "<tr><td colspan=7 align=left><input type=submit name=upd value='Изменить'> данные выбранной записи</td></tr>";		 
        
 
    	if (($_POST['rad']) && ($_POST['upd']))			//изменение выбранной информации
        {
             	echo "<table border=0 width=28% align=center>";
		echo "<tr><td colspan=7><b>Введите новую запись</b></td></tr>";			  
           	$qs="select drivers.fio, salary.emp_id as emp_id, salary.sum, salary.date, salary.sal_id from salary left join drivers on salary.emp_id = drivers.emp_id where salary.sal_id =".$_POST['rad'];
	
           	$ress=mysql_query($qs);

           	$rows = mysql_fetch_array ($ress);
             	echo "<tr><td>sum <input type=text name=sum value='".$rows['sum']."' size=12></td>";
	     	echo "<tr><td>date <input type=text name=date value='".$rows['date']."' size=12></td>";
             
		//$resulte=MYSQL_QUERY("select fio, emp_id from drivers where emp_id != ".$rows['emp_id']);            	
	     	$resulte=MYSQL_QUERY("select fio, emp_id from drivers");            	
	     	echo "<td>FIO <select name=emp_id>";
		while ($rowe = mysql_fetch_array($resulte)) 
             		{ echo "<option value=".$rowe['emp_id'].">".$rowe['fio']."</option>";}
             	echo "<option selected value=".$rows['emp_id'].">".$rows['fio']."</option>";
		echo "</select></td>";
		
           	echo "<td><input type=submit name=sav value='Сохранить'>";
           	echo "<input type=hidden name=sal_id value='".$rows['sal_id']."'></td></tr>";
                     echo "<table border=0 width=28% align=center>";
			 echo "<tr><td colspan=7><b>Введите новое авто</b></td></tr>";	
		  
           }


	echo "</tr></table>";



echo "</table>";










echo "</form>";

         MYSQL_CLOSE(); 
function get_post($var)
{
return mysql_real_escape_string($_POST[$var]);
}
?> 








<a href='query.php' target='_self'> Запросы</a>

