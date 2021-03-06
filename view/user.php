<?

if($user->checkUser($user_name)){
	echo '<h1>This is '.$user_name.'\'s profile </h1>';



	$subjects = $subject->getSubjects();

	$user_info = $user->getUserInfo($user_name);

	$user_id = $user_info[0]->user_id;

	$filter_subjects = $login->getFilterSubjects($user_id);
	if(isset($filter_subjects[0]->filter_subjects)){
		$filter_subjects = array_map('intval', explode(';', $filter_subjects[0]->filter_subjects));
	}

	echo "<h2>Subjects</h2>";

	echo '<div class="list-group">';

	if(count($filter_subjects)>1){
	
		for($i=0; $i<count($filter_subjects)-1; $i++){
			if ($subjects[$filter_subjects[$i]-1]->subject_id == 42) {
				
			}else{
				echo '<a href="/user/'.$user_name.'/'.$subjects[$filter_subjects[$i]-1]->subject_id.'" class="list-group-item">'.$subjects[$filter_subjects[$i]-1]->subject_name.' ('.$subjects[$filter_subjects[$i]-1]->subject_name_short.')';


				$subject_grades = $subject->getSubjectGrades($subjects[$filter_subjects[$i]-1]->subject_id, $user_id);

				if(isset($subject_grades[0]->grade)){
					$grades_total = 0;
					$grades_number = count($subject_grades);

					for ($k=0; $k < $grades_number; $k++) { 
						$grades_total += (int)$subject_grades[$k]->grade;
					}
					$grade_avg = $grades_total/$grades_number;
					echo '<span class="badge badge-success" title="Grade Avarage: '.round($grade_avg, 2).'">'.round($grade_avg).'</span>';
				}else{
					echo '<span class="badge" title="No Grades Found">0</span>';
				}

				echo '</a>';
			}

		}
	}else{
		echo '<span class="list-group-item alert-danger">The user has no subjects selected.</span>';
	}
	echo '</div>';

}else{
	echo '<span class="alert alert-danger">User '.$user_name.' does not excist.</span>';
}
?>