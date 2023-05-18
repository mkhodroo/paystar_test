<!DOCTYPE html>
<html dir="rtl">
<head>
	<title>فرم پرداخت</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script>
		function show_loading(){
			// غیرفعال کردن تمام دکمه‌ها و المان‌های قابل کلیک
			$('button, a, input[type="submit"]').prop('disabled', true);
			toastr.success("لطفا منتظر بمانید...")
		}

		function hide_loading(){
			$('button, a, input[type="submit"]').prop('disabled', false);
			preloader = preloader.remove();
			preloader = $('<i>').attr('class', 'fa fa-spinner fa-spin');
		}
	</script>
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<h2 class="text-center">فرم پرداخت</h2>
				<form id="checkout-form" action="javascript:void(0)">
                    @csrf
					<div class="form-group">
						<label for="card-number">شماره کارت</label>
						<input type="text" class="form-control" id="card-number" name="card_number" value="">
					</div>
					<div class="form-group">
						<label for="amount">مبلغ پرداختی</label>
						<input type="text" class="form-control" id="amount" name="amount" value="5000">
					</div>
					<button class="btn btn-primary btn-block" onclick="test()">پرداخت</button>
				</form>
			</div>
		</div>
	</div>

    <script>
        function test(){
			show_loading()
            var data = $('#checkout-form').serialize();
            $.ajax({
                url: "{{ route('paystar.getPayLink') }}",
                method: "POST", 
                processData: false,
                data: data,
                success: function(data){
                    toastr.success(data.message);
					window.location = data.data.url;
                }, 
                error: function(data){
					hide_loading();
                    toastr.error(data.responseJSON.message);
                }
            })
        }
    </script>

</body>
</html>
