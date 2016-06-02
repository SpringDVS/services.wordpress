<?php
if(filter_input(INPUT_POST, 'title')) {
	BulletinApi::pushNew($_POST);
} else if(($key = filter_input(INPUT_GET, 'key')) && filter_input(INPUT_GET, 'task') == "rem") {
	BulletinApi::pushRem($key);
}