<?php

printForm(); 

#-----------------------------------------------------------------------------
// display the entry form for course search
function printForm(){
	
	echo '<h2>Course Lookup</h2>';

	echo "<a href=../index.php><--Back to Home</a><br><br>";

	// print user entry form
	echo "<form action='courses.php'>";
	echo "Course Prefix (Department)<br/>";
	echo "<input type='text' placeholder='CS' name='prefix'><br/>";
	echo "Course Number<br/>";
	echo "<input type='text' placeholder='116' name='courseNumber'><br/>";
	echo "Instructor<br/>";
	echo "<input type='text' placeholder='gpcorser' name='instructor'><br/>";
	echo "Day of Week<br/>";
    echo "<select name='day' id='dropdown'>";
    echo "<option value='Monday'>Monday</option>";
    echo "<option value='Tuesday'>Tuesday</option>";
    echo "<option value='Wednesday'>Wednesday</option>";
    echo "<option value='Thursday'>Thursday</option>";
    echo "<option value='Friday'>Friday</option>";
    echo "<option value='ONLINE'>ONLINE</option>";
    echo "</select><br>";
	//echo "Building/Room<br/>";
	//echo "<input type='text' name='building'>";
	//echo "<input type='text' name='room'><br/>";
	echo "<input type='submit' value='Submit'>";
	echo "</form>";
}

?>

<script>
	document.getElementById("dropdown").selectedIndex = -1;
</script>
