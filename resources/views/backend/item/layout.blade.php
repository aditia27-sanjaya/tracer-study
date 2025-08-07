<!doctype html>
<html lang="en">

<head>
	@include('backend/item/css')
</head>

<body>

	<div class="wrapper">

		@include('backend/item/loader')

		@include('backend/item/sidebar')

		@include('backend/item/header')

		@yield('content')

		@include('backend/item/footer')
	</div>

    @include('backend/item/modal')

	@include('backend/item/js')
</body>

</html>
