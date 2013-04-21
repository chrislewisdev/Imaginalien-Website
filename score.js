function getScore()
{
	var score;
	var submission;//Get submission from form


	//Check that the word starts with the correct letter
	if(submission[0] == letterOfTheDay)
	{
		score = submission.length()
	}
	else
	{
		//Show Alert stating submission invalid
	}
	
	//Now check if the submission has any spaces
	for(var i = 0; i < submission.length(); i++)
	{
		if(submission[i] == ' ')//Space is in submission string, check next letter to make sure its the same as the letter of the day
		{
			if(submission[i+1] == letterOfTheDay)
			{
				score *= 2;
			}
			else
			{
				//Show Alert stating submission invalid
			}
		}
	}
	return score;
}

