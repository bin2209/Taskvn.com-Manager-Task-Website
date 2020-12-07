<?php 
date_default_timezone_set('Asia/Ho_Chi_Minh');
include("../../../blogadmin/lib.php");  
include("../../libs/db_connect.php");
?>
<h4>Thông báo & nhắc nhở</h4>
<table id="table_one" class="table">
	<thead>
		<tr class="addnew">
			<th scope="col" style="vertical-align: inherit !important;"></th>
			<th scope="col">Công việc</th>
			<th scope="col">Nội dung</th>
			<th scope="col" style="text-align:center;">Quan trọng</th>
			<th scope="col" style="text-align:center;">Thời gian báo tiếp theo</th>
			<th scope="col" style="text-align:center;">Định kỳ</th>
		</tr>
	</thead>
	<script type="text/javascript">
		function dragstemp(ev){
			ev.dataTransfer.setData("text", ev.target.id);
			x= ev.dataTransfer.getData("text"); 

		}
		function dropstamp(ev){
			ev.preventDefault();
			ev.preventDefault();
    var data = ev.dataTransfer.getData("text"); // data  là id di chuyển 
    // document.getElementById(data).style.color = "red";
    name= document.getElementById("idnamesentname").value;
    id= document.getElementById("idnamesentid").value;
    addstemp(data,name,id);
}
</script>
<!-- <form> -->
	<tbody id="tableBody" ondrop="dropstamp(event)" ondragover="allowDrop(event)" >
		<form action="stamp.php" method="POST">
			<input id="idnamesentname" type="" name="" value="" style="display: none;">
			<input id="idnamesentid" type="" name="" value="" style="display: none;">
			<?php 
			$sql = "SELECT * FROM `todo`";
			$result = mysqli_query($con, $sql);
			if (mysqli_num_rows($result)) {
				// if ($countmyday==0){ echo ""; }
				while($row = mysqli_fetch_assoc($result)) {
					if ($row["user"]== getLoggedMemberID() && $row["thongbao"]!=NULL){
						echo '  
						';
						if ($row["trangthai"]=="doing"){
							echo ' 
							<tr id="drag'.$row["id"].'"onclick="chitiet(this.id)" draggable="true" ondragstart="drag(event)" >
							<input  id="drag'.$row["id"].'value" value="'.$row["task"].'" style="display:none;" />
							<td scope="row"   class="taskcon" >
							<input type="radio" onclick="funtrangthaiclick(this.id)" id="'.$row["id"].'" name="id'.$row["id"].'" class="" value="'.$row["id"].'"/>
							<span class="checkmark"></span>
							</td>
							<td>'.$row["task"].'</td>
							<td>'.$row["noidung"].'</td>
							<td style="display:none;">
							<button  style="display:none;" id="remove'.$row["id"].'" name="'.$row["id"].'" class="btn btn-primary btn-sm remove" value="delete'.$row["id"].'">Xóa</button></td>

							';
						}else if ($row["trangthai"]=="done"){
							echo ' 
							<tr id="drag'.$row["id"].'" value="'.$row["task"].'" onclick="chitiet(this.id)"   draggable="true" ondragstart="drag(event)"  style="background-color: #e7e7e7; color: black;">

							<input  id="drag'.$row["id"].'value" value="'.$row["task"].'" style="display:none;" />

							<td scope="row"  class="taskcon" >

							<input type="radio" checked="checked"  type="radio" onclick="funtrangthaiclick(this.id)" id="'.$row["id"].'" class="" name="'.$row["id"].'" value="'.$row["id"].'"/>
							<span class="checkmark"></span>

							</td>
							<td style=" text-decoration: line-through;">'.$row["task"].'</td>
							<td style=" text-decoration: line-through;">'.$row["noidung"].'</td>
							<td style="display:none;">
							<button style="display:none;" id="remove'.$row["id"].'" class="btn btn-primary btn-sm remove" name="id" value="delete'.$row["id"].'">Xóa</button></td>

							';
						}
               //star
               if ($row["star"]=="0"){ // danghoatdong
               	echo ' <td style="text-align:center;"><span class="fa fa-star " onclick="makestar(this.id)" type="radio" id="star'.$row["id"].'" name="" value="star'.$row["id"].'"></span></td>';
               } else {
               	echo ' <td style="text-align:center;"><span class="fa fa-star checkedstar" onclick="makestar(this.id)" type="radio" id="star'.$row["id"].'" name="" value="star'.$row["id"].'"></span></td>';
               }

               if ($row["thongbao"]!=NULL){
               	echo '<td class="thongbaotime" id="xoathongbao'.$row["id"].'" onclick="xoathongbao(this.id)"  style=" min-width: 52px;"><i class="fa fa-bell"></i><i class="fa fa-bell-slash"></i>';
               	date_default_timezone_set('Asia/Ho_Chi_Minh');
               	$your_date = strtotime($row["thongbao"]);
               	$now = strtotime(date('Y-m-d H:i:s'));
               	$datediff = $your_date - $now;
               	$hours =round($datediff / (60 * 60)); 
               	$days =round($datediff / (60 * 60*24)); 
               	if ($days>0){
               		echo "<span class='thongbaotext'>".$days."d</span>";
               		echo "</td>";
               	} else if ($days==0&&$hours>0) {
               		echo "<span class='thongbaotext'>".$hours."h</span>";
               		echo "</td>";
               	} else{
                    // tính năng thông báo ra hoặc thông báo về mail tại đây
               		$requestid = $row["id"];
               		$sql = 'UPDATE todo
               		SET thongbao = NULL WHERE id='.$requestid.';
               		';
               		$result = mysqli_query($con, $sql);
               		if($result)
               		{
               			header("Refresh:0");
               		}
               	}

               } else{
               	echo "<td></td>";
               }



                  if ($row["stamp"]=="do"){ // danghoatdong
                  	echo '<td><img src="img/do.png"></td>';
                  } else if ($row["stamp"]=="vang"){
                  	echo '<td><img src="img/vang.png"></td>';
                  } else if ($row["stamp"]=="xanh"){
                  	echo '<td><img src="img/xanh.png"></td>';
                  } else if ($row["stamp"]=="lam"){
                  	echo '<td><img src="img/lam.png"></td>';
                  } else if ($row["stamp"]=="im"){
                  	echo '<td><img src="img/tim.png"></td>';
                  } else{
                  	echo '<td></td>';
                  }

                  
                  echo '  </tr> ';
              } 

          }
      }
      ?>
  </form>
</tbody>
</table>
<br>


