<?php
function emp_login($e_id, $pass, $url){ 
$html = '
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting"> 
    <title>
		SUPER HOME EMPLOYEE INFORMATION
	</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,300,400,500,600,700" rel="stylesheet">
    <link href="'.$url.'application/helpers/email_template/style_1.css" rel="stylesheet">
</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly;">
	<center style="width: 100%; background-color: #f1f1f1;">
		<div style="max-width: 600px; margin: 0 auto;" class="email-container">
			<table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
				<tr>
					<td valign="middle" class="hero bg_white" style="background-image: url('.$url.'assets/email_template/email_background_1.png); background-size: cover; height: 400px;">
						<div class="overlay"></div>
						<table>
							<tr>
								<td>
									<div class="text" style="padding: 0 4em; text-align: center;">
										<h2>Welcome To our NEWAYS Family</h2>
										<p>
											Your Login information <br />
											<b>Employee ID: '.$e_id.'</b> <br />
											<b>Password: '.$pass.'</b>
										</p>
										<p><a href="'.$url.'admin" class="btn btn-primary">Login Now</a></p>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</center>
</body>
</html>';

return $html;

}