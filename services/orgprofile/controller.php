<?php
if(filter_input(INPUT_POST, 'name')) {
	OrgProfileApi::pushUpdate($_POST);
}