<!DOCTYPE html>
<html dir="rtl">
<head>
	<title>صفحه بازگشت از پرداخت</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">نتیجه پرداخت</h3>
					</div>
					<div class="panel-body">
						<p>نتیجه پرداخت شما به شرح زیر است:</p>
						<hr>
                        @isset($success)
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">تراکنش موفق</h4>
                                <p>تراکنش با موفقیت انجام شد.</p>
                                <p>کد رهگیری: <strong>{{ $success['data']['tracking_code'] }}</strong></p>
                            </div>
                        @endisset
                        @isset($error)
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">تراکنش ناموفق</h4>
                                <p>{{ $error['message'] }}</p>
                                <p>شماره مرجع: <strong>{{ $error['data']['ref_num'] }}</strong></p>
                                <p>شناسه تراکنش: <strong>{{ $error['data']['paystar_transaction_id'] }}</strong></p>
                                <p>کدرهگیری تراکنش: <strong>{{ $error['data']['tracking_code'] ?? '' }}</strong></p>
                            </div>
                        @endisset
						
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
