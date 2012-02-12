<?php
?>
<style type="text/css">
	#container_content_header_learn_search {
		background-color: green;
		margin-left: auto;
		margin-right: auto;
		width: 500px;
	}
	#container_content_header_learn_search_text {
		position: relative;
		height: 50px;
		width: 450px;
		float: left;
		font-size: 28px;
		outline: none;
		padding-right: 60px;
		padding-left: 10px;
	}
	#container_content_header_learn_search_submit {
		position: relative;
		background: url('../assets/img/search.png') no-repeat;
		height: 50px;
		width: 50px;
		border:none;
		cursor:pointer;
		margin-top: -53px;
		margin-left: 472px;
	}
	#container_content_body {
		width: 100%;
		margin-top: 35px;
	}
	.container_content_body_group {
	}
	.container_content_body_group_name {
		font-size: 24px;
	}
	.container_content_body_group_search_value {
		color: #3DA6F4;
	}
	.container_content_body_group_result {
		width: 860px;
		background-color: #E0E0E0;
		margin-top: 20px;
		margin-bottom: 20px;
		padding: 10px;
	}
	.container_content_body_group_result_date {
		background-color: transparent;
		width: 240px;
		position: relative;
		float: left;
		margin-top: 13px;
	}
	.container_content_body_group_result_user {
		background-color: transparent;
		width: 100px;
		position: relative;
		float: left;
		overflow: hidden;
	}
	.container_content_body_group_result_date span {
		display: block;
		text-align: center;
		font-size: 20px;
	}
	.container_content_body_group_result_date_day {
		
	}
	.result_seperator {
		margin-right: 20px;
	}
	.container_content_body_group_result_user_name {
		font-size: 12px;
		margin-top: 5px;
	}
	.container_content_body_group_result_user_img {
		width: 50px;
		height: 50px;
		display: block;
		margin-left: auto;
		margin-right: auto;
		margin-bottom: 3px;
		margin-top: 3px;
	}
	.container_content_body_group_result_user_time {
		font-size: 12px;
	}
	.container_content_body_group_result_user span {
		display: block;
		text-align: center;
	}
	.container_content_body_group_result_info {
		width: 350px;
		background-color: transparent;
		float: left;
		font-size: 18px;
	}
	.container_content_body_group_result_more {
		position: relative;
		float: right;
		width: 100px;
		height: 30px;
		line-height: 30px;
		margin-right: 10px;
		margin-top: 22px;
	}
	.container_content_body_group_result_info_tech {
		width: 350px;
		background-color: green;
		float: left;
		margin-top: 10px;
		font-size: 16px;	
	}
	.container_content_body_group_result_info ul {
		float: left;
		width: 100%;
		padding: 0px;
		margin: 0px;
		list-style-type: none;
		margin-top: 10px;
		margin-left: -5px;	
	}
	.container_content_body_group_result_info li {
		display: inline;
		border-left: 1px solid #000000;
		padding-left: 5px;
		color: #3DA6F4;
		font-size: 14px;
	}
	.container_content_body_group_result_info li.first_list {
		border: none;
	}
	.container_content_body_group_result_info_title {
		font-size: 20px;
	}

</style>
<div id="container_content" class="container_bodies">
	<div id="container_content_header">
		<div id="container_content_header_learn_search">
			<form id="container_content_header_learn_search_form">
				<input type="text" id="container_content_header_learn_search_text" placeholder="search for workshop" />
				<input type="submit" id="container_content_header_learn_search_submit" value = ""/>
			</form>
		</div>
	</div>
	
	
	
	
	<div id="container_content_body">
		<div class="container_content_body_group">
			<div class="container_content_body_group_name">
				Search results for: <span class="container_content_body_group_search_value">Security JS</span>
			</div>
			<div class="container_content_body_group_results">
				<div class="container_content_body_group_result">
					<div class="container_content_body_group_result_date result_seperator">
						<span class="container_content_body_group_result_date_day">Tuesday, Feb 14th, 2012</span>
						<span class="container_content_body_group_result_date_time">10:48 AM (PST)</span>
					</div>
					<div class="container_content_body_group_result_user result_seperator">
						<img class="container_content_body_group_result_user_img" src="../assets/img/user_50.png"/>
						<span class="container_content_body_group_result_user_name">Ezra Velazquez</span>
					</div>
					<div class="container_content_body_group_result_info result_seperator">
						<span class="container_content_body_group_result_info_title">Code Security - how to protect against malevolent programmers</span>
						<ul>
							<li class="first_list">security</li>
							<li>PHP</li>
							<li>Web</li>
							<li>JS</li>
						</ul>
					</div>
					<div class="container_content_body_group_result_more button">More Info</div>
					<div class="container_clear"></div>
				</div>
				
				
				
				<div class="container_content_body_group_result">
					<div class="container_content_body_group_result_date result_seperator">
						<span class="container_content_body_group_result_date_day">Tuesday, Feb 14th, 2012</span>
						<span class="container_content_body_group_result_date_time">10:48 AM (PST)</span>
					</div>
					<div class="container_content_body_group_result_user result_seperator">
						<img class="container_content_body_group_result_user_img" src="../assets/img/user_50.png"/>
						<span class="container_content_body_group_result_user_name">Ezra Velazquez</span>
					</div>
					<div class="container_content_body_group_result_info result_seperator">
						<span class="container_content_body_group_result_info_title">Code Security - how to protect against malevolent programmers</span>
						<ul>
							<li class="first_list">security</li>
							<li>PHP</li>
							<li>Web</li>
							<li>JS</li>
						</ul>
					</div>
					<div class="container_content_body_group_result_more button">More Info</div>
					<div class="container_clear"></div>
				</div>
				
				
				
				
				<div class="container_content_body_group_result">
					<div class="container_content_body_group_result_date result_seperator">
						<span class="container_content_body_group_result_date_day">Tuesday, Feb 14th, 2012</span>
						<span class="container_content_body_group_result_date_time">10:48 AM (PST)</span>
					</div>
					<div class="container_content_body_group_result_user result_seperator">
						<img class="container_content_body_group_result_user_img" src="../assets/img/user_50.png"/>
						<span class="container_content_body_group_result_user_name">Ezra Velazquez</span>
					</div>
					<div class="container_content_body_group_result_info result_seperator">
						<span class="container_content_body_group_result_info_title">Code Security - how to protect against malevolent programmers</span>
						<ul>
							<li class="first_list">security</li>
							<li>PHP</li>
							<li>Web</li>
							<li>JS</li>
						</ul>
					</div>
					<div class="container_content_body_group_result_more button">More Info</div>
					<div class="container_clear"></div>
				</div>
				
				
				
				
				<div class="container_content_body_group_result">
					<div class="container_content_body_group_result_date result_seperator">
						<span class="container_content_body_group_result_date_day">Tuesday, Feb 14th, 2012</span>
						<span class="container_content_body_group_result_date_time">10:48 AM (PST)</span>
					</div>
					<div class="container_content_body_group_result_user result_seperator">
						<img class="container_content_body_group_result_user_img" src="../assets/img/user_50.png"/>
						<span class="container_content_body_group_result_user_name">Ezra Velazquez</span>
					</div>
					<div class="container_content_body_group_result_info result_seperator">
						<span class="container_content_body_group_result_info_title">Code Security - how to protect against malevolent programmers</span>
						<ul>
							<li class="first_list">security</li>
							<li>PHP</li>
							<li>Web</li>
							<li>JS</li>
						</ul>
					</div>
					<div class="container_content_body_group_result_more button">More Info</div>
					<div class="container_clear"></div>
				</div>
				
				
				<div class="container_content_body_group_result">
					<div class="container_content_body_group_result_date result_seperator">
						<span class="container_content_body_group_result_date_day">Tuesday, Feb 14th, 2012</span>
						<span class="container_content_body_group_result_date_time">10:48 AM (PST)</span>
					</div>
					<div class="container_content_body_group_result_user result_seperator">
						<img class="container_content_body_group_result_user_img" src="../assets/img/user_50.png"/>
						<span class="container_content_body_group_result_user_name">Ezra Velazquez</span>
					</div>
					<div class="container_content_body_group_result_info result_seperator">
						<span class="container_content_body_group_result_info_title">Code Security - how to protect against malevolent programmers</span>
						<ul>
							<li class="first_list">security</li>
							<li>PHP</li>
							<li>Web</li>
							<li>JS</li>
						</ul>
					</div>
					<div class="container_content_body_group_result_more button">More Info</div>
					<div class="container_clear"></div>
				</div>
				
				
				
				<div class="container_content_body_group_result">
					<div class="container_content_body_group_result_date result_seperator">
						<span class="container_content_body_group_result_date_day">Tuesday, Feb 14th, 2012</span>
						<span class="container_content_body_group_result_date_time">10:48 AM (PST)</span>
					</div>
					<div class="container_content_body_group_result_user result_seperator">
						<img class="container_content_body_group_result_user_img" src="../assets/img/user_50.png"/>
						<span class="container_content_body_group_result_user_name">Ezra Velazquez</span>
					</div>
					<div class="container_content_body_group_result_info result_seperator">
						<span class="container_content_body_group_result_info_title">Code Security - how to protect against malevolent programmers</span>
						<ul>
							<li class="first_list">security</li>
							<li>PHP</li>
							<li>Web</li>
							<li>JS</li>
						</ul>
					</div>
					<div class="container_content_body_group_result_more button">More Info</div>
					<div class="container_clear"></div>
				</div>
				
				
				
				<div class="container_content_body_group_result">
					<div class="container_content_body_group_result_date result_seperator">
						<span class="container_content_body_group_result_date_day">Tuesday, Feb 14th, 2012</span>
						<span class="container_content_body_group_result_date_time">10:48 AM (PST)</span>
					</div>
					<div class="container_content_body_group_result_user result_seperator">
						<img class="container_content_body_group_result_user_img" src="../assets/img/user_50.png"/>
						<span class="container_content_body_group_result_user_name">Ezra Velazquez</span>
					</div>
					<div class="container_content_body_group_result_info result_seperator">
						<span class="container_content_body_group_result_info_title">Code Security - how to protect against malevolent programmers</span>
						<ul>
							<li class="first_list">security</li>
							<li>PHP</li>
							<li>Web</li>
							<li>JS</li>
						</ul>
					</div>
					<div class="container_content_body_group_result_more button">More Info</div>
					<div class="container_clear"></div>
				</div>
			</div>
		</div>
	</div>
</div>